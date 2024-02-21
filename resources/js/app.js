import './bootstrap';
import { createApp } from 'vue';
import TaskList from './components/TaskList.vue'; // TaskList bileşenini dahil edin
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

// Yeni bir Vue uygulaması oluşturun
const app = createApp({});

// TaskList bileşenini tanımlayın
app.component('task-list', TaskList);

// Vue uygulamasını belirli bir HTML öğesine bağlayın
app.mount('#app');
