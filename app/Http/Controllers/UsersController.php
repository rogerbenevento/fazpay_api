<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Lista de usuários.
     *
     * Lista os usuários de forma paginada, com filtro por nome, com o parametro via queryString:
     * - search: string
     */
    public function index()
    {
        $query = User::query()->orderBy('name');

        if ($search = request('search')) {
            $query->where('name', 'like', "%$search%");
        }

        $users = $query->paginate(10);

        return response()->json(UserResource::collection($users)->resource);
    }

    /**
     * Adiciona um novo usuário ao banco de dados.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $user = User::create($request->validated());

            return response()->json(new UserResource($user), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibe um usuário específico.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Atualiza um usuário específico.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $user->update($request->validated());

            return response()->json(new UserResource($user));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove um usuário específico.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json(['message' => 'Usuário removido com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
