<!-- resources/js/Pages/Tasks/Show.vue -->
<template>
    <AppLayout title="Task Details">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task Details
            </h2>
        </template>

        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="block mb-8">
                <a @click.prevent="Tasks" class="text-gray-700 hover:text-gray-900 cursor-pointer">
                    &larr; Back to Tasks
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Task Details</h3>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">ID</label>
                        <div class="mt-1 text-gray-900">{{ task.id }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Assign By</label>
                        <div class="mt-1 text-gray-900">{{ getUserName(task.assign_by) }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Assign To</label>
                        <div class="mt-1 text-gray-900">{{ getUserName(task.assign_to) }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Deadline</label>
                        <div class="mt-1 text-gray-900">{{ task.dead_line }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1 text-gray-900">{{ task.status }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1 text-gray-900">{{ task.description }}</div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <router-link :to="{ name: 'tasks.edit', params: { id: task.id } }" class="text-blue-600 hover:text-blue-900">
                            Edit
                        </router-link>
                        <form @submit.prevent="deleteTask(task.id)" class="inline-block">
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AppLayout from '@/Layouts/AppLayout.vue';

// Get props from the Inertia page
const { props } = usePage();
const task = ref(props.task);
const users = ref(props.users);

const Tasks = () => {
    Inertia.get('/tasks');
};

const getUserName = (userId) => {
  const user = users.value[userId];
  return user ? user.name : 'Unknown User';
};

const deleteTask = (id) => {
    if (confirm('Are you sure you want to delete this task?')) {
        Inertia.delete(`/tasks/${id}`, {
            onSuccess: () => {
                Inertia.visit('/tasks');
            }
        });
    }
};
</script>

<style scoped>
/* Add any scoped styles here */
</style>
