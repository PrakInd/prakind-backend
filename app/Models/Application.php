<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function profile()
    {
        return $this->belongsTo('\App\Models\Profile');
    }

    public function vacancy()
    {
        return $this->belongsTo('\App\Models\Vacancy');
    }

    public function applicant_file()
    {
        return $this->hasOne('\App\Models\ApplicantFile');
    }

    public function group()
    {
        return $this->belongsTo('\App\Models\Group');
    }

    // public function certificate()
    // {
    //     return $this->belongsTo('\App\Models\Certificate');
    // }
}
