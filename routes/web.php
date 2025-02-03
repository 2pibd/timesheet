<?php
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\email_templateController;
use App\Http\Controllers\faqController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\template_typeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Livewire\EmailTemplate\CreateEmailTemplate;


Route::get('lang/{locale}', [App\Http\Controllers\LanguageController::class, 'lang']);

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Not Found
Route::get('/{lang?}/404', [DashboardController::class, 'page_404'])->name('NotFound');

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::resource('faq', FaqController::class);


Route::middleware('auth')->group(function () {
  //  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['middleware' => ['role:SuperAdmin|Admin|Client']], function () {
      //  Route::resource('menu',  [menuController::class])->name('menu');

        Route::resource('setting', 'SettingController');

        Route::get('profile', [UserController::class,'userProfile'])->name('profile');

        Route::resource('template_type',  template_typeController::class);
        Route::resource('email_template',  email_templateController::class);
    });

    Route::post('upload_profile_picture', [UserController::class,'upload_profile_picture'])->name('upload_profile_picture');
    Route::post('loadEditProfileForm', [UserController::class,'loadEditProfileForm'])->name('loadEditProfileForm');
    Route::post('userProfileUpdate', [UserController::class,'userProfileUpdate'])->name('userProfileUpdate');
    Route::post('changePasswardForm', [UserController::class,'changePasswardForm'])->name('changePasswardForm');
    Route::post('updatePassword', [UserController::class,'updatePassword'])->name('updatePassword');


/*    Route::resource('report',  reportController::class)->names([
        'menu_fn' => 'report.menu',
        'weekly_assignment_fn' => 'report.Weekly-Assignments',
        'gross_margin_fn' => 'report.Gross-Margin',
        'query_fn' => 'report.Query',
    ]);*/
  Route::get('report/menu', [reportController::class, 'menu_fn'])->name('report.menu');
  Route::get('report/Weekly-Assignments', [reportController::class, 'weekly_assignment_fn'])->name('report.Weekly-Assignments');
  Route::get('report/Gross-Margin', [reportController::class, 'gross_margin_fn'])->name('report.Gross-Margin');
  Route::get('report/Query', [reportController::class, 'query_fn'])->name('report.Query');


});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::get('/cc', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
});


