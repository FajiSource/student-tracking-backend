<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    //

    protected $fillable = [
        'level'
    ];
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
    
}
