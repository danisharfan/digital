<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'id_user',
        'judul',
        'isi_laporan',
        'foto',
        'status',
        'tanggal_lapor',
        'feedback',
        'feedback_at',
    ];

    protected $casts = [
        'tanggal_lapor' => 'datetime',
        'feedback_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}