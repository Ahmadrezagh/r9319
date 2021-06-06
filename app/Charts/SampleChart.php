<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Lesson;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function handler(Request $request): Chartisan
    {
        $lessons_name = Lesson::query()->pluck('name')->toArray();
        $lessons = Lesson::all();
        $votes = [];
        foreach ($lessons as $lesson)
        {
            array_push($votes,$lesson->vote());
        }
        return Chartisan::build()
            ->labels($lessons_name)
            ->dataset('Sample 2', $votes);
    }
}