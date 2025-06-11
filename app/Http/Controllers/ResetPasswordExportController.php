<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetPassword;
use Barryvdh\DomPDF\Facade\Pdf;

class ResetPasswordExportController extends Controller
{
    public function export(Request $request)
    {
        $query = ResetPassword::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_permohonan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_permohonan', $request->tahun);
        }

        $data = $query->get();

        // Pastikan variabel di Blade adalah $records
        $pdf = Pdf::loadView('exports.reset-passwords', ['records' => $data]);

        return $pdf->download('reset-passwords.pdf');
    }
}
