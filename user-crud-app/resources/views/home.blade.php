@extends('master')

@section('content')
    <h2>Home</h2>

    <template>
        <div>
            <h1>Lista de Usuários</h1>
            
            <!-- Formulário para criar usuário -->
            <form @submit.prevent="criarUsuario" class="form-container">
                <label for="name">Nome:</label>
                <input type="text" id="name" v-model="formData.name" required>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" v-model="formData.cpf" required>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="formData.email" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" v-model="formData.password" required>
                <button type="submit">Criar Usuário</button>
            </form>

            <!-- Tabela de usuários -->
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.cpf">
                        <td>{{ user.name }}</td>
                        <td>{{ user.cpf }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <button @click="editarUsuario(user.cpf)">Editar</button>
                            <button @click="excluirUsuario(user.cpf)">Excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>
@endsection
