<?php

namespace App\Providers;

use App\Models\SettingGroup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        //

        Schema::defaultStringLength(191);
        if (Schema::hasTable('setting_groups'))
        {
            $setting_groups = SettingGroup::all();
            View::share('setting_groups', $setting_groups);
        }
        $charts->register([
            \App\Charts\SampleChart::class,
            \App\Charts\LessonChart::class,
            \App\Charts\MasterChart::class,
        ]);
    }
}
