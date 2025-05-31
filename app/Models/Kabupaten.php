<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Kabupaten extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = ['nama', 'api_id'];

    public function masyarakat()
    {
        return $this->hasMany(Masyarakat::class);
    }

}
