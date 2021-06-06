<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function masters()
    {
        return $this->belongsToMany(User::class,'college_master');
    }

    public function forms()
    {
        return $this->morphToMany(Form::class, 'formable','formables');
    }
    public function form()
    {
        return $this->forms->first();
    }

    public function answers()
    {
        return $this->morphToMany(Answer::class, 'answerable');
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
