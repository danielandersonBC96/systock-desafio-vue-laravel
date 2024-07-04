<template>
  <div>
    <h1>Lista de Usuários</h1>
    
    <!-- create user -->
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

    <!-- Table users -->
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

<script>
import axios from 'axios';

export default {
  name: 'UserList',
  data() {
    return {
      users: [],
      formData: {
        name: '',
        cpf: '',
        email: '',
        password: '',
      },
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get('http://localhost:8000/users');
        this.users = response.data.data;
      } catch (error) {
        console.error('Erro ao buscar usuários:', error);
      }
    },
    async criarUsuario() {
      try {
        const response = await axios.post('http://localhost:8000/users', this.formData);
        this.users.push(response.data.data); // Add a new  usuer local list
        this.resetForm();
      } catch (error) {
        console.error('Erro ao criar usuário:', error);
      }
    },
    async editarUsuario(cpf) {
      
      console.log('Editar usuário com CPF:', cpf);
    },
    async excluirUsuario(cpf) {
      try {
        await axios.delete(`http://localhost:8000/users/${cpf}`);
        this.users = this.users.filter(user => user.cpf !== cpf); // Remove  user local list
      } catch (error) {
        console.error('Erro ao excluir usuário:', error);
      }
    },
    resetForm() {
      this.formData = {
        name: '',
        cpf: '',
        email: '',
        password: '',
      };
    },
  },
};
</script>

<style scoped>
.user-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.user-table th,
.user-table td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}

.user-table th {
  background-color: #f2f2f2;
}

.user-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.user-table tbody tr:hover {
  background-color: #f1f1f1;
}

.user-table .form-container {
  margin-top: 20px;
}

.user-table .form-container label {
  display: block;
  margin-bottom: 5px;
}

.user-table .form-container input[type="text"],
.user-table .form-container input[type="email"],
.user-table .form-container input[type="password"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.user-table .form-container button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.user-table .form-container button:hover {
  background-color: #45a049;
}
</style>
