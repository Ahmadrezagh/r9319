<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Form;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ((Auth::user()->isAdmin() && Auth::user()->can('Forms')) || Auth::user()->isSuperAdmin())
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
        $forms = Form::query()->latest()->get();
        return view('admin.forms.index',compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lessons = Lesson::query()->latest()->get();
        $colleges = College::query()->latest()->get();
        return view('admin.forms.create_edit',compact('lessons','colleges'));
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
            'name' => 'required'
        ]);
        $form = Form::create([
            'name' => $request->name,
            'feds' => $request->feds ?? 0
        ]);
        if($request->lessons)
        {
            if(in_array(-1,$request->lessons) )
            {
                $lessons = Lesson::query()->pluck('id')->toArray();
                $form->lessons()->sync($lessons);
            }else{
                $form->lessons()->sync($request->lessons);
            }
        }else{
            $form->lessons()->detach();
        }
        if($request->colleges)
        {
            if(in_array(-1,$request->colleges) )
            {
                $colleges = College::query()->pluck('id')->toArray();
                $form->colleges()->sync($colleges);
            }else{
                $form->colleges()->sync($request->colleges);
            }
        }else{
            $form->colleges()->detach();
        }
        $form->questions()->delete();
        foreach ($request->questions as $q)
        {
            $form->questions()->create([
                'question' => $q
            ]);
        }
        alert()->success('فرم با موفقیت ایجاد شد');
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
        $form = Form::findOrFail($id);
        $lessons = Lesson::query()->latest()->get();
        $colleges = College::query()->latest()->get();
        return view('admin.forms.create_edit',compact('form','lessons','colleges'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $form = Form::findOrFail($id);
        $request->validate([
            'name' => 'required'
        ]);
        $form->update([
            'name' => $request->name,
            'feds' => $request->feds ?? 0
        ]);
        if($request->lessons)
        {
            if(in_array(-1,$request->lessons) )
            {
                $lessons = Lesson::query()->pluck('id')->toArray();
                $form->lessons()->sync($lessons);
            }else{
                $form->lessons()->sync($request->lessons);
            }
        }else{
            $form->lessons()->detach();
        }
        if($request->colleges)
        {
            if(in_array(-1,$request->colleges) )
            {
                $colleges = College::query()->pluck('id')->toArray();
                $form->colleges()->sync($colleges);
            }else{
                $form->colleges()->sync($request->colleges);
            }
        }else{
            $form->colleges()->detach();
        }
        $form->questions()->delete();
        foreach ($request->questions as $q)
        {
            $form->questions()->create([
                'question' => $q
            ]);
        }
        alert()->success('فرم با موفقیت ویرایش شد');
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
        $form = Form::findOrFail($id);
        $form->delete();
        alert()->success('فرم با موفقیت حذف شد');
        return back();
    }
}
