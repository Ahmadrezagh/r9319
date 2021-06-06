<?php

namespace App\Models;

use App\Services\Permission\Traits\HasPermissions;
use App\Services\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles, HasPermissions;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function isSuperAdmin()
    {
        return $this->type_id == 1  ? true : false;
    }
    //  Admin
    //  Get Admins
    public function scopeAdmins($query)
    {
        return $query->where('type_id', 2);
    }

    //  Check is admin
    public function isAdmin()
    {
        return $this->type_id == 2  ? true : false;
    }

    // if user is admin , show admin's role
    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    //
    //  User
    // Get All users
    public function scopeUsers($query)
    {
        return $query->where('type_id', 3);
    }

    // Check is user
    public function isUser()
    {
        return $this->type_id == 3  ? true : false;
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }

    public function profile()
    {
        return $this->profile ?? '/uploads/profiles/default/user.png';
    }

    public function colleges()
    {
        return $this->belongsToMany(College::class,'college_master');
    }

    public function masterLesson()
    {
        return $this->belongsToMany(Lesson::class,'lesson_master');
    }
    public function studentLessons()
    {
        return $this->belongsToMany(Lesson::class,'lesson_student');
    }

    public function scopeStudents(Builder $query)
    {
        return $query->whereHas('role',function ($_query){
            return $_query->where('name','دانشجو');
        })->get();
    }
    public function scopeFinishedStudents(Builder $query)
    {
        return $query->whereHas('role',function ($_query){
            return $_query->where('name','فارغ التحصیل');
        })->get();
    }
    public function scopeMasters(Builder $query)
    {
        return $query->whereHas('role',function ($_query){
            return $_query->where('name','استاد');
        });
    }

    public function isMaster()
    {
        if($this->role()->first()->name == 'استاد')
        {
            return true;
        }
        return false;
    }
    public function isStudent()
    {
        if($this->role()->first()->name == 'دانشجو')
        {
            return true;
        }
        return false;
    }
    public function isFinishedStudent()
    {
        if($this->role()->first()->name == 'فارغ التحصیل')
        {
            return true;
        }
        return false;
    }
    public function CompletedForm($formId,$formType)
    {
        return DB::table('answerables')->where('user_id',$this->id)->where('answerable_id',$formId)->where('answerable_type',$formType)->first() ? true : false ;
    }

    public function CompletedFormAllEducation()
    {
        return DB::table('answerables')->where('user_id',$this->id)->where('answerable_id',1)->where('answerable_type','App\Models\AllEducation')->first() ? true : false ;
    }

    public function studentColleges()
    {
        $lessons = $this->studentLessons;
        $college_ids = [];
        foreach ($lessons as $lesson)
        {
             foreach ($lesson->master->first()->colleges->pluck('id') as $id)
             {
                 if(!in_array($id,$college_ids))
                 {
                     array_push($college_ids,$id);
                 }
             }
        }
        return College::whereIn('id',$college_ids)->get();
    }

    public function masterColleges()
    {
        $lessons = $this->masterLesson;
        $college_ids = [];
        foreach ($lessons as $lesson)
        {
            foreach ($lesson->master->first()->colleges->pluck('id') as $id)
            {
                if(!in_array($id,$college_ids))
                {
                    array_push($college_ids,$id);
                }
            }
        }
        return College::whereIn('id',$college_ids)->get();
    }

    public function vote()
    {
        $lessons = $this->masterLesson()->get();
        $vote = 0;
        foreach ($lessons as $lesson)
        {
            $vote += $lesson->vote();
        }
        if(count($lessons) > 0)
        {
            $vote = $vote/count($lessons);
        }
        return $vote;
    }

    public function answers()
    {
        return $this->hasMany(Answerable::class);
    }
}
