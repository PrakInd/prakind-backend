<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    public function group()
    {
        return $this->belongsTo('\App\Models\Group');
    }

    public function institution()
    {
        return $this->belongsTo('\App\Models\Institution', 'institution_id');
    }

    public function application()
    {
        return $this->hasMany('\App\Models\Application');
    }
}
