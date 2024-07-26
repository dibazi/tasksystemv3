<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Create task
            </h2>
        </template>

        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="assign_to" class="block font-medium text-sm text-gray-700">Assign to</label>
                            <select v-model="form.assign_to" id="assign_to" class="form-select rounded-md shadow-sm mt-1 block w-1/2">
                                <option value="">Select a user</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                            <p v-if="errors.assign_to" class="text-sm text-red-600">{{ errors.assign_to }}</p>
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="dead_line" class="block font-medium text-sm text-gray-700">Deadline</label>
                            <input type="date" v-model="form.dead_line" id="dead_line" class="form-input rounded-md shadow-sm mt-1 block w-1/2" />
                            <p v-if="errors.dead_line" class="text-sm text-red-600">{{ errors.dead_line }}</p>
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea v-model="form.description" id="description" class="form-input rounded-md shadow-sm mt-1 block w-1/2"></textarea>
                            <p v-if="errors.description" class="text-sm text-red-600">{{ errors.description }}</p>
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select v-model="form.status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-1/2">
                                <option value="incomplete">Incomplete</option>
                                <option value="complete">Complete</option>
                            </select>
                            <p v-if="errors.status" class="text-sm text-red-600">{{ errors.status }}</p>
                        </div>

                        <input type="hidden" v-model="form.assign_by" />

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const { props } = usePage();
const users = ref(props.users);
const errors = ref(props.errors || {});
const auth = ref(props.auth);

const form = ref({
    assign_to: '',
    dead_line: '',
    description: '',
    status: 'incomplete',
    assign_by: auth.value.user.id,
});

const submit = () => {
    Inertia.post(route('tasks.store'), form.value, {
        onError: (errors) => {
            // Handle errors if necessary
        },
        onSuccess: () => {
            // Handle success if necessary
        }
    });
};
</script>
