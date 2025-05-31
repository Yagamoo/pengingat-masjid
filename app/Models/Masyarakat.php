<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Masyarakat extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = ['nama', 'no_hp', 'gender', 'id_kabupaten'];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten');
    }
}
