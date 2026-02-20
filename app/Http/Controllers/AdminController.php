<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CriteriaScore;
use App\Models\DigitalApproval;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

public function store(Request $request)
{
    DB::beginTransaction();

    try {
        foreach ($request->evaluations as $evalData) {
            // Check for duplicate PO number
            $existingPO = Evaluation::where('po_no', $evalData['po_no'])->first();
            if ($existingPO) {
                return response()->json([
                    'success' => false,
                    'message' => "Duplicate PO number detected: {$evalData['po_no']}."
                ], 422);
            }

            // Save evaluation
            $evaluation = Evaluation::create([
                'supplier_name'   => $evalData['supplier_name'],
                'po_no'           => $evalData['po_no'],
                'date_evaluation' => $evalData['date_evaluation'],
                'covered_period'  => $evalData['covered_period'],
                'office_name'     => $evalData['office_name'],
            ]);

            // Save criteria scores
            foreach ($evalData['criteria'] as $criteriaData) {
                CriteriaScore::create([
                    'evaluation_id' => $evaluation->id,
                    'criteria_id'   => $criteriaData['criteria_id'],
                    'number_rating' => $criteriaData['rating'],
                    'remarks'       => $criteriaData['remarks'] ?? '',
                ]);
            }

            // Save digital approval (Prepared By)
            if (!empty($request->evaluator)) {
                $imageUrl = null;

                if (!empty($request->evaluator['image'])) {
                    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->evaluator['image']));
                    if ($imageData === false) {
                        throw new \Exception('Invalid evaluator image data.');
                    }

                    // Log the image for debugging
                    Log::info('Evaluator image data received', ['image_data' => $request->evaluator['image']]);

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
                        Log::error('Supabase upload failed', ['response' => $response->body()]);
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
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
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
            // Admin can see ALL evaluations
            $evaluations = Evaluation::with('criteriaScores', 'digitalApprovals')
                ->get();
        } else {
            // Normal users see only their department
            $evaluations = Evaluation::with('criteriaScores', 'digitalApprovals')
                ->where('office_name', $userDepartment)
                ->get();
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

        return response()->json($result);

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


public function getInactiveUsers()
{
    // Fetch users with 'inactive' status
    $inactiveUsers = User::where('status', 'inactive')->get();

    // Return the list of inactive users as JSON
    return response()->json($inactiveUsers);
}

public function activateUser($id)
{
    $user = User::findOrFail($id);
    $user->status = 'active';
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'User activated successfully.'
    ]);
}

}
