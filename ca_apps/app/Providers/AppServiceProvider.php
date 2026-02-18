<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;

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
        //

        $affbtnexp='non';
        // $usersprivileges = Session::get('userprivilege_list');

        // dd($usersprivileges);
        // if (in_array(25, $usersprivileges)) {
        //     // code...
        //      $affbtnexp ='oui';
        // }
        config(
                   [
                     'AppConfig.btnexport' => $affbtnexp,
                   ]

        );

    }
}
