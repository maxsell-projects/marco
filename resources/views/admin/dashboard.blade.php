@extends('layouts.admin')

@section('content')

{{-- HEADER & AÇÕES --}}
<div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
    <div>
        <h1 class="text-3xl md:text-4xl font-didot text-brand-primary">Visão Geral</h1>
        <p class="text-gray-500 text-sm mt-2 font-light">
            Bem-vindo de volta, <span class="font-bold text-brand-primary">{{ Auth::user()->name ?? 'Administrador' }}</span>.
        </p>
    </div>
    
    <a href="{{ route('admin.properties.create') }}" class="bg-brand-cta text-white px-6 py-3 rounded shadow-md hover:bg-brand-primary hover:shadow-lg transition-all duration-300 uppercase text-[10px] font-bold tracking-widest flex items-center gap-2 transform hover:-translate-y-0.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Novo Ativo
    </a>
</div>

{{-- ESTATÍSTICAS (KPIs) --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    {{-- Card 1: Total --}}
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between group hover:border-brand-premium/30 transition-all hover:shadow-md">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Portfólio Total</p>
            <p class="text-3xl font-didot text-brand-primary group-hover:text-brand-premium transition-colors">
                {{ \App\Models\Property::count() }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-brand-primary/5 flex items-center justify-center text-brand-primary group-hover:bg-brand-premium/10 group-hover:text-brand-premium transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
    </div>

    {{-- Card 2: Venda --}}
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between group hover:border-brand-cta/30 transition-all hover:shadow-md">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Para Venda</p>
            <p class="text-3xl font-didot text-brand-cta">
                {{ \App\Models\Property::where('status', 'available')->orWhere('status', 'Venda')->count() }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-brand-cta/5 flex items-center justify-center text-brand-cta">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>

    {{-- Card 3: Arrendamento --}}
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between group hover:border-blue-300 transition-all hover:shadow-md">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Arrendamento</p>
            <p class="text-3xl font-didot text-blue-600">
                {{ \App\Models\Property::where('status', 'Arrendamento')->count() }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
    </div>
</div>

{{-- TABELA DE ÚLTIMAS ADIÇÕES --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
        <h3 class="font-serif text-lg text-brand-primary">Últimas Adições</h3>
        <a href="{{ route('admin.properties.index') }}" class="text-[10px] uppercase tracking-widest font-bold text-brand-cta hover:text-brand-primary transition-colors flex items-center gap-1">
            Ver Todos
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
            <thead class="bg-gray-50 text-[10px] uppercase text-gray-400 font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Imóvel</th>
                    <th class="px-6 py-4">Valor</th>
                    <th class="px-6 py-4">Localização</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Ação</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse(\App\Models\Property::latest()->take(5)->get() as $property)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    {{-- Imagem + Nome --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                @if($property->cover_image)
                                    <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('admin.properties.edit', $property) }}" class="font-bold text-brand-primary group-hover:text-brand-cta transition-colors block">
                                    {{ Str::limit($property->title, 25) }}
                                </a>
                                <p class="text-[9px] text-gray-400 uppercase tracking-wide font-mono mt-0.5">{{ $property->reference_code ?? 'SEM REF' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Preço --}}
                    <td class="px-6 py-4 font-serif text-gray-700">
                        {{ $property->price ? number_format($property->price, 0, ',', '.') . ' €' : 'Sob Consulta' }}
                    </td>

                    {{-- Localização --}}
                    <td class="px-6 py-4 text-gray-500 font-light">{{ $property->location }}</td>

                    {{-- Estado --}}
                    <td class="px-6 py-4 text-center">
                        @if($property->is_visible)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-green-50 text-green-700 border border-green-100 uppercase tracking-wider">
                                Visível
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-gray-100 text-gray-500 border border-gray-200 uppercase tracking-wider">
                                Oculto
                            </span>
                        @endif
                    </td>

                    {{-- Ação --}}
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.properties.edit', $property) }}" class="p-2 text-gray-400 hover:text-brand-primary hover:bg-gray-100 rounded-full transition-colors inline-flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">
                        Ainda não existem imóveis registados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection