<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

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
        // Make sure the directory for compiled views exist
        if (! is_dir(config('view.compiled'))) {
            mkdir(config('view.compiled'), 0755, true);
        }

        URL::forceRootUrl(config('app.url'));
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Blade::directive('icon', function ($expression) {
            return <<<EOL
<?php
            echo [
                'Kids'          => 'fas fa-child',
                'Parents'       => 'fas fa-home',
                'LGBT'          => 'fas fa-rainbow',
                'Vulnerable'    => 'fas fa-accessible-icon',
                'Business'      => 'fas fa-briefcase',
                'Fitness'       => 'fas fa-dumbbell',
                'Mental heath'  => 'fas fa-brain',
                'Teaching'      => 'fas fa-graduation-cap',
                'Social'        => 'fas fa-users',
                'Entertainment' => 'fas fa-dice-three',
                'Information'   => 'fas fa-info-circle',
                'Finance'       => 'fas fa-coins',
                'Support'       => 'fas fa-heart',
                'News'          => 'fas fa-newspaper',
                'Free'          => 'fas fa-coins',
                'Freemium'      => 'fas fa-money-bill-wave',
                'Paid'          => 'fas fa-money-bill',
                'Website'       => 'fas fa-internet-explorer',
                'Video'         => 'fas fa-video',
                'Audio'         => 'fas fa-headphones',
                'Reading'       => 'fas fa-book',
                'Social Media'  => 'fas fa-globe-europe',
            ][$expression] ?? 'fas fa-question-circle';
            ?>
EOL;
        });
    }
}
