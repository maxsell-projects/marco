@extends('layouts.panel')

@section('content')

<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="font-serif text-3xl text-brand-dark">Olá, {{ explode(' ', $user->name)[0] }}</h2>
        <p class="text-sm text-gray-500 mt-1">Bem-vindo ao seu painel exclusivo Porthouse.</p>
    </div>
    <div class="text-sm text-gray-400 font-mono">
        {{ now()->format('d M, Y') }}
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    
    <div class="bg-white p-6 rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-1">
                @if($user->isClient()) Favoritos @else Imóveis Ativos @endif
            </p>
            <p class="text-3xl font-serif text-brand-dark">
                @if($user->isClient()) {{ $clientData['favorites_count'] }} @else {{ $stats['total_properties'] }} @endif
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-brand-gold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-1">
                @if($user->isClient()) Off-Market @else Clientes @endif
            </p>
            <p class="text-3xl font-serif text-brand-dark">
                @if($user->isClient()) {{ $clientData['exclusive_access'] }} @else {{ $stats['active_clients'] }} @endif
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-brand-gold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-1">Alertas</p>
            <p class="text-3xl font-serif text-brand-dark">0</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-brand-gold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 p-8 min-h-[300px] flex flex-col items-center justify-center text-center">
    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
    </div>
    <h3 class="font-serif text-xl text-brand-dark mb-2">Atividade Recente</h3>
    <p class="text-gray-400 max-w-sm">Nenhuma atividade recente registrada na sua conta. Novas interações aparecerão aqui.</p>
</div>

@endsection