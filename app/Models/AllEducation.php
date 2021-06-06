<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllEducation extends Model
{
    use HasFactory;
    public function answers()
    {
        return $this->morphToMany(Answer::class, 'answerable');
    }
}
