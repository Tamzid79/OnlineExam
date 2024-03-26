<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function questions(){
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
    
    public function submissions(){
        return $this->hasMany(Submission::class);
    }
    
    public function temps(){
        return $this->hasMany(Temp::class);
    }
}