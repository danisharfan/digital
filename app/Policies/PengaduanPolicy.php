<?php

namespace App\Policies;

use App\Models\Pengaduan;
use App\Models\User;

class PengaduanPolicy
{
    public function view(User $user, Pengaduan $pengaduan)
    {
        return $user->id === $pengaduan->id_user;
    }

    public function update(User $user, Pengaduan $pengaduan)
    {
        return $user->id === $pengaduan->id_user && $pengaduan->status === 'pending';
    }

    public function delete(User $user, Pengaduan $pengaduan)
    {
        return $user->id === $pengaduan->id_user && $pengaduan->status === 'pending';
    }
}