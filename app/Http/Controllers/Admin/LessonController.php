<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if ((Auth::user()->isAdmin() && Auth::user()->can('Lesson')) || Auth::user()->isSuperAdmin())
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
        $lessons = Lesson::all();
        $masters = User::query()->whereHas('role',function ($query){
            return $query->where('name', '=','استاد');
        })->get();
        return view('admin.lessons.index',compact('lessons','masters'));
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
            'master' => 'required'
        ]);
        $lesson = Lesson::create([
            'name' => $request->name
        ]);
        $lesson->master()->sync([$request->master]);
        alert()->success(' درس با موفقیت ایجاد شد');
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
        //
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
        $lesson = Lesson::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'master' => 'required'
        ]);
        $lesson->update([
            'name' => $request->name
        ]);
        $lesson->master()->sync([$request->master]);
        alert()->success(' درس با موفقیت ویرایش شد');
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
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        alert()->success(' درس با موفقیت حذف شد');
        return back();
    }
}
