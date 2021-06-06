<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function answers()
    {
        return $this->morphToMany(Answer::class, 'answerable');
    }

    public function form()
    {
        return $this->forms->first();
    }

    public function vote()
    {
        if(count($this->answers()->get())>0)
        {
            return $this->answers()->sum('value')/$this->answers()->count();
        }
        return 0;
    }
}
