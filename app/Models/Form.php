<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'feds'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function colleges()
    {
        return $this->morphedByMany(College::class, 'formable','formables');
    }

    public function lessons()
    {
        return $this->morphedByMany(Lesson::class, 'formable','formables');
    }
}
