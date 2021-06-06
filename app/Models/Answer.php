<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','value'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function lessons()
    {
        return $this->morphedByMany(Lesson::class, 'answerable');
    }

    public function colleges()
    {
        return $this->morphedByMany(College::class, 'answerable');
    }

    public function allEducations()
    {
        return $this->morphedByMany(AllEducation::class, 'answerable');
    }

    public function answers()
    {
        return $this->hasMany(Answerable::class);
    }
}
