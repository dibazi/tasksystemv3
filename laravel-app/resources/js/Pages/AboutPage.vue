<template>
    <div class="about-page">
      <h1>About Page</h1>
      <button @click="goToHomePage" class="btn btn-primary">Go to Home Page</button>
    </div>
  </template>
  
  <script setup>
  import { useRouter } from 'vue-router';
  
  const router = useRouter();
  
  const goToHomePage = () => {
    router.push({ name: 'home' });
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
  