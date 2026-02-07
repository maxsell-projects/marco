@extends('layouts.panel')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Meus Favoritos</h1>
        <p class="text-sm text-gray-500">Imóveis que você marcou como interessantes.</p>
    </div>

    @if($favorites->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">Nenhum favorito ainda</h3>
            <p class="mt-1 text-sm text-gray-500">Comece a explorar e salve o que gostar.</p>
            <div class="mt-6">
                <a href="{{ route('properties.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Explorar Imóveis
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($favorites as $property)
                <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-md transition">
                    <div class="h-48 bg-gray-200 w-full relative">
                        @if($property->images->count() > 0)
                            <img src="{{ asset('storage/' . $property->images->first()->path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">Sem imagem</div>
                        @endif
                        
                        <div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                            {{ $property->visibility === 'off_market' ? 'Off-Market' : 'Público' }}
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-medium text-gray-900 truncate">{{ $property->title }}</h3>
                        <p class="text-indigo-600 font-bold mt-1">€ {{ number_format($property->price, 2, ',', '.') }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('properties.show', $property->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Ver Detalhes</a>
                            
                            <form action="{{ route('client.favorites.toggle', $property->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remover</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $favorites->links() }}
        </div>
    @endif
@endsection