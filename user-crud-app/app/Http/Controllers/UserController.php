<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // List all user 
    public function index()
    {
        $users = $this->userService->listarUsuarios();
        return response()->json(['success' => true, 'data' => $users]);
    }

    // Create user
    public function store(Request $request)
    {
        $result = $this->userService->criarUsuario($request);

        if (!$result['success']) {
            return response()->json(['success' => false, 'errors' => $result['errors']], 422);
        }

        return response()->json(['success' => true, 'data' => $result['data']], 201);
    }

    // Update User
    public function update(Request $request, $cpf)
    {
        $result = $this->userService->atualizarUsuario($request, $cpf);

        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message']], 404);
        }

        return response()->json(['success' => true, 'data' => $result['data']]);
    }

    // Delete User
    public function destroy($cpf)
    {
        $result = $this->userService->excluirUsuario($cpf);

        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message']], 404);
        }

        return response()->json(['success' => true, 'message' => $result['message']]);
    }
}
