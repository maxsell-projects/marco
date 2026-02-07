@extends('layouts.panel')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl text-brand-dark">Usuários</h2>
            <p class="text-sm text-gray-500 uppercase tracking-widest text-[10px] mt-1">
                @if(Auth::user()->isAdmin()) Gestão de Base Global @else Minha Equipe de Clientes @endif
            </p>
        </div>
        
        <div class="flex flex-col md:flex-row gap-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                @if(Auth::user()->isAdmin())
                    <select name="role" onchange="this.form.submit()" class="bg-white border border-gray-200 text-xs font-bold uppercase tracking-widest rounded px-4 py-2 focus:outline-none focus:border-brand-gold">
                        <option value="">Níveis</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                        <option value="dev" {{ request('role') == 'dev' ? 'selected' : '' }}>Parceiros/Devs</option>
                        <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Clientes</option>
                    </select>
                @endif

                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nome ou email..." class="bg-white border border-gray-200 text-sm rounded pl-10 pr-4 py-2 focus:outline-none focus:border-brand-gold w-full md:w-64">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </form>

            <a href="{{ route('admin.users.create') }}" class="px-6 py-2 bg-brand-dark text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all shadow-md rounded-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Cadastro
            </a>
        </div>
    </div>

    {{-- ALERTA DE SENHA GERADA (IMPORTANTE) --}}
    @if(session('temp_password'))
        <div class="bg-brand-dark text-white p-6 rounded-xl shadow-xl mb-8 border-l-4 border-brand-gold animate-pulse">
            <div class="flex items-start gap-4">
                <div class="bg-brand-gold/20 p-2 rounded-full text-brand-gold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div class="flex-grow">
                    <h3 class="text-sm font-bold text-brand-gold uppercase tracking-widest mb-1">Atenção: Copie a Senha Agora!</h3>
                    <p class="text-xs text-gray-400 mb-4">Esta senha é temporária e não será exibida novamente por motivos de segurança.</p>
                    
                    <div class="flex flex-wrap gap-4 items-center bg-white/5 p-4 rounded border border-white/10">
                        <div>
                            <span class="text-[10px] text-gray-500 block uppercase">E-mail de acesso</span>
                            <span class="text-sm font-mono select-all">{{ session('approved_user_email') ?? 'Verifique na lista abaixo' }}</span>
                        </div>
                        <div class="h-8 w-px bg-white/10 hidden md:block"></div>
                        <div>
                            <span class="text-[10px] text-gray-500 block uppercase">Senha Provisória</span>
                            <span class="text-brand-gold text-lg font-mono font-bold select-all tracking-wider">{{ session('temp_password') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- TABELA --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase tracking-widest text-gray-400 font-bold">
                        <th class="p-6">Usuário</th>
                        <th class="p-6">Responsável</th>
                        <th class="p-6">Função</th>
                        <th class="p-6">Status</th>
                        <th class="p-6 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-brand-dark font-serif font-bold border border-gray-200">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-brand-dark text-sm">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                            @if($user->parent)
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-gray-600">{{ $user->parent->name }}</span>
                                    <span class="text-[9px] uppercase text-brand-gold font-bold">Dev Resp.</span>
                                </div>
                            @else
                                <span class="text-[10px] text-gray-300 uppercase italic">Direto / Admin</span>
                            @endif
                        </td>
                        <td class="p-6">
                            @php
                                $roles = [
                                    'admin' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'label' => 'Admin'],
                                    'dev' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'label' => 'Developer'],
                                    'client' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'label' => 'Cliente'],
                                ];
                                $style = $roles[$user->role] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'label' => $user->role];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $style['bg'] }} {{ $style['text'] }} border border-current opacity-80">
                                {{ $style['label'] }}
                            </span>
                        </td>
                        <td class="p-6">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-green-600 uppercase tracking-tight">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Ativo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-400 uppercase tracking-tight animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Inativo
                                </span>
                            @endif
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.index', ['edit' => $user->id]) }}" class="p-2 text-gray-400 hover:text-brand-dark hover:bg-gray-100 rounded transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.index', $user->id) }}" method="POST" onsubmit="return confirm('Apagar este usuário permanentemente?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto text-gray-100 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <p class="text-sm font-medium">Nenhum usuário encontrado na base.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection