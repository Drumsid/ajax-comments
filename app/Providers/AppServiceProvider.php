<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        view()->composer('homepage', function ($view) {
            $count = \App\Models\Comment::all()->count();
            if ($count < 5) {
              $commentsSlider =  \App\Models\Comment::all()->random($count);
            } else {
                $commentsSlider =  \App\Models\Comment::all()->random(5);
            }
            $view->with('commentsSlider', $commentsSlider);
        });
    }
}
