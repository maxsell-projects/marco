<?php

use Illuminate\Support\Facades\Route;

// Controllers Originais
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\Api\ChatbotController;

// Novos Controllers (Arquitetura Nova)
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\Admin\ClientAccessController;
use App\Http\Controllers\Admin\AccessRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RequestAccessController;

/*
|--------------------------------------------------------------------------
| Web Routes - José Carvalho Real Estate (Versão Definitiva)
|--------------------------------------------------------------------------
*/

// --- 1. UTILITÁRIOS & CONFIG ---
Route::get('locale/{locale}', [ToolsController::class, 'changeLocale'])->name('locale');

// --- 2. AUTENTICAÇÃO (Global) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
});

// Solicitação de Acesso (Pública)
Route::controller(RequestAccessController::class)->group(function () {
    Route::get('/solicitar-acesso', 'show')->name('access.request');
    Route::post('/solicitar-acesso', 'submit')->name('access.submit');
});

// Logout Global
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// --- 3. ÁREA PÚBLICA (Site) ---
Route::get('/', [PropertyController::class, 'home'])->name('home');
Route::view('/sobre', 'about')->name('about');
Route::view('/termos-e-condicoes', 'legal.terms')->name('terms');

Route::controller(PropertyController::class)->group(function () {
    Route::get('/imoveis', 'publicIndex')->name('portfolio'); 
    Route::get('/imoveis/{property:slug}', 'show')->name('properties.show');
});

// Blog Público
Route::get('/blog', [BlogPostController::class, 'publicIndex'])->name('blog.index');
Route::get('/blog/{slug}', [BlogPostController::class, 'show'])->name('blog.show');

Route::view('/contactos', 'contact')->name('contact');
Route::post('/contactos/enviar', [ContactController::class, 'send'])->name('contact.send');
Route::post('/recrutamento/enviar', [RecruitmentController::class, 'submit'])->name('recruitment.submit');

Route::prefix('ferramentas')->name('tools.')->group(function () {
    Route::view('/simulador-credito', 'tools.credit')->name('credit');
    Route::view('/imt', 'tools.imt')->name('imt');
    Route::controller(ToolsController::class)->group(function () {
        Route::get('/mais-valias', 'showGainsSimulator')->name('gains');
        Route::post('/mais-valias/calcular', 'calculateGains')->name('gains.calculate');
    });
});

Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');


// --- 4. ÁREA PROTEGIDA (Backoffice & Cliente) ---
Route::middleware(['auth'])->group(function () {

    // HUB CENTRAL
    Route::get('/painel', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); // Alias

    // --- A) Área do Cliente ---
    Route::prefix('minha-conta')->name('client.')->group(function () {
        Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favoritos/{property}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
        Route::get('/exclusivos', [PropertyController::class, 'myAccess'])->name('properties.exclusive');
    });

    // --- B) Backoffice (Admin & Devs) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // CRUD Imóveis
        Route::resource('properties', PropertyController::class)->except(['show']);
        
        // APROVAÇÃO DE IMÓVEIS
        Route::patch('/properties/{property}/approve', [PropertyController::class, 'approve'])->name('properties.approve');
        Route::patch('/properties/{property}/reject', [PropertyController::class, 'reject'])->name('properties.reject');
        
        // CRUD Blog
        Route::resource('blog', BlogPostController::class)->except(['show']);

        // Gestão de Acesso (Off-Market)
        Route::get('/imoveis/{property}/acesso', [ClientAccessController::class, 'manage'])->name('properties.access');
        Route::post('/imoveis/{property}/acesso', [ClientAccessController::class, 'toggle'])->name('properties.access.toggle');

        // Solicitações de Acesso
        Route::get('/solicitacoes', [AccessRequestController::class, 'index'])->name('requests.index');
        Route::get('/solicitacoes/{user}', [AccessRequestController::class, 'show'])->name('requests.show');
        Route::post('/solicitacoes/{user}/aprovar', [AccessRequestController::class, 'approve'])->name('requests.approve');
        Route::delete('/solicitacoes/{user}/rejeitar', [AccessRequestController::class, 'reject'])->name('requests.reject');

        // --- GESTÃO DE USUÁRIOS (Resourceful para evitar erros de MethodNotAllowed) ---
        Route::resource('usuarios', UserController::class)->names([
            'index'   => 'users.index',
            'create'  => 'users.create',
            'store'   => 'users.store',
            'edit'    => 'users.edit',
            'update'  => 'users.update',
            'destroy' => 'users.destroy',
        ])->parameters([
            'usuarios' => 'user' // Garante que o parâmetro seja {user} para o Controller
        ]);
        
        // Visão hierárquica (Equipe)
        Route::get('/equipe', [UserController::class, 'devs'])->name('users.devs');
    });

});