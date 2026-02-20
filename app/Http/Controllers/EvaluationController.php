<?php

namespace App\Http\Controllers;

use App\Models\CriteriaScore;
use App\Models\DigitalApproval;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\EvaluationCriteria;

class EvaluationController extends Controller
{
    /**
     * Store multiple evaluations with criteria scores and digital approval
     */
public function store(Request $request)
{
    DB::beginTransaction();

    try {
        foreach ($request->evaluations as $evalData) {
            // Validate PO number
            if (empty($evalData['po_no'])) {
                throw new \Exception('PO number is required.');
            }

            if (Evaluation::where('po_no', $evalData['po_no'])->exists()) {
                throw new \Exception("Duplicate PO number detected: {$evalData['po_no']}.");
            }

            // Handle the custom 'date_evaluation' provided by the user
            $dateEvaluation = $evalData['date_evaluation']; // this is the custom date

            // Convert it to Asia/Manila timezone if it's not already in that timezone
            $dateEvaluation = Carbon::parse($dateEvaluation)->timezone('Asia/Manila');

            $evaluation = Evaluation::create([
                'supplier_name'   => $evalData['supplier_name'],
                'po_no'           => $evalData['po_no'],
                'date_evaluation' => $dateEvaluation, // Store the custom date
                'covered_period'  => $evalData['covered_period'],
                'office_name'     => $evalData['office_name'],
            ]);

            foreach ($evalData['criteria'] as $criteriaData) {
                if (empty($criteriaData['rating'])) {
                    throw new \Exception("Rating for criteria ID {$criteriaData['criteria_id']} is required.");
                }

                // Validate criteria ID exists in the evaluation_criteria table
                if (!EvaluationCriteria::where('id', $criteriaData['criteria_id'])->exists()) {
                    throw new \Exception("Invalid criteria ID {$criteriaData['criteria_id']} provided.");
                }

                CriteriaScore::create([
                    'evaluation_id' => $evaluation->id,
                    'criteria_id'   => $criteriaData['criteria_id'],
                    'number_rating' => $criteriaData['rating'],
                    'remarks'       => $criteriaData['remarks'] ?? '',
                ]);
            }

            if (!empty($request->evaluator)) {
                $imageUrl = null;

                if (!empty($request->evaluator['image'])) {
                    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->evaluator['image']));
                    if ($imageData === false) {
                        throw new \Exception('Invalid evaluator image data.');
                    }

                    $fileName = 'evaluation_signatures/' . Str::uuid() . '.png';
                    $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
                    $supabaseKey = env('SUPABASE_SERVICE_ROLE_KEY');
                    $bucket = 'image';

                    $response = Http::withHeaders([
                        'apikey' => $supabaseKey,
                        'Authorization' => 'Bearer ' . $supabaseKey,
                        'Content-Type' => 'image/png',
                    ])->withBody($imageData, 'image/png')
                      ->put("$supabaseUrl/storage/v1/object/$bucket/$fileName");

                    if (!$response->successful()) {
                        throw new \Exception('Supabase upload failed: ' . $response->body());
                    }

                    $imageUrl = "$supabaseUrl/storage/v1/object/public/$bucket/$fileName";
                }

                DigitalApproval::create([
                    'evaluation_id' => $evaluation->id,
                    'full_name'     => $request->evaluator['name'],
                    'designation'   => $request->evaluator['designation'],
                    'role'          => 'Prepared By',
                    'image'         => $imageUrl,
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Evaluation saved successfully!'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error during evaluation save', ['error_message' => $e->getMessage()]);

        $userFriendlyMessage = 'An unexpected error occurred while saving the evaluation.';

        // Customize message if it's a validation/required field error
        if (str_contains($e->getMessage(), 'required') || str_contains($e->getMessage(), 'Rating') || str_contains($e->getMessage(), 'Invalid criteria ID')) {
            $userFriendlyMessage = 'Please fill out all required fields correctly before submitting the evaluation.';
        }

        return response()->json([
            'success' => false,
            'message' => $userFriendlyMessage
        ], 500);
    }
}

    /**
     * List all evaluations with overall rating, status, and evaluator
     */
public function list()
{
    try {

        $user = auth()->user();
        $userDepartment = $user->department ?? null;
        $userRole = strtolower($user->role ?? '');

        // =========================
        // ROLE-BASED FILTERING
        // =========================
        if ($userRole === 'administrator') {
            // Admin can see ALL evaluations, paginate and order by date_evaluation
            $evaluations = Evaluation::with('criteriaScores', 'digitalApprovals')
                ->orderBy('date_evaluation', 'asc') // Order by date_evaluation ascending
                ->paginate(10); // Paginate to show 10 evaluations per page
        } else {
            // Normal users see only their department, paginate and order by date_evaluation
            $evaluations = Evaluation::with('criteriaScores', 'digitalApprovals')
                ->where('office_name', $userDepartment)
                ->orderBy('date_evaluation', 'asc') // Order by date_evaluation ascending
                ->paginate(10); // Paginate to show 10 evaluations per page
        }

        $result = $evaluations->map(function ($eval) {

            // Initialize criteria scores
            $criteriaScores = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
            ];

            foreach ($eval->criteriaScores as $score) {
                $criteriaScores[$score->criteria_id] = $score->number_rating;
            }

            // Weighted calculation
            $poScore = (5 * $criteriaScores[1]) +
                       (7.5 * $criteriaScores[2]) +
                       (6.25 * $criteriaScores[3]) +
                       (6.25 * $criteriaScores[4]);

            // Check if Head has approved
            $headApproval = $eval->digitalApprovals
                ->firstWhere('role', 'Head');

            // Determine status
            if (!$headApproval) {
                $status = 'For HEAD REVIEW';
            } else {
                $status = $poScore >= 60 ? 'Approved' : 'Fail!';
            }

            // Prepared By
            $evaluator = $eval->digitalApprovals
                ->firstWhere('role', 'Prepared By');

            return [
                'id' => $eval->id,
                'supplier_name' => $eval->supplier_name,
                'po_no' => $eval->po_no,
                'date_evaluation' => $eval->date_evaluation,
                'department' => $eval->office_name,
                'eval_score' => round($poScore, 2),
                'status' => $status,
                'evaluator' => $evaluator ? $evaluator->full_name : 'N/A',
                'digital_approvals' => $eval->digitalApprovals, // important for JS logic
            ];
        });

        return response()->json([
            'evaluations' => $result,
            'pagination' => [
                'current_page' => $evaluations->currentPage(),
                'last_page' => $evaluations->lastPage(),
                'per_page' => $evaluations->perPage(),
                'total' => $evaluations->total(),
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch evaluations: ' . $e->getMessage()
        ], 500);
    }
}






public function show($id)
{
    // Load the evaluation along with criteriaScores and digitalApprovals
    $evaluation = Evaluation::with('criteriaScores', 'digitalApprovals')->findOrFail($id);

    // Assuming one evaluator per evaluation (modify if needed)
    $evaluator = $evaluation->digitalApprovals->first();

    // Include evaluator details in the response
    return response()->json([
        'evaluation' => $evaluation,
        'evaluator' => $evaluator
    ]);
}


public function downloadPdf($id)
{
    $evaluation = Evaluation::with('criteriaScores', 'digitalApprovals')->findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.evaluation', compact('evaluation'));

    return $pdf->download("evaluation_{$evaluation->id}.pdf");
}

}
