<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
