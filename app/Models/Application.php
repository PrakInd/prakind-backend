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
        return $this->belongsTo('\App\Models\Profile', 'profile_id');
    }

    public function vacancy()
    {
        return $this->belongsTo('\App\Models\Vacancy', 'vacancy_id');
    }

    public function applicant_file()
    {
        return $this->hasOne('\App\Models\ApplicantFile');
    }

    public function group()
    {
        return $this->belongsTo('\App\Models\Group', 'group_id');
    }
}
