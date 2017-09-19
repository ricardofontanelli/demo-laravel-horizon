<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ROUTE VIEW AND REDIRECT -------------------------------------------------------------------------------------------------
Route::view('/', 'welcome', ['location' => 'FTD']);
Route::redirect('/here', '/there');
Route::view('/there', 'redirect');

// CUSTOM EXCEPTION REPORT / RENDER -----------------------------------------------------------------------------------------
Route::get('/whoops', function () {
    throw new App\Exceptions\CustomException('Whoops My Custom Exception');
});

// CUSTOM EXCEPTION REPORT / RENDER -----------------------------------------------------------------------------------------
Route::get('/exception', function () {
    echo invalid_variable;
});

// THORW IF ------------------------------------------------------------------------------------------------------------------
Route::get('/exception-helper', function () {
    
    $condition = filter_var(request()->value, FILTER_VALIDATE_BOOLEAN);
    
    // Condition is true
    throw_if($condition, new  App\Exceptions\CustomException('Condition is <span style="color:blue;">true</span>'));
    
    // Condition is false
    throw_unless($condition, new  App\Exceptions\CustomException('Condition is <span  style="color:red;">false</span>'));
});


// THORW IF ------------------------------------------------------------------------------------------------------------------
Route::get('/job-chain', function () {
    
    $value = 'MY-VALUE';
    
    dispatch(new App\Jobs\FirstJob($value))->chain(
        [
            new App\Jobs\SecondJob($value),
            new App\Jobs\ThirdJob($value),
        ]
    );
    
    return 'Queued';
});


// LARAVEL HORIZON -----------------------------------------------------------------------------------------------------------

/*
    php artisan horizon:pause
    php artisan horizon:continue
    php artisan horizon:terminate

*/
Route::get('/dispatch/basic/{times?}', function ($times = 1) {
    
    for ($i = 0; $i < $times; $i++) {
        App\Jobs\BasicTask::dispatch();
        echo 'Job: ' . $i . '<br />';
    }
});


// /dispatch/tagged/invoice-1
// monitor tag::invoice-1
Route::get('/dispatch/tagged/{tag?}', function ($tag = 1) {
    App\Jobs\TaggedTask::dispatch($tag);
    echo '<h1>Tagged Job dispatched!</h1>';
});

Route::get('/dispatch/fail', function () {
    App\Jobs\FailableTask::dispatch();
    echo '<h1>Failable Job dispatched!</h1>';
});


// AUTO BALANCING

// NOTIFICATE
Route::get('/dispatch/hurry', function () {
    App\Jobs\SlowTask::dispatch()->onQueue('hurry_queue');
    echo '<h1>Dispatched a Job at Hurried Queue!</h1>';
});
