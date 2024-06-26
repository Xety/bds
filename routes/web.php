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
    Route::get('password/reset', [BDS\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('auth.password.request');
    Route::post('password/email', [BDS\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('auth.password.email');
    Route::get('password/reset/{token}', [BDS\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
        ->name('auth.password.reset');
    Route::post('password/reset', [BDS\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
        ->name('auth.password.update');
    Route::get('password/setup/{id}/{hash}', [BDS\Http\Controllers\Auth\PasswordController::class, 'showSetupForm'])
        ->name('auth.password.setup');
    Route::post('password/setup/{id}/{hash}', [BDS\Http\Controllers\Auth\PasswordController::class, 'setup'])
        ->name('auth.password.create');
    Route::get('password/resend', [BDS\Http\Controllers\Auth\PasswordController::class, 'showResendRequestForm'])
        ->name('auth.password.resend.request');
    Route::post('password/resend', [BDS\Http\Controllers\Auth\PasswordController::class, 'resend'])
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
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', [BDS\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard.index');

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
    | Users Routes
    |--------------------------------------------------------------------------
    */
    Route::get('users', [BDS\Http\Controllers\UserController::class, 'index'])
        ->name('users.index');
    Route::get('users/permissions', [BDS\Http\Controllers\UserController::class, 'permissions'])
        ->name('users.permissions');
    Route::get('users/{user}', [BDS\Http\Controllers\UserController::class, 'show'])
        ->name('users.show');

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
    Route::put('settings', [BDS\Http\Controllers\SettingController::class, 'update'])
        ->name('settings.update');

    /*
    |--------------------------------------------------------------------------
    | Sites Routes
    |--------------------------------------------------------------------------
    */
    Route::get('sites', [BDS\Http\Controllers\SiteController::class, 'index'])
        ->name('sites.index');
    Route::get('sites/{site}', [BDS\Http\Controllers\SiteController::class, 'show'])
        ->name('sites.show');

    /*
    |--------------------------------------------------------------------------
    | Zones Routes
    |--------------------------------------------------------------------------
    */
    Route::get('zones', [BDS\Http\Controllers\ZoneController::class, 'index'])
        ->name('zones.index');
    Route::get('zones/{zone}', [BDS\Http\Controllers\ZoneController::class, 'show'])
        ->name('zones.show');

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
        ->name('materials.show');

    /*
    |--------------------------------------------------------------------------
    | Cleanings Routes
    |--------------------------------------------------------------------------
    */
    Route::get('cleanings', [BDS\Http\Controllers\CleaningController::class, 'index'])
        ->name('cleanings.index');

    /*
    |--------------------------------------------------------------------------
    | Incidents Routes
    |--------------------------------------------------------------------------
    */
    Route::get('incidents', [BDS\Http\Controllers\IncidentController::class, 'index'])
        ->name('incidents.index');

    /*
    |--------------------------------------------------------------------------
    | Maintenances Routes
    |--------------------------------------------------------------------------
    */
    Route::get('maintenances', [BDS\Http\Controllers\MaintenanceController::class, 'index'])
        ->name('maintenances.index');
    Route::get('maintenances/{maintenance}', [BDS\Http\Controllers\MaintenanceController::class, 'show'])
        ->name('maintenances.show');


    /*
    |--------------------------------------------------------------------------
    | Companies Routes
    |--------------------------------------------------------------------------
    */
    Route::get('companies', [BDS\Http\Controllers\CompanyController::class, 'index'])
        ->name('companies.index');
    Route::get('companies/{company}', [BDS\Http\Controllers\CompanyController::class, 'show'])
        ->name('companies.show');

    /*
    |--------------------------------------------------------------------------
    | Parts Routes
    |--------------------------------------------------------------------------
    */
    Route::get('parts', [BDS\Http\Controllers\PartController::class, 'index'])
        ->name('parts.index');
    Route::get('parts/{part}', [BDS\Http\Controllers\PartController::class, 'show'])
        ->name('parts.show');

    /*
    |--------------------------------------------------------------------------
    | PartEntries Routes
    |--------------------------------------------------------------------------
    */
    Route::get('part-entries', [BDS\Http\Controllers\PartEntryController::class, 'index'])
        ->name('part-entries.index');

    /*
    |--------------------------------------------------------------------------
    | PartExits Routes
    |--------------------------------------------------------------------------
    */
    Route::get('part-exits', [BDS\Http\Controllers\PartExitController::class, 'index'])
        ->name('part-exits.index');

    /*
    |--------------------------------------------------------------------------
    | Suppliers Routes
    |--------------------------------------------------------------------------
    */
    Route::get('suppliers', [BDS\Http\Controllers\SupplierController::class, 'index'])
        ->name('suppliers.index');
    Route::get('suppliers/{supplier}', [BDS\Http\Controllers\SupplierController::class, 'show'])
        ->name('suppliers.show');

    /*
    |--------------------------------------------------------------------------
    | Calendars Routes
    |--------------------------------------------------------------------------
    */
    Route::get('calendars', [BDS\Http\Controllers\CalendarController::class, 'index'])
        ->name('calendars.index');

    /*
    |--------------------------------------------------------------------------
    | CalendarEvents Routes
    |--------------------------------------------------------------------------
    */
    Route::get('calendars/events', [BDS\Http\Controllers\CalendarEventController::class, 'index'])
        ->name('calendar-events.index');

    /*
    |--------------------------------------------------------------------------
    | Activities Routes
    |--------------------------------------------------------------------------
    */
    Route::get('activities', [BDS\Http\Controllers\ActivityController::class, 'index'])
        ->name('activities.index');

    /*
    |--------------------------------------------------------------------------
    | Tree Routes
    |--------------------------------------------------------------------------
    */
    Route::get('tree/zones-with-materials', [BDS\Http\Controllers\TreeController::class, 'zonesWithMaterials'])
        ->name('tree.zones-with-materials');

    /*
    |--------------------------------------------------------------------------
    | Pulse Routes
    |--------------------------------------------------------------------------
    */
    Route::get('pulse', [BDS\Http\Controllers\PulseController::class, 'index'])
        ->name('pulse.index');

    /*
    |--------------------------------------------------------------------------
    | Selvah Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['namespace' => 'Selvah', 'prefix' => 'selvah'], function () {
        /*
        |--------------------------------------------------------------------------
        | Selvah Correspondence Sheets Routes
        |--------------------------------------------------------------------------
        */
        Route::get('correspondence-sheets', [BDS\Http\Controllers\Selvah\CorrespondenceSheetController::class, 'index'])
            ->name('correspondence-sheets.index');
        Route::get('correspondence-sheets/{sheet}', [BDS\Http\Controllers\Selvah\CorrespondenceSheetController::class, 'show'])
            ->name('correspondence-sheets.show');
        Route::get('correspondence-sheets/create', [BDS\Http\Controllers\Selvah\CorrespondenceSheetController::class, 'create'])
            ->name('correspondence-sheets.create');
    });
});
