@extends('layouts.panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="font-serif text-3xl text-brand-dark">Controle de Acesso</h2>
            <p class="text-sm text-gray-500">Imóvel: <strong>{{ $property->title }}</strong> ({{ $property->visibility }})</p>
        </div>
        <a href="{{ route('admin.properties.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-brand-dark">Voltar</a>
    </div>

    @if($property->visibility !== 'off_market' && $property->visibility !== 'private')
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <p class="text-sm text-yellow-700">
                <strong>Atenção:</strong> Este imóvel está marcado como <strong>{{ $property->visibility }}</strong>. 
                O controle de acesso abaixo só faz sentido real para imóveis <strong>Off-Market</strong> ou <strong>Privados</strong>.
            </p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold">
                    <th class="p-6">Cliente</th>
                    <th class="p-6">Email</th>
                    <th class="p-6 text-center">Acesso Permitido?</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($myClients as $client)
                    @php
                        $hasAccess = $property->authorizedUsers->contains($client->id);
                    @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-6 font-bold text-brand-dark">{{ $client->name }}</td>
                    <td class="p-6 text-gray-500 text-sm">{{ $client->email }}</td>
                    <td class="p-6 text-center">
                        <form action="{{ route('admin.properties.access.toggle', $property->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <button type="submit" 
                                class="px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest transition-all
                                {{ $hasAccess ? 'bg-green-100 text-green-700 hover:bg-red-100 hover:text-red-700' : 'bg-gray-100 text-gray-400 hover:bg-green-100 hover:text-green-700' }}">
                                {{ $hasAccess ? 'Sim (Clique para revogar)' : 'Não (Clique para liberar)' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-12 text-center text-gray-400">
                        Você não tem clientes cadastrados. 
                        <a href="{{ route('admin.users.create') }}" class="text-brand-gold hover:underline">Cadastre um cliente primeiro</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection