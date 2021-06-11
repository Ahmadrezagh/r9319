<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answerable;
use App\Models\College;
use App\Models\Role;
use App\Models\User;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollegeController extends Controller
{
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if ((Auth::user()->isAdmin() && Auth::user()->can('College')) || Auth::user()->isSuperAdmin())
            {
                return $next($request);
            }else{
                abort(404);
            }
        });

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colleges = College::all();
        $masters = User::query()->whereHas('role',function ($query){
            return $query->where('name', '=','استاد');
        })->get();
        return view('admin.colleges.index',compact('colleges','masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        College::create([
            'name' => $request->name
        ]);
        alert()->success('مرکز آموزشی با موفقیت ایجاد شد');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $college = College::findOrFail($id);
        $roles_name = Role::where('type',2)->pluck('name')->toArray();
        $votes = [];
        $roles = Role::all();
        foreach ($roles as $role)
        {
            $ids = $role->user()->pluck('id');
            $answers = Answerable::query()->whereIn('user_id',$ids)
                ->where('answerable_id',$id)
                ->where('answerable_type',get_class($college))
                ->get();
            if($role->name == 'کارمند بخش آموزش')
            {
                $answers = Answerable::query()->whereIn('user_id',$ids)
                    ->where('answerable_id','1')
                    ->where('answerable_type','App\Models\AllEducation')
                    ->get();
            }
            $v = 0;
            foreach ($answers as $answer)
            {
                $v += $answer->answer->value;
            }
            if(count($answers)>0)
            {
                $v = $v / count($answers);
            }
            array_push($votes,$v);
        }
        foreach ($roles_name as $key => $item)
        {
            $roles_name[$key] = $roles_name[$key];
        }
        $chart = Chartisan::build()
            ->labels($roles_name)
            ->dataset('نظر سنجی دانشکده', $votes)
            ->toJSON();


        return view('admin.colleges.result',compact('college','chart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $college = College::findOrFail($id);
        $college->update([
            'name' => $request->name
        ]);
        if(($request->masters))
        {
            $college->masters()->sync($request->masters);
        }else{
            $college->masters()->detach();
        }
        alert()->success('مرکز آموزشی با موفقیت ویرایش شد');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        College::findOrfail($id)->delete();
        alert()->success('مرکز آموزشی با موفقیت حذف شد');
        return back();
    }
}
