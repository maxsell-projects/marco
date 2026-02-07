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
use App\Http\Controllers\Admin\ClientAccessController;
use App\Http\Controllers\Admin\AccessRequestController;
use App\Http\Controllers\Admin\UserController; // <--- NOVO: Import do UserController

/*
|--------------------------------------------------------------------------
| Web Routes - José Carvalho Real Estate (Versão Completa)
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
        
        // Off-Market
        Route::post('/acesso-cliente', [ClientAccessController::class, 'store'])->name('client-access.store');
        Route::delete('/acesso-cliente', [ClientAccessController::class, 'destroy'])->name('client-access.destroy');

        // Solicitações de Acesso
        Route::get('/solicitacoes', [AccessRequestController::class, 'index'])->name('requests.index');
        Route::get('/solicitacoes/{user}', [AccessRequestController::class, 'show'])->name('requests.show');
        Route::post('/solicitacoes/{user}/aprovar', [AccessRequestController::class, 'approve'])->name('requests.approve');
        Route::delete('/solicitacoes/{user}/rejeitar', [AccessRequestController::class, 'reject'])->name('requests.reject');

        // --- NOVO: Gestão de Usuários & Equipe ---
        // Lista geral de usuários com filtros
        Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
        // Visão hierárquica (Devs e seus Clientes)
        Route::get('/equipe', [UserController::class, 'devs'])->name('users.devs');
    });

});