<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    // List all user
    public function listarTodos()
    {
        return User::all();
    }

    // Create user
    public function criar(array $dados)
    {
        return User::create($dados);
    }

    // Get by CPF
    public function encontrarPorCpf($cpf)
    {
        return User::where('cpf', $cpf)->first();
    }

    // Update by user
    public function atualizar(User $user, array $dados)
    {
        $user->update($dados);
        return $user;
    }

    //delete user 
    public function excluir(User $user)
    {
        $user->delete();
    }
}
