<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    // --- ÁREA PÚBLICA ---

    public function publicIndex()
    {
        $posts = BlogPost::where('status', 'published')
            ->latest()
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }

    // --- PAINEL (ADMIN / DEV) ---

    public function index()
    {
        $query = BlogPost::query();

        // Admin vê tudo. Dev vê apenas os seus.
        if (Auth::user()->isDev()) {
            $query->where('user_id', Auth::id());
        }

        $posts = $query->latest()->paginate(10);
        return view('panel.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('panel.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
            'status' => 'required|in:draft,published',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('blog', 'public');
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artigo criado com sucesso!');
    }

    public function edit(BlogPost $post)
    {
        // Segurança
        if (Auth::user()->isDev() && $post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('panel.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        // Segurança
        if (Auth::user()->isDev() && $post->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            // Remove imagem antiga se existir
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $data['image_path'] = $request->file('image')->store('blog', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artigo atualizado!');
    }

    public function destroy(BlogPost $post)
    {
        // Segurança
        if (Auth::user()->isDev() && $post->user_id !== Auth::id()) {
            abort(403);
        }

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Artigo removido.');
    }
}