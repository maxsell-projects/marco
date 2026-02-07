@extends('layouts.panel')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="font-serif text-3xl text-brand-dark">Usuários</h2>
        <p class="text-sm text-gray-500">Gestão completa da base de cadastros.</p>
    </div>
    
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <select name="role" onchange="this.form.submit()" class="bg-white border border-gray-200 text-sm rounded px-4 py-2 focus:outline-none focus:border-brand-gold">
            <option value="">Todos os Níveis</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administradores</option>
            <option value="dev" {{ request('role') == 'dev' ? 'selected' : '' }}>Developers (Parceiros)</option>
            <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Clientes Finais</option>
        </select>

        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar nome ou email..." class="bg-white border border-gray-200 text-sm rounded pl-10 pr-4 py-2 focus:outline-none focus:border-brand-gold w-full md:w-64">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold">
                    <th class="p-6">Usuário</th>
                    <th class="p-6">Função</th>
                    <th class="p-6">Status</th>
                    <th class="p-6">Cadastro</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-brand-dark font-serif font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-brand-dark">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
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
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $style['bg'] }} {{ $style['text'] }}">
                            {{ $style['label'] }}
                        </span>
                    </td>
                    <td class="p-6">
                        @if($user->is_active)
                            <span class="flex items-center gap-1 text-xs font-medium text-green-600">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> Ativo
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-xs font-medium text-red-400">
                                <span class="w-2 h-2 rounded-full bg-red-400"></span> Inativo
                            </span>
                        @endif
                    </td>
                    <td class="p-6 text-sm text-gray-500">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-gray-400">Nenhum usuário encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection