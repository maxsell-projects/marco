@extends('layouts.panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="font-serif text-3xl text-brand-dark">Editar Artigo</h2>
    </div>

    <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Título</label>
            <input type="text" name="title" value="{{ $post->title }}" required class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Imagem de Capa (Opcional)</label>
            @if($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}" class="h-32 rounded mb-2 object-cover">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-sm text-gray-500">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Conteúdo</label>
            <textarea name="content" rows="12" required class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">{{ $post->content }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Status</label>
            <select name="status" class="w-full md:w-1/3 bg-gray-50 border border-gray-200 p-3 rounded">
                <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Rascunho</option>
                <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Publicado</option>
            </select>
        </div>

        <button type="submit" class="w-full py-3 bg-brand-dark text-white font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors">
            Atualizar Artigo
        </button>
    </form>
</div>
@endsection