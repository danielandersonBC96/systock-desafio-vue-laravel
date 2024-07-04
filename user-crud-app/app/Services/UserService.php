<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // List all user
    public function listarUsuarios()
    {
        return $this->userRepository->listarTodos();
    }

    // Creat user
    public function criarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $dados = [
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = $this->userRepository->criar($dados);

        return ['success' => true, 'data' => $user];
    }

    // Update user
    public function atualizarUsuario(Request $request, $cpf)
    {
        $user = $this->userRepository->encontrarPorCpf($cpf);

        if (!$user) {
            return ['success' => false, 'message' => 'Usuário não encontrado'];
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'cpf' => 'sometimes|required|string|size:11|unique:users,cpf,' . $user->id,
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $dados = [];
        if ($request->has('name')) $dados['name'] = $request->name;
        if ($request->has('cpf')) $dados['cpf'] = $request->cpf;
        if ($request->has('email')) $dados['email'] = $request->email;
        if ($request->has('password')) $dados['password'] = Hash::make($request->password);

        $user = $this->userRepository->atualizar($user, $dados);

        return ['success' => true, 'data' => $user];
    }

    // Delete user
    public function excluirUsuario($cpf)
    {
        $user = $this->userRepository->encontrarPorCpf($cpf);

        if (!$user) {
            return ['success' => false, 'message' => 'Usuário não encontrado'];
        }

        $this->userRepository->excluir($user);
        return ['success' => true, 'message' => 'Usuário excluído com sucesso'];
    }
}