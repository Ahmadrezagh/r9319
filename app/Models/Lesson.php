<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function master()
    {
        return $this->belongsToMany(User::class,'lesson_master');
    }

    public function students()
    {
        return $this->belongsToMany(User::class,'lesson_student');
    }

    public function forms()
    {
        return $this->morphToMany(Form::class, 'formable','formables');
    }
}
