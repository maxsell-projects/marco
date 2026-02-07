@extends('layouts.panel')

@section('content')

{{-- MODAL DE SENHA PROVISÓRIA (Aparece só ao aprovar) --}}
@if(session('temp_password'))
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8 text-center border-t-4 border-brand-gold">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="font-serif text-2xl text-brand-dark mb-2">Acesso Aprovado!</h3>
        <p class="text-gray-500 text-sm mb-6">O usuário <strong>{{ session('approved_user') }}</strong> está ativo. Copie a senha abaixo e envie para ele.</p>
        
        <div class="bg-gray-100 p-4 rounded-lg mb-6 border border-gray-200">
            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Senha Provisória</p>
            <p class="font-mono text-2xl font-bold text-brand-dark tracking-wider select-all">{{ session('temp_password') }}</p>
        </div>

        <button onclick="this.closest('.fixed').remove()" class="w-full py-3 bg-brand-dark text-white font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors">
            Fechar
        </button>
    </div>
</div>
@endif

<div class="mb-6">
    <h2 class="font-serif text-3xl text-brand-dark">Solicitações de Acesso</h2>
    <p class="text-sm text-gray-500">Analise documentos e mensagens antes de liberar o acesso.</p>
</div>

<div class="bg-white rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold">
                    <th class="p-6">Usuário</th>
                    <th class="p-6">Data Solicitação</th>
                    <th class="p-6">Tipo</th>
                    <th class="p-6 text-right">Ação</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($requests as $req)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-brand-gold text-white flex items-center justify-center font-bold">
                                {{ substr($req->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-brand-dark">{{ $req->name }}</p>
                                <p class="text-xs text-gray-400">{{ $req->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-6 text-sm text-gray-500">
                        {{ $req->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-6">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-widest rounded-full">
                            {{ $req->role }}
                        </span>
                    </td>
                    <td class="p-6 text-right">
                        <a href="{{ route('admin.requests.show', $req->id) }}" class="inline-block px-4 py-2 border border-brand-dark text-brand-dark text-xs font-bold uppercase tracking-widest hover:bg-brand-dark hover:text-white transition-colors">
                            Analisar
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-gray-400">
                        Nenhuma solicitação pendente no momento.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">
        {{ $requests->links() }}
    </div>
</div>
@endsection