@extends('layouts.panel')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-gray-400 hover:text-brand-dark uppercase tracking-widest flex items-center gap-2 mb-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Voltar
            </a>
            <h2 class="font-serif text-3xl text-brand-dark">Novo Cadastro</h2>
        </div>
        <button type="submit" form="createUserForm" class="px-8 py-3 bg-brand-dark text-white text-sm font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors shadow-lg rounded-sm">
            Salvar Registro
        </button>
    </div>

    <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Nome --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Nome Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Telefone --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Telefone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
            </div>

            {{-- Seletor de Cargo (SÓ ADMIN VÊ) --}}
            @if(Auth::user()->isAdmin())
                <div class="md:col-span-2 pt-4 border-t border-gray-100 mt-4">
                    <label class="block text-xs font-bold uppercase tracking-widest text-brand-dark mb-4">Tipo de Acesso</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer group">
                            <input type="radio" name="role" value="client" class="peer sr-only" checked>
                            <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-brand-gold peer-checked:bg-brand-gold/5 transition-all group-hover:border-gray-300">
                                <span class="block text-sm font-bold text-gray-700 peer-checked:text-brand-dark">Cliente / Investidor</span>
                                <span class="text-xs text-gray-400">Acesso apenas à área do cliente e favoritos.</span>
                            </div>
                        </label>

                        <label class="cursor-pointer group">
                            <input type="radio" name="role" value="dev" class="peer sr-only">
                            <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-brand-gold peer-checked:bg-brand-gold/5 transition-all group-hover:border-gray-300">
                                <span class="block text-sm font-bold text-gray-700 peer-checked:text-brand-dark">Parceiro / Dev</span>
                                <span class="text-xs text-gray-400">Pode cadastrar imóveis e gerir seus próprios clientes.</span>
                            </div>
                        </label>
                    </div>
                </div>
            @else
                {{-- DEV: Campo Oculto (Força Client) --}}
                <div class="md:col-span-2 pt-4 border-t border-gray-100 mt-4">
                    <p class="text-xs text-gray-400">
                        <span class="font-bold text-brand-gold">Nota:</span> Este usuário será cadastrado como <strong>Cliente</strong> e vinculado à sua equipe automaticamente.
                    </p>
                </div>
            @endif

        </div>
    </form>
</div>
@endsection