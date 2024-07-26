<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tasks
            </h2>
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

            <div class="flex flex-col">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ task.assign_by }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ task.assign_to }}</td>
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
                            <div class="mt-4">
                                <pagination :links="tasks.links" @navigate="fetchTasks" />
                            </div>
                        </div>
                    </div>
                </div>
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
    Inertia.visit(url, {
        onSuccess: page => {
            tasks.value = page.props.tasks;
        }
    });
};

watchEffect(() => tasks.value = props.tasks);
</script>

<style>
/* Your component styles */
</style>
