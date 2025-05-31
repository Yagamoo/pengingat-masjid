<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Pesan extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = ['waktu', 'pesan_sebelum', 'pesan', 'aktif'];

    // public function items()
    // {
    //     return $this->hasMany(UcapanItem::class);
    // }
}
