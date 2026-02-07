@extends('layouts.app')

@section('content')
<div class="relative h-[60vh] bg-gray-900 flex items-center justify-center">
    @if($post->image_path)
        <img src="{{ asset('storage/' . $post->image_path) }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
    @endif
    <div class="relative z-10 text-center max-w-4xl px-6">
        <span class="inline-block px-3 py-1 bg-brand-gold text-white text-[10px] font-bold uppercase tracking-widest mb-4">
            Blog
        </span>
        <h1 class="font-serif text-4xl md:text-6xl text-white mb-6 leading-tight shadow-black drop-shadow-lg">
            {{ $post->title }}
        </h1>
        <div class="flex items-center justify-center gap-4 text-white/80 text-sm font-medium">
            <span>{{ $post->created_at->format('d de F, Y') }}</span>
            <span>&bull;</span>
            <span>Por {{ $post->author->name }}</span>
        </div>
    </div>
</div>

<div class="bg-white py-20">
    <div class="container mx-auto px-6 max-w-3xl">
        <div class="prose prose-lg prose-headings:font-serif prose-a:text-brand-gold prose-img:rounded-xl text-gray-600">
            {!! nl2br(e($post->content)) !!}
        </div>

        <div class="mt-12 pt-12 border-t border-gray-100 flex justify-between items-center">
            <a href="{{ route('blog.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-brand-dark transition-colors">
                &larr; Voltar para o Blog
            </a>
        </div>
    </div>
</div>
@endsection