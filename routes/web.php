<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Route for testing E-mail directly in web browser.
|--------------------------------------------------------------------------
*/
/*Route::get('mail', function () {
    $user = User::find(1);

    return (new \Selvah\Notifications\Auth\RegisteredNotification($user))
                ->toMail($user);
});*/

/*
|--------------------------------------------------------------------------
| Auth Namespace
|--------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Auth'], function () {
    // Authentication Routes
    Route::get('login', [BDS\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
        ->name('auth.login');
    Route::post('login', [BDS\Http\Controllers\Auth\LoginController::class, 'login']);

    // Password Reset Routes
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')
        ->name('auth.password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
        ->name('auth.password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
        ->name('auth.password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')
        ->name('auth.password.update');
    Route::get('password/setup/{id}/{hash}', 'PasswordController@showSetupForm')
        ->name('auth.password.setup');
    Route::post('password/setup/{id}/{hash}', 'PasswordController@setup')
        ->name('auth.password.create');
    Route::get('password/resend', 'PasswordController@showResendRequestForm')
        ->name('auth.password.resend.request');
    Route::post('password/resend', 'PasswordController@resend')
        ->name('auth.password.resend');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    */
    Route::post('logout', [BDS\Http\Controllers\Auth\LoginController::class, 'logout'])
        ->name('auth.logout');

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */
    Route::get('profile', [BDS\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');

    /*
    |--------------------------------------------------------------------------
    | Password Routes
    |--------------------------------------------------------------------------
    */
    Route::put('password', [BDS\Http\Controllers\PasswordController::class, 'update'])->name('password.update');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', [BDS\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard.index');

    /*
    |--------------------------------------------------------------------------
    | Users Routes
    |--------------------------------------------------------------------------
    */
    Route::get('users', [BDS\Http\Controllers\UserController::class, 'index'])
        ->name('users.index');
    Route::get('users/permissions', [BDS\Http\Controllers\UserController::class, 'permissions'])
        ->name('users.permissions');
    Route::get('users/{user}', [BDS\Http\Controllers\UserController::class, 'show'])
        ->name('users.show')
        ->missing(function (Request $request) {
            return Redirect::back()
                ->with('danger', "Cet utilisateur n'existe pas ou à été supprimé !");
        });

    /*
    |--------------------------------------------------------------------------
    | Roles/Permissions Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['namespace' => 'Role', 'prefix' => 'roles'], function () {

        // Roles Routes
        Route::get('roles', [BDS\Http\Controllers\Role\RoleController::class, 'index'])
            ->name('roles.roles.index');

        // Permissions Route
        Route::get('permissions', [BDS\Http\Controllers\Role\PermissionController::class, 'index'])
            ->name('roles.permissions.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Settings Routes
    |--------------------------------------------------------------------------
    */
    Route::get('settings', [BDS\Http\Controllers\SettingController::class, 'index'])
        ->name('settings.index');

    /*
    |--------------------------------------------------------------------------
    | Sites Routes
    |--------------------------------------------------------------------------
    */
    Route::get('sites', [BDS\Http\Controllers\SiteController::class, 'index'])
        ->name('sites.index');
    Route::get('sites/{material}', [BDS\Http\Controllers\SiteController::class, 'show'])
        ->name('sites.show')
        ->missing(function (Request $request) {
            return Redirect::back()
                ->with('danger', "Ce site n'existe pas ou à été supprimé !");
        });

    /*
    |--------------------------------------------------------------------------
    | Zones Routes
    |--------------------------------------------------------------------------
    */
    Route::get('zones', [BDS\Http\Controllers\ZoneController::class, 'index'])
        ->name('zones.index');
    Route::get('zones/{zone}', [BDS\Http\Controllers\ZoneController::class, 'show'])
        ->name('zones.show')
        ->missing(function (Request $request) {
            return Redirect::back()
                ->with('danger', "Cette zone n'existe pas ou à été supprimée !");
        });

    /*
    |--------------------------------------------------------------------------
    | Materials Routes
    |--------------------------------------------------------------------------
    */
    Route::get('materials', [BDS\Http\Controllers\MaterialController::class, 'index'])
        ->name('materials.index');
    Route::get('materials/arbre', [BDS\Http\Controllers\MaterialController::class, 'arbre'])
        ->name('materials.arbre');
    Route::get('materials/{material}', [BDS\Http\Controllers\MaterialController::class, 'show'])
        ->name('materials.show')
        ->missing(function (Request $request) {
            return Redirect::back()
                ->with('danger', "Ce matériel n'existe pas ou à été supprimé !");
        });

    /*
    |--------------------------------------------------------------------------
    | Cleanings Routes
    |--------------------------------------------------------------------------
    */
    Route::get('cleanings', [BDS\Http\Controllers\CleaningController::class, 'index'])
        ->name('cleanings.index');
});
