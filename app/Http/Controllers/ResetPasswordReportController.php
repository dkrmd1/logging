<?php

namespace App\Http\Controllers;

use App\Models\ResetPassword;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ResetPasswordReportController extends Controller
{
    public function generate(Request $request)
    {
        $query = ResetPassword::query();

        // Cek apakah ada filter bulan dan tahun
        if ($request->has('bulan') && $request->bulan) {
            $query->whereMonth('tanggal_permohonan', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('tanggal_permohonan', $request->tahun);
        }

        // Ambil data sesuai filter
        $data = $query->orderBy('tanggal_permohonan', 'desc')->get();

        // Generate PDF
        $pdf = Pdf::loadView('reports.reset_passwords', compact('data'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-reset-passwords.pdf');
    }
}
