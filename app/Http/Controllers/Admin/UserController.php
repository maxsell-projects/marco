<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): View
    {
        $users = $this->userService->listUsers($request->all(), Auth::user());
        
        return view('panel.users.index', compact('users'));
    }

    /**
     * Exibe a listagem de equipe (hierarquia).
     * Corrigido para garantir que o relacionamento 'team' esteja sempre presente.
     */
    public function devs(): View
    {
        $currentUser = Auth::user();

        if (!$currentUser->isAdmin() && !$currentUser->isDev()) {
            abort(403);
        }

        // Iniciamos a query com Eager Loading da equipe e o contador
        // Isso garante que $dev->team nunca seja null na View
        $query = User::query()
            ->with(['team' => fn($q) => $q->latest()])
            ->withCount('team');

        if ($currentUser->isDev()) {
            // Se for Dev, foca apenas no registro dele (que contém sua equipe)
            $query->where('id', $currentUser->id);
        } else {
            // Se for Admin, lista todos os que possuem role 'dev'
            $query->where('role', 'dev')->latest();
        }

        $devs = $query->paginate(10);

        return view('panel.users.devs', compact('devs'));
    }

    public function create(): View
    {
        return view('panel.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $result = $this->userService->createUser($request->validated(), Auth::user());

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário cadastrado com sucesso!')
            ->with('temp_password', $result['temp_password']);
    }

    public function edit(User $user): View
    {
        $this->checkAuthorization($user);

        return view('panel.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->checkAuthorization($user);
        $this->userService->updateUser($user, $request->validated(), Auth::user());

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->checkAuthorization($user);

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        $this->userService->deleteUser($user);

        return back()->with('success', 'Usuário removido com sucesso.');
    }

    /**
     * Centraliza a lógica de autorização para garantir que 
     * Devs operem apenas sobre seus liderados.
     */
    private function checkAuthorization(User $user): void
    {
        if (Auth::user()->isDev() && $user->parent_id !== Auth::id()) {
            abort(403);
        }
    }
}