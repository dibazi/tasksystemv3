<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
        </template>

        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="block mb-8">
                <a href="#" @click.prevent="Tasks" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150" style="margin-bottom: 10px;">Create Task</a>
            </div>

            <!-- Search Form -->
            <div class="block mb-8">
                <form @submit.prevent="search">
                    <input type="text" v-model="searchQuery" placeholder="Search by description" class="px-4 py-2 rounded-md shadow-sm border-gray-300">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                </form>
            </div>

            <div v-if="tasks.data.length > 0" class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 block w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assign By</th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assign To</th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="task in tasks.data" :key="task.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ task.id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ getUserName(task.assign_by) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ getUserName(task.assign_to) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ task.dead_line }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ task.status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ truncate(task.description, 10) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" @click.prevent="viewTask(task.id)" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">View</a>
                                            <a href="#" @click.prevent="editTask(task.id)" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>
                                            <form @submit.prevent="deleteTask(task.id)" class="inline-block">
                                                <button type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div v-if="tasks.links.length > 1" class="mt-4 flex justify-center">
                                <nav aria-label="Pagination">
                                    <ul class="pagination flex space-x-2">
                                        <li v-for="link in tasks.links" :key="link.url" :class="{ 'page-item': true, 'active': link.active, 'disabled': !link.url }">
                                            <button @click="fetchTasks(link.url)" class="page-link px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" :disabled="!link.url" v-html="link.label"></button>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="flex justify-center items-center h-64">
                <p class="text-gray-500">No tasks available.</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, watchEffect } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const { props } = usePage();
const tasks = ref(props.tasks);
const users = ref(props.users);
const searchQuery = ref('');
const truncate = (text, length) => text.length <= length ? text : text.substring(0, length) + '...';

const viewTask = id => Inertia.get(`/tasks/${id}/show`);
const editTask = id => Inertia.get(`/tasks/${id}/edit`);
const Tasks = () => Inertia.get(`/tasks/create`);
const deleteTask = id => {
    if (confirm('Are you sure you want to delete this task?')) {
        Inertia.delete(`/tasks/${id}`, {
            onSuccess: () => tasks.value.data = tasks.value.data.filter(task => task.id !== id)
        });
    }
};

const search = () => {
    Inertia.get(route('tasks.index'), { search: searchQuery.value });
};

const fetchTasks = (url) => {
    if (url) {
        Inertia.visit(url, {
            onSuccess: page => {
                tasks.value = page.props.tasks;
            }
        });
    }
};

const getUserName = (userId) => {
  const user = users.value[userId];
  return user ? user.name : 'Unknown User';
};

watchEffect(() => {
    tasks.value = props.tasks;
    users.value = props.users;
});
</script>

<style>
/* Your component styles */
</style>
