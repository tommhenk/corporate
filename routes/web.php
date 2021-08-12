<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;


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



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('admin')->group( function () {
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('adminIndex');

    Route::resource('portfolios', \App\Http\Controllers\Admin\PortfolioController::class)->names([
        'index'=>'admin_portfolio_index',
        'store'=>'admin_portfolio_store',
        'create'=>'admin_portfolio_create',
        'show'=>'admin_portfolio_show',
        'edit'=>'admin_portfolio_edit',
        'update'=>'admin_portfolio_update',
        'destroy'=>'admin_portfolio_destroy',
    ]);

    Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class)->names([
        'index'=>'admin_menu_index',
        'store'=>'admin_menu_store',
        'create'=>'admin_menu_create',
        'show'=>'admin_menu_show',
        'edit'=>'admin_menu_edit',
        'update'=>'admin_menu_update',
        'destroy'=>'admin_menu_destroy',
    ]);

    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class)->names([
        'index'=>'admin_permission_index',
        'store'=>'admin_permission_store',
    ]);

    Route::resource('articles', \App\Http\Controllers\Admin\ArticlesController::class)->names([
        'index'=>'admin_articles_index',
        'edit'=>'admin_articles_edit',
        'destroy'=>'admin_articles_destroy',
        'create'=>'admin_articles_create',
        'store'=>'admin_articles_store',
        'update'=>'admin_articles_update',

    ])->parameters([
        'articles'=>'alias'
    ]);

    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class)->names([
        'index'=>'admin_users_index',
        'edit'=>'admin_users_edit',
        'destroy'=>'admin_users_destroy',
        'create'=>'admin_users_create',
        'store'=>'admin_users_store',
        'update'=>'admin_users_update',

    ]);

} );

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware('guest')
                ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');

Route::resource('/', IndexController::class)->only([
    'index',
])->names(['index'=>'home']);

Route::resource('portfolio', PortfolioController::class)->parameters([
    'portfolio'=>'alias'
]);

Route::resource('articles', ArticlesController::class)->parameters([
    'articles'=>'alias'
]);

Route::get('/articles/cat/{cat_alias}', [ArticlesController::class, 'index'])->name('articlesCat')->where('cat_alias', '[\w]+');

Route::resource('comment', CommentController::class)->only('store');

Route::match(['get', 'post'], '/contacts', [ContactsController::class, 'index'])->name('contacts');



