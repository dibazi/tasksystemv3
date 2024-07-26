<template>
  <div class="home-page">
    <h1>Home Page</h1>
    <button @click="goToAboutPage" class="btn btn-primary">Go to About Page</button>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const goToAboutPage = () => {
  router.push({ name: 'about' });
};
</script>

<style scoped>
.btn {
  display: inline-flex;
  padding: 0.5rem 1rem;
  color: white;
  background-color: blue;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn:hover {
  background-color: darkblue;
}
</style>
