<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CEOController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


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

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    //Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return '<h1>Cache cleared</h1>';
});

//Route::get('/test1', function () {
//
//
//    $curl = curl_init();
//
//    curl_setopt_array($curl, array(
//        CURLOPT_URL => 'https://in1-ccaas-api.ozonetel.com/cloudAgentRestAPI/index.php/CloudAgent/CloudAgentAPI/getCDR?api_key=KKcff82442b04d72db9ff8b9dd1b22866b&user_name=catking&from_date=2023-11-06%2009%3A00%3A00&to_date=2023-11-08%2016%3A00%3A00&format=json',
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => '',
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 0,
//        CURLOPT_FOLLOWLOCATION => true,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => 'GET',
//        CURLOPT_HTTPHEADER => array(
//            'accept: application/json'
//        ),
//    ));
//
//    $response = curl_exec($curl);
//
//    curl_close($curl);
//    echo $response;
//    exit;
//});

Route::middleware('auth')->group(function () {
    //ceo revenue start
    Route::get('ceo-revenue', [CEOController::class, 'index'])->name('ceo-revenue');
    Route::get('ceo-revenue-model', [CEOController::class, 'revenueModel'])->name('ceo-revenue-model');
    Route::post('ceo-revenue-getData', [CEOController::class, 'getData'])->name('ceo-revenue-getData');
    Route::post('ceo-sales-getData', [CEOController::class, 'perAgentConversion'])->name('ceo-sales-getData');
    //ceo revenue end

    Route::get('student-profile', [HomeController::class, 'studentProfile'])->name('student-profile');

    Route::get('exam-toppers', [HomeController::class, 'examToppers'])->name('exam-toppers');

    Route::get('mentors-interView', [HomeController::class, 'mentorsInterView'])->name('mentors-interView');

    Route::get('faculty-session', [HomeController::class, 'facultySession'])->name('faculty-session');

    Route::get('finance', [HomeController::class, 'finance'])->name('finance');

    Route::get('marketing', [HomeController::class, 'marketing'])->name('marketing');

    Route::get('forum', [HomeController::class, 'forum'])->name('forum');

    Route::get('CATKingOne', [HomeController::class, 'CATKingOne'])->name('CATKingOne');

    Route::get('CATKingSupport', [SupportController::class, 'index'])->name('CATKingSupport');

    Route::as('support.')->group(function() {
        Route::get('analyticData', [SupportController::class, 'analyticData'])->name('analyticData');

        Route::get('fetchCallAndGroupCount', [SupportController::class, 'fetchCallAndGroupCount'])->name('fetchCallAndGroupCount');
        Route::get('fetchWelcomeCallsData', [SupportController::class, 'fetchWelcomeCallsData'])->name('fetchWelcomeCallsData');
        Route::get('fetchCustomerCallsData', [SupportController::class, 'fetchCustomerCallsData'])->name('fetchCustomerCallsData');
        Route::get('fetchCustomerIncomingCallsData', [SupportController::class, 'fetchCustomerIncomingCallsData'])->name('fetchCustomerIncomingCallsData');
        Route::get('getWords', [SupportController::class, 'getWords'])->name('getWords');
        Route::get('callTransferedData', [SupportController::class, 'callTransferedData'])->name('callTransferedData');

        Route::get('freshDeskData', [SupportController::class, 'freshDeskData'])->name('freshDeskData');
    });
});

// Auth::routes();

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('check.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
