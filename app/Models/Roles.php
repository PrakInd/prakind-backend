<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const IS_ADMIN = 1; 
    public const IS_PELAMAR = 2; 

    public function user()
    {
        return $this->hasMany('\App\Models\User');
    }
}
