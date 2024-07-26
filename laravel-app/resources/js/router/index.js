// resources/js/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import TasksIndex from '../Pages/Tasks/Index.vue';
import TaskCreate from '../Pages/Tasks/Create.vue';
import TaskShow from '../Pages/Tasks/Edit.vue';
import TaskEdit from '../Pages/TaskEdit.vue';

const routes = [
    { path: '/tasks', name: 'tasks.index', component: TasksIndex },
    { path: '/tasks/create', name: 'task.create', component: TaskCreate },
    { path: '/tasks/:id', name: 'task.show', component: TaskShow },
    { path: '/tasks/:id/edit', name: 'task.edit', component: TaskEdit },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
