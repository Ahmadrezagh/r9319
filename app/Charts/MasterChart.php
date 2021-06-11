<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Lesson;
use App\Models\User;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class MasterChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public ?string $routeName = 'master_chart';
    public function handler(Request $request): Chartisan
    {
        $masters_name = User::query()->masters()->pluck('name')->toArray();
        $masters = User::query()->masters()->get();
        $votes = [];
        foreach ($masters as $master)
        {
            array_push($votes,$master->vote());
        }
        foreach ($masters as $key => $item)
        {
            $masters_name[$key] = $masters_name[$key];
        }
        return Chartisan::build()
            ->labels($masters_name)
            ->dataset('نظر سنجی اساتید', $votes);
    }
}