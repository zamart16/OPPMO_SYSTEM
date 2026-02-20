<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function downloadPdf($id)
    {
        $evaluation = Evaluation::with('criteriaScores', 'digitalApprovals')->findOrFail($id);

        // Prepare data for the PDF view
        $data = [
            'evaluation' => $evaluation,
            // Add other details you want to include in the PDF
        ];

        // Generate PDF from a Blade view (pdf.evaluation)
        $pdf = Pdf::loadView('pdf.evaluation', $data)
                  ->setPaper('a4', 'portrait');

        // Download with filename
        return $pdf->download("evaluation_{$id}.pdf");
    }
}
