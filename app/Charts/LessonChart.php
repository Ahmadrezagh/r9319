<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Lesson;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class LessonChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public ?string $routeName = 'lesson_chart';
    public function handler(Request $request): Chartisan
    {
        $lessons_name = Lesson::query()->pluck('name')->toArray();
        $lessons = Lesson::all();
        $votes = [];
        foreach ($lessons as $lesson)
        {
            array_push($votes,$lesson->vote());
        }
        foreach ($lessons_name as $key => $item)
        {
            $lessons_name[$key] = $lessons_name[$key];
        }
        return Chartisan::build()
            ->labels($lessons_name)
            ->dataset('نتایج نظرسنجی دروس مختلف', $votes);
    }
}