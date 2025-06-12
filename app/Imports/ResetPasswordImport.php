<?php

namespace App\Imports;

use App\Models\ResetPassword;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResetPasswordImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ResetPassword([
            'nama' => $row['nama'],
            'user_id' => $row['user_id'],
            'tanggal_permohonan' => $row['tanggal_permohonan'],
            'waktu_permohonan' => $row['waktu_permohonan'],
            'status' => $row['status'],
            'keterangan' => $row['keterangan'],
        ]);
    }
}
