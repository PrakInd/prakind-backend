<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function application()
    {
        return $this->hasMany('\App\Models\Application');
    }

    public function vacancy()
    {
        return $this->belongsTo('\App\Models\Vacancy');
    }
}
