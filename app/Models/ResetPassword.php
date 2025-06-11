<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;

protected $fillable = [
    'nama',
    'user_id',
    'tanggal_permohonan',
    'waktu_permohonan', // ✅ tambahkan ini
    'keterangan',
    'status',
];
}
