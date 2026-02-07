@extends('layouts.panel')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl text-brand-dark">Editar Usuário</h2>
            <p class="text-sm text-gray-500 mt-1">Atualize os dados e permissões</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-brand-dark underline">
            Voltar para Lista
        </a>
    </div>

    {{-- FORMULÁRIO --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NOME --}}
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nome Completo</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-sm focus:border-brand-gold focus:ring-brand-gold" required>
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-sm focus:border-brand-gold focus:ring-brand-gold" required>
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- TELEFONE --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Telefone</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="w-full border-gray-300 rounded-sm focus:border-brand-gold focus:ring-brand-gold">
                    @error('phone_number') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- PERFIL (ROLE) - Só aparece se NÃO for Dev editando cliente --}}
                @if(!Auth::user()->isDev())
                    <div class="col-span-2 border-t border-gray-100 pt-6 mt-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nível de Acesso</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer transition-all hover:bg-gray-50 {{ $user->role === 'client' ? 'border-brand-gold bg-yellow-50/30' : 'border-gray-200' }}">
                                <input type="radio" name="role" value="client" class="text-brand-gold focus:ring-brand-gold" {{ $user->role === 'client' ? 'checked' : '' }}>
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-900">Cliente</span>
                                    <span class="block text-xs text-gray-500">Acesso apenas à área pessoal</span>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer transition-all hover:bg-gray-50 {{ $user->role === 'dev' ? 'border-brand-gold bg-yellow-50/30' : 'border-gray-200' }}">
                                <input type="radio" name="role" value="dev" class="text-brand-gold focus:ring-brand-gold" {{ $user->role === 'dev' ? 'checked' : '' }}>
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-900">Parceiro / Dev</span>
                                    <span class="block text-xs text-gray-500">Gere seus próprios leads</span>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer transition-all hover:bg-gray-50 {{ $user->role === 'admin' ? 'border-brand-gold bg-yellow-50/30' : 'border-gray-200' }}">
                                <input type="radio" name="role" value="admin" class="text-brand-gold focus:ring-brand-gold" {{ $user->role === 'admin' ? 'checked' : '' }}>
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-red-700">Administrador</span>
                                    <span class="block text-xs text-gray-500">Acesso total ao sistema</span>
                                </div>
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 text-xs font-bold uppercase tracking-widest rounded-sm hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 bg-brand-dark text-white text-xs font-bold uppercase tracking-widest rounded-sm hover:bg-brand-gold transition-colors shadow-lg">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection