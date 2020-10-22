<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function random()
    {
        return $this->belongsTo('App\Models\Random');
    }
}
