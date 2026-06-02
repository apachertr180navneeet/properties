<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\AdminAuthController;

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


Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/properties/{id}', [HomeController::class, 'show'])->name('properties.show');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// New pages for roofing company
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services-carousel', [HomeController::class, 'servicesCarousel'])->name('services.carousel');
Route::get('/single-play-roofing', [HomeController::class, 'singlePlayRoofing'])->name('single.play.roofing');
Route::get('/modified-roofing', [HomeController::class, 'modifiedRoofing'])->name('modified.roofing');
Route::get('/built-up-roofing', [HomeController::class, 'builtUpRoofing'])->name('built.up.roofing');
Route::get('/roof-inspection', [HomeController::class, 'roofInspection'])->name('roof.inspection');
Route::get('/roof-installation', [HomeController::class, 'roofInstallation'])->name('roof.installation');
Route::get('/metal-roofing', [HomeController::class, 'metalRoofing'])->name('metal.roofing');
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::get('/team-carousel', [HomeController::class, 'teamCarousel'])->name('team.carousel');
Route::get('/team-details/{id}', [HomeController::class, 'teamDetails'])->name('team.details');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/testimonials-carousel', [HomeController::class, 'testimonialsCarousel'])->name('testimonials.carousel');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/gallery-carousel', [HomeController::class, 'galleryCarousel'])->name('gallery.carousel');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/404', [HomeController::class, 'notFound'])->name('404');
Route::get('/work', [HomeController::class, 'work'])->name('work');
Route::get('/work-carousel', [HomeController::class, 'workCarousel'])->name('work.carousel');
Route::get('/work-details/{id}', [HomeController::class, 'workDetails'])->name('work.details');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog-carousel', [HomeController::class, 'blogCarousel'])->name('blog.carousel');
Route::get('/blog-sidebar', [HomeController::class, 'blogSidebar'])->name('blog.sidebar');
Route::get('/blog-details/{id}', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'index']);

    Route::get('login', [AdminAuthController::class, 'login'])->name('login');

    Route::post('login', [AdminAuthController::class, 'postLogin'])->name('login.post');

    Route::get('forget-password', [AdminAuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');

    Route::post('forget-password', [AdminAuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

    Route::get('reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset.password.get');

    Route::post('reset-password', [AdminAuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::middleware(['admin'])->group(function () {
    		Route::get('dashboard', [AdminAuthController::class, 'adminDashboard'])->name('dashboard');

            Route::get('change-password', [AdminAuthController::class, 'changePassword'])->name('change.password');

            Route::post('update-password', [AdminAuthController::class, 'updatePassword'])->name('update.password');

            Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');

            Route::get('profile', [AdminAuthController::class, 'adminProfile'])->name('profile');

            Route::post('profile', [AdminAuthController::class, 'updateAdminProfile'])->name('update.profile');

            // Sales Persons CRUD
            Route::get('salespersons-table', [\App\Http\Controllers\Admin\SalesPersonController::class, 'getTable'])->name('salespersons.table');
            Route::post('salespersons/{id}/toggle-status', [\App\Http\Controllers\Admin\SalesPersonController::class, 'toggleStatus'])->name('salespersons.toggle-status');
            Route::get('salespersons-export', [\App\Http\Controllers\Admin\SalesPersonController::class, 'exportExcel'])->name('salespersons.export');
            Route::resource('salespersons', \App\Http\Controllers\Admin\SalesPersonController::class)->names([
                'index' => 'salespersons.index',
                'store' => 'salespersons.store',
                'show' => 'salespersons.show',
                'update' => 'salespersons.update',
                'destroy' => 'salespersons.destroy',
            ]);

            // Area Master CRUD
            Route::get('areamaster-table', [\App\Http\Controllers\Admin\AreaMasterController::class, 'getTable'])->name('areamaster.table');
            Route::post('areamaster/{id}/toggle-status', [\App\Http\Controllers\Admin\AreaMasterController::class, 'toggleStatus'])->name('areamaster.toggle-status');
            Route::get('areamaster-export', [\App\Http\Controllers\Admin\AreaMasterController::class, 'exportExcel'])->name('areamaster.export');
            Route::resource('areamaster', \App\Http\Controllers\Admin\AreaMasterController::class)->names([
                'index' => 'areamaster.index',
                'store' => 'areamaster.store',
                'show' => 'areamaster.show',
                'update' => 'areamaster.update',
                'destroy' => 'areamaster.destroy',
            ]);

            // Properties CRUD
            Route::get('properties-table', [\App\Http\Controllers\Admin\PropertyController::class, 'getTable'])->name('properties.table');
            Route::post('properties/{id}/toggle-status', [\App\Http\Controllers\Admin\PropertyController::class, 'toggleStatus'])->name('properties.toggle-status');
            Route::get('properties-export', [\App\Http\Controllers\Admin\PropertyController::class, 'exportExcel'])->name('properties.export');
            Route::resource('properties', \App\Http\Controllers\Admin\PropertyController::class)->names([
                'index' => 'properties.index',
                'store' => 'properties.store',
                'show' => 'properties.show',
                'update' => 'properties.update',
                'destroy' => 'properties.destroy',
            ]);

            // Customers CRUD
            // Message Templates CRUD
            Route::get('customers-table', [\App\Http\Controllers\Admin\CustomerController::class, 'getTable'])->name('customers.table');
            // Message Templates routes
            Route::get('message-templates-table', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'getTable'])->name('message-templates.table');
            Route::post('message-templates/{id}/toggle-status', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'toggleStatus'])->name('message-templates.toggle-status');
            Route::get('message-templates-export', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'exportExcel'])->name('message-templates.export');
            Route::resource('message-templates', \App\Http\Controllers\Admin\MessageTemplateController::class)->names([
                'index'   => 'message-templates.index',
                'store'   => 'message-templates.store',
                'show'    => 'message-templates.show',
                'update'  => 'message-templates.update',
                'destroy' => 'message-templates.destroy',
            ]);
            Route::get('customers/{id}/assign-properties', [\App\Http\Controllers\Admin\CustomerController::class, 'assignProperties'])->name('customers.assign-properties');
            Route::post('customers/{id}/toggle-property', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleProperty'])->name('customers.toggle-property');
            Route::post('customers/{id}/send-whatsapp', [\App\Http\Controllers\Admin\CustomerController::class, 'sendWhatsapp'])->name('customers.send-whatsapp');
            Route::post('customers/{id}/toggle-status', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
            Route::get('customers-export', [\App\Http\Controllers\Admin\CustomerController::class, 'exportExcel'])->name('customers.export');
            Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->names([
                'index' => 'customers.index',
                'store' => 'customers.store',
                'show' => 'customers.show',
                'update' => 'customers.update',
                'destroy' => 'customers.destroy',
            ]);
        });
});

Route::middleware(['auth'])->group(function () {

});


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


Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/properties/{id}', [HomeController::class, 'show'])->name('properties.show');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'index']);

    Route::get('login', [AdminAuthController::class, 'login'])->name('login');

    Route::post('login', [AdminAuthController::class, 'postLogin'])->name('login.post');

    Route::get('forget-password', [AdminAuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');

    Route::post('forget-password', [AdminAuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

    Route::get('reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset.password.get');

    Route::post('reset-password', [AdminAuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::middleware(['admin'])->group(function () {
    	Route::get('dashboard', [AdminAuthController::class, 'adminDashboard'])->name('dashboard');

        Route::get('change-password', [AdminAuthController::class, 'changePassword'])->name('change.password');

        Route::post('update-password', [AdminAuthController::class, 'updatePassword'])->name('update.password');

        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('profile', [AdminAuthController::class, 'adminProfile'])->name('profile');

        Route::post('profile', [AdminAuthController::class, 'updateAdminProfile'])->name('update.profile');

        // Sales Persons CRUD
        Route::get('salespersons-table', [\App\Http\Controllers\Admin\SalesPersonController::class, 'getTable'])->name('salespersons.table');
        Route::post('salespersons/{id}/toggle-status', [\App\Http\Controllers\Admin\SalesPersonController::class, 'toggleStatus'])->name('salespersons.toggle-status');
        Route::get('salespersons-export', [\App\Http\Controllers\Admin\SalesPersonController::class, 'exportExcel'])->name('salespersons.export');
        Route::resource('salespersons', \App\Http\Controllers\Admin\SalesPersonController::class)->names([
            'index' => 'salespersons.index',
            'store' => 'salespersons.store',
            'show' => 'salespersons.show',
            'update' => 'salespersons.update',
            'destroy' => 'salespersons.destroy',
        ]);

        // Area Master CRUD
        Route::get('areamaster-table', [\App\Http\Controllers\Admin\AreaMasterController::class, 'getTable'])->name('areamaster.table');
        Route::post('areamaster/{id}/toggle-status', [\App\Http\Controllers\Admin\AreaMasterController::class, 'toggleStatus'])->name('areamaster.toggle-status');
        Route::get('areamaster-export', [\App\Http\Controllers\Admin\AreaMasterController::class, 'exportExcel'])->name('areamaster.export');
        Route::resource('areamaster', \App\Http\Controllers\Admin\AreaMasterController::class)->names([
            'index' => 'areamaster.index',
            'store' => 'areamaster.store',
            'show' => 'areamaster.show',
            'update' => 'areamaster.update',
            'destroy' => 'areamaster.destroy',
        ]);

        // Properties CRUD
        Route::get('properties-table', [\App\Http\Controllers\Admin\PropertyController::class, 'getTable'])->name('properties.table');
        Route::post('properties/{id}/toggle-status', [\App\Http\Controllers\Admin\PropertyController::class, 'toggleStatus'])->name('properties.toggle-status');
        Route::get('properties-export', [\App\Http\Controllers\Admin\PropertyController::class, 'exportExcel'])->name('properties.export');
        Route::resource('properties', \App\Http\Controllers\Admin\PropertyController::class)->names([
            'index' => 'properties.index',
            'store' => 'properties.store',
            'show' => 'properties.show',
            'update' => 'properties.update',
            'destroy' => 'properties.destroy',
        ]);

        // Customers CRUD
        // Message Templates CRUD
        Route::get('customers-table', [\App\Http\Controllers\Admin\CustomerController::class, 'getTable'])->name('customers.table');
        // Message Templates routes
        Route::get('message-templates-table', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'getTable'])->name('message-templates.table');
        Route::post('message-templates/{id}/toggle-status', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'toggleStatus'])->name('message-templates.toggle-status');
        Route::get('message-templates-export', [\App\Http\Controllers\Admin\MessageTemplateController::class, 'exportExcel'])->name('message-templates.export');
        Route::resource('message-templates', \App\Http\Controllers\Admin\MessageTemplateController::class)->names([
            'index'   => 'message-templates.index',
            'store'   => 'message-templates.store',
            'show'    => 'message-templates.show',
            'update'  => 'message-templates.update',
            'destroy' => 'message-templates.destroy',
        ]);
        Route::get('customers/{id}/assign-properties', [\App\Http\Controllers\Admin\CustomerController::class, 'assignProperties'])->name('customers.assign-properties');
        Route::post('customers/{id}/toggle-property', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleProperty'])->name('customers.toggle-property');
        Route::post('customers/{id}/send-whatsapp', [\App\Http\Controllers\Admin\CustomerController::class, 'sendWhatsapp'])->name('customers.send-whatsapp');
        Route::post('customers/{id}/toggle-status', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
        Route::get('customers-export', [\App\Http\Controllers\Admin\CustomerController::class, 'exportExcel'])->name('customers.export');
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->names([
            'index' => 'customers.index',
            'store' => 'customers.store',
            'show' => 'customers.show',
            'update' => 'customers.update',
            'destroy' => 'customers.destroy',
        ]);
    });

});

Route::middleware(['auth'])->group(function () {

});


