<template>
    <nav class="pagination">
        <ul class="flex justify-center space-x-2">
            <li v-for="link in links" :key="link.url" :class="{'font-bold': link.active}">
                <a href="#" @click.prevent="navigate(link.url)" v-html="link.label"></a>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';

const props = defineProps({
    links: Array
});

const emit = defineEmits(['navigate']);

const navigate = (url) => {
    if (url) {
        emit('navigate', url);
    }
};
</script>

<style scoped>
.pagination a {
    padding: 0.5rem 1rem;
    color: #1a202c;
    border: 1px solid #e2e8f0;
    border-radius: 0.25rem;
    text-decoration: none;
}
.pagination a:hover {
    background-color: #edf2f7;
}
</style>
