<?php

namespace App\Exports;

use App\Models\ResetPassword;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResetPasswordExport implements FromCollection, WithHeadings
{
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($tanggalAwal, $tanggalAkhir)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        return ResetPassword::whereBetween('tanggal_permohonan', [
            $this->tanggalAwal,
            $this->tanggalAkhir,
        ])->get([
            'nama',
            'user_id',
            'tanggal_permohonan',
            'waktu_permohonan',
            'status',
            'keterangan',
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'User ID',
            'Tanggal Permohonan',
            'Waktu Permohonan',
            'Status',
            'Keterangan',
        ];
    }
}
