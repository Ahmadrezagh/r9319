<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Models\Answer;
use App\Models\Answerable;
use App\Models\Category;
use App\Models\College;
use App\Models\Form;
use App\Models\Lesson;
use App\Models\Role;
use App\Models\User;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
        {
            // Chart
            $colleges_name = College::query()->pluck('name')->toArray();
            $colleges = College::all();
            $votes = [];
            foreach ($colleges as $college)
            {
                array_push($votes,$college->vote());
            }
            foreach ($colleges_name as $key => $item)
            {
                $colleges_name[$key] = $colleges_name[$key];
            }
            $chart = Chartisan::build()
                ->labels($colleges_name)
                ->dataset('نظر سنجی دانشکده', $votes)
                ->toJSON();



            $roles_name = Role::where('type',2)->pluck('name')->toArray();
            $votes = [];
            $roles = Role::all();
            foreach ($roles as $role)
            {
                $ids = $role->user()->pluck('id');
                $answers = Answerable::query()->whereIn('user_id',$ids)
                    ->get();

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
            foreach ($roles_name as $key => $item){
                $roles_name[$key] = $roles_name[$key];
            }
            $chart3 = Chartisan::build()
                ->labels($roles_name)
                ->dataset('نظر سنجی دانشکده', $votes)
                ->toJSON();



            return view('admin.index',compact('chart','chart3'));
        }elseif(Auth::user()->isUser())
        {
            if(Auth::user()->isMaster())
            {
                $answers_name = Answer::query()->pluck('name')->toArray();
                $answers = Answer::all();
                $votes = [];
                $all_votes = 0;
                foreach ($answers as $answer)
                {
                    $v = 0;
                    foreach (Auth::user()->masterLesson as $lesson)
                    {
                        $v += $lesson->answers()->where('answer_id','=',$answer->id)->count();
                        $all_votes += $v;
                    }
                    array_push($votes,$v);
                }
                if($all_votes>0)
                {
                    foreach ($votes as $key => $vote)
                    {
                        $votes[$key] = ($vote/$all_votes) * 100;
                        $answers_name[$key] = $answers_name[$key]."(".intval($votes[$key])."%)";
                    }
                }
                $chart = Chartisan::build()
                    ->labels($answers_name)
                    ->dataset('نظر سنجی اساتید', $votes)
                ->toJSON();
                //
                $lessons = Auth::user()->masterLesson;
                $questions_name = [];
                $questions_values = [];
                foreach ($lessons as $lesson)
                {
                    if($lesson->form())
                    {
                        foreach ($lesson->form()->questions as $question)
                        {
                            if(!in_array($question->question , $questions_name))
                            {
                                array_push($questions_name,$question->question);
                                $answers = Answerable::query()
                                    ->where('question_id',$question->id)
                                    ->where('answerable_type','App\Models\Lesson')
                                    ->where('answerable_id',$lesson->id)
                                    ->get();
                                $v = 0;
                                foreach ($answers as $answer)
                                {
                                    $v += $answer->answer->value;
                                }
                                if(count($answers)>0)
                                {
                                    $v = $v/count($answers);
                                }
                                array_push($questions_values,$v);
                            }
                        }
                    }
                }
                $chart2 = Chartisan::build()
                    ->labels($questions_name)
                    ->dataset('نظر سنجی اساتید', $questions_values)
                    ->toJSON();



                return view('user.index',compact('chart','chart2'));
            }
            return view('user.index');
        }

    }
}
