<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- SOLUSI: TAMBAHKAN BARIS INI
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory; // <-- Kode ini sekarang akan berfungsi dengan benar

    // Relasi ke model User (pengirim)
    public function fromUser()
    {
        // Catatan: Pastikan Anda juga sudah "use App\Models\User;" di atas
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // Relasi ke model User (penerima)
    public function toUser()
    {
        // Catatan: Pastikan Anda juga sudah "use App\Models\User;" di atas
        return $this->belongsTo(User::class, 'to_user_id');
    }
}