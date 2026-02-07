@extends('layouts.panel')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- HEADER DINÂMICO --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl text-brand-dark">
                @if(Auth::user()->isAdmin()) Equipe & Carteira @else Minha Carteira @endif
            </h2>
            <p class="text-sm text-gray-500">
                @if(Auth::user()->isAdmin()) 
                    Gestão global de parceiros e seus respectivos clientes vinculados.
                @else 
                    Gerencie seus clientes e visualize quem tem acesso aos seus imóveis.
                @endif
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="px-6 py-2 bg-brand-dark text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all shadow-md rounded-sm flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo Cadastro
        </a>
    </div>

    {{-- LISTAGEM --}}
    <div class="space-y-6">
        @forelse($devs as $dev)
        {{-- x-data inicia expandido se houver apenas um (visão do Dev) --}}
        <div x-data="{ expanded: {{ $devs->count() === 1 ? 'true' : 'false' }} }" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            
            {{-- HEADER DO CARD --}}
            <div @click="expanded = !expanded" class="p-6 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-brand-dark text-brand-gold flex items-center justify-center font-serif font-bold text-lg border-2 border-brand-gold/20">
                        {{ substr($dev->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-brand-dark flex items-center gap-2">
                            {{ $dev->name }}
                            @if($dev->id === Auth::id())
                                <span class="bg-blue-100 text-blue-700 text-[9px] px-2 py-0.5 rounded-full uppercase">Você</span>
                            @endif
                        </h3>
                        <p class="text-xs text-gray-400 uppercase tracking-widest">{{ $dev->email }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-gray-400 uppercase tracking-widest">Carteira Ativa</p>
                        <p class="font-bold text-brand-gold text-lg">
                            {{ $dev->team_count }} 
                            <span class="text-xs text-gray-400 font-normal">clientes</span>
                        </p>
                    </div>
                    <div :class="expanded ? 'rotate-180' : ''" class="transition-transform duration-300 text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            {{-- CONTEÚDO EXPANSÍVEL (CLIENTES) --}}
            <div x-show="expanded" x-collapse class="bg-gray-50 border-t border-gray-100">
                @if($dev->team->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-200">
                                    <th class="px-8 py-4">Cliente</th>
                                    <th class="px-8 py-4">Email</th>
                                    <th class="px-8 py-4">Cadastro</th>
                                    <th class="px-8 py-4 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($dev->team as $client)
                                <tr class="hover:bg-white transition-colors">
                                    <td class="px-8 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-700 text-sm">{{ $client->name }}</span>
                                            <span class="text-[10px] text-gray-400">{{ $client->phone_number ?? 'Sem telefone' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-500">{{ $client->email }}</td>
                                    <td class="px-8 py-4 text-xs text-gray-400">{{ $client->created_at->format('d/m/Y') }}</td>
                                    <td class="px-8 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.users.edit', $client->id) }}" class="text-[10px] font-bold text-brand-dark hover:text-brand-gold uppercase tracking-tighter">
                                                Editar Perfil
                                            </a>
                                            <span class="text-gray-200">|</span>
                                            {{-- Nota: Este link deve levar à gestão de imóveis do cliente --}}
                                            <a href="{{ route('admin.users.index', ['search' => $client->email]) }}" class="text-[10px] font-bold text-brand-gold hover:underline uppercase tracking-tighter">
                                                Ver Imóveis
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <p class="text-gray-400 text-sm italic">Nenhum cliente vinculado a esta carteira.</p>
                        <a href="{{ route('admin.users.create') }}" class="text-brand-gold text-xs font-bold uppercase mt-2 inline-block hover:underline">Vincular primeiro cliente</a>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div class="p-16 text-center bg-white rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-400">Nenhum registro encontrado.</p>
        </div>
        @endforelse

        <div class="mt-6">
            {{ $devs->links() }}
        </div>
    </div>
</div>
@endsection