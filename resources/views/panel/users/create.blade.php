@extends('layouts.panel')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="font-serif text-3xl text-brand-dark">Novo Usuário</h2>
        <p class="text-sm text-gray-500">Adicione um membro à equipe ou um cliente à sua carteira.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Nome Completo</label>
                <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 p-3 rounded">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Email</label>
                <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 p-3 rounded">
            </div>

            @if(Auth::user()->isAdmin())
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Função</label>
                <select name="role" class="w-full bg-gray-50 border border-gray-200 p-3 rounded">
                    <option value="client">Cliente</option>
                    <option value="dev">Developer (Parceiro)</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            @else
                <input type="hidden" name="role" value="client">
                <p class="text-sm text-gray-500 italic">Como Developer, você está cadastrando um <strong>Cliente</strong> para sua carteira.</p>
            @endif

            <button type="submit" class="w-full py-3 bg-brand-dark text-white font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors">
                Criar Usuário
            </button>
        </div>
    </form>
</div>
@endsection