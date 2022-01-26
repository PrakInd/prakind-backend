<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function application()
    {
        return $this->hasMany('\App\Models\Application');
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company');
    }

    // public function certificate()
    // {
    //     return $this->hasOne('\App\Models\Certificate');
    // }
}
