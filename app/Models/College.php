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
}
