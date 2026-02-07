@extends('layouts.panel')

@section('content')
<div class="mb-8">
    <h2 class="font-serif text-3xl text-brand-dark">Equipe & Carteira</h2>
    <p class="text-sm text-gray-500">Visualize seus parceiros (Devs) e a carteira de clientes de cada um.</p>
</div>

<div class="space-y-6">
    @forelse($devs as $dev)
    <div x-data="{ expanded: false }" class="bg-white rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
        
        <div @click="expanded = !expanded" class="p-6 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-brand-dark text-white flex items-center justify-center font-serif font-bold text-lg">
                    {{ substr($dev->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-lg text-brand-dark">{{ $dev->name }}</h3>
                    <p class="text-xs text-gray-400 uppercase tracking-widest">{{ $dev->email }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-widest">Carteira</p>
                    <p class="font-bold text-brand-gold text-lg">{{ $dev->clients_count }} <span class="text-xs text-gray-400 font-normal">clientes</span></p>
                </div>
                <div :class="expanded ? 'rotate-180' : ''" class="transition-transform duration-300 text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        <div x-show="expanded" x-collapse class="bg-gray-50 border-t border-gray-100">
            @if($dev->clients->count() > 0)
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-200">
                            <th class="px-8 py-3">Cliente Vinculado</th>
                            <th class="px-8 py-3">Email</th>
                            <th class="px-8 py-3">Entrou em</th>
                            <th class="px-8 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($dev->clients as $client)
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="px-8 py-4 font-medium text-gray-700">{{ $client->name }}</td>
                            <td class="px-8 py-4 text-sm text-gray-500">{{ $client->email }}</td>
                            <td class="px-8 py-4 text-xs text-gray-400">{{ $client->created_at->format('d/m/Y') }}</td>
                            <td class="px-8 py-4 text-right">
                                <a href="#" class="text-xs font-bold text-brand-gold hover:underline uppercase tracking-widest">
                                    Ver Acessos
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-gray-400 text-sm italic">
                    Este parceiro ainda não possui clientes vinculados.
                </div>
            @endif
        </div>
    </div>
    @empty
    <div class="p-12 text-center bg-white rounded-xl border border-dashed border-gray-300">
        <p class="text-gray-400">Nenhum Developer cadastrado na plataforma.</p>
    </div>
    @endforelse

    <div class="mt-6">
        {{ $devs->links() }}
    </div>
</div>
@endsection