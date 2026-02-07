@extends('layouts.panel')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="font-serif text-3xl text-brand-dark">Blog & Notícias</h2>
        <p class="text-sm text-gray-500">Gerencie o conteúdo editorial do site.</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="px-6 py-2 bg-brand-dark text-white text-sm font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors shadow-lg">
        + Novo Artigo
    </a>
</div>

<div class="bg-white rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold">
                    <th class="p-6">Artigo</th>
                    <th class="p-6">Autor</th>
                    <th class="p-6">Status</th>
                    <th class="p-6">Data</th>
                    <th class="p-6 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($posts as $post)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                             <div class="w-12 h-12 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                @if($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="font-bold text-brand-dark hover:text-brand-gold transition-colors">
                                {{ $post->title }}
                            </a>
                        </div>
                    </td>
                    <td class="p-6 text-sm text-gray-600">
                        {{ $post->author->name }}
                    </td>
                    <td class="p-6">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest 
                            {{ $post->status === 'published' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $post->status === 'published' ? 'Publicado' : 'Rascunho' }}
                        </span>
                    </td>
                    <td class="p-6 text-xs text-gray-400">
                        {{ $post->created_at->format('d/m/Y') }}
                    </td>
                    <td class="p-6 text-right">
                        <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-gray-400 hover:text-blue-600" title="Ver no Site">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="text-gray-400 hover:text-brand-gold" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                             <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Excluir este artigo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Excluir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">Nenhum artigo encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">{{ $posts->links() }}</div>
</div>
@endsection