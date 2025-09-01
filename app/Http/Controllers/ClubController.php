<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ClubController extends Controller
{
   public function downloadCertificate($id)
{
    $club = Club::findOrFail($id);

    if ($club->status != 1) {
        abort(403, 'Club is not part of Akuatik Indonesia.');
    }

    $pdf = Pdf::loadView('pdf.certificate', compact('club'));
    return $pdf->download("certificate_{$club->name}.pdf");
}
  public function index()
    {
        $clubs = Club::all();
        return response()->json([
            'status' => 'success',
            'message' => 'clubs retrieved successfully',
            'data' => $clubs
        ], 200); // Kode status HTTP 200 OK
    }
}
