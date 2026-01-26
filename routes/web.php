<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - José Carvalho Real Estate
|--------------------------------------------------------------------------
*/

// --- UTILITÁRIOS ---
// Movi para o ToolsController para permitir cache de rotas
Route::get('locale/{locale}', [ToolsController::class, 'changeLocale'])->name('locale');

// --- INSTITUCIONAL ---
Route::view('/sobre', 'about')->name('about');
Route::view('/termos-e-condicoes', 'legal.terms')->name('terms');

// --- HOME ---
// ADAPTAÇÃO: Aponta para um método novo no PropertyController
Route::get('/', [PropertyController::class, 'home'])->name('home');

// --- IMÓVEIS (PORTFÓLIO) ---
Route::controller(PropertyController::class)->group(function () {
    Route::get('/imoveis', 'publicIndex')->name('portfolio');
    Route::get('/imoveis/{property:slug}', 'show')->name('properties.show');
});

// --- CONTACTOS & RECRUTAMENTO ---
Route::view('/contactos', 'contact')->name('contact');
Route::post('/contactos/enviar', [ContactController::class, 'send'])->name('contact.send');
Route::post('/recrutamento/enviar', [RecruitmentController::class, 'submit'])->name('recruitment.submit');

// --- FERRAMENTAS ---
Route::prefix('ferramentas')->name('tools.')->group(function () {
    Route::view('/simulador-credito', 'tools.credit')->name('credit');
    Route::view('/imt', 'tools.imt')->name('imt');
    
    Route::controller(ToolsController::class)->group(function () {
        Route::get('/mais-valias', 'showGainsSimulator')->name('gains');
        Route::post('/mais-valias/calcular', 'calculateGains')->name('gains.calculate');
    });
});

// --- CHATBOT ---
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

// --- BACKOFFICE ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::resource('properties', PropertyController::class);
    });
});