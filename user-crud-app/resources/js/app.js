import { createApp } from 'vue';
import axios from 'axios';
import App from './components/App.vue';

axios.defaults.baseURL = 'http://localhost:8000';

const app = createApp(App);

// Configuração global do Axios no Vue
app.config.globalProperties.$http = axios;

app.mount('#app');
