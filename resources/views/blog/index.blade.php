@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-20">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="font-serif text-4xl md:text-5xl text-brand-dark mb-4">Blog & Insights</h1>
            <p class="text-gray-500">Tendências do mercado imobiliário e novidades da nossa equipe.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($posts as $post)
            <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col h-full group">
                <a href="{{ route('blog.show', $post->slug) }}" class="block h-56 overflow-hidden bg-gray-200">
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">Sem Imagem</div>
                    @endif
                </a>
                <div class="p-8 flex-1 flex flex-col">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-gold mb-3">{{ $post->created_at->format('d M, Y') }}</p>
                    <h2 class="font-serif text-xl text-brand-dark mb-4 group-hover:text-brand-gold transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="text-gray-500 text-sm mb-6 flex-1 line-clamp-3">
                        {{ Str::limit(strip_tags($post->content), 120) }}
                    </p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-xs font-bold uppercase tracking-widest text-brand-dark hover:underline">
                        Ler Mais &rarr;
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-20">
                <p class="text-gray-400 text-lg">Em breve novidades por aqui.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection