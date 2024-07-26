<template>
    <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surname</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numberplate</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(row, index) in paginatedRows" :key="index">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ row.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ row.surname }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ row.numberplate }}</td>
            </tr>
          </tbody>
        </table>
  
        <!-- Pagination -->
        <div class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 disabled:opacity-50"
          >
            &laquo; Previous
          </button>
          <span class="text-sm text-gray-700">
            Page {{ currentPage }} of {{ totalPages }}
          </span>
          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 disabled:opacity-50"
          >
            Next &raquo;
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, computed } from 'vue';
  
  export default {
    setup() {
      const rows = ref([
        { name: 'John', surname: 'Doe', numberplate: 'ABC123' },
        { name: 'Jane', surname: 'Doe', numberplate: 'XYZ789' },
        { name: 'Michael', surname: 'Smith', numberplate: 'LMN456' },
        { name: 'Emily', surname: 'Johnson', numberplate: 'GHJ234' },
        { name: 'Chris', surname: 'Lee', numberplate: 'JKL567' },
        { name: 'Patricia', surname: 'Brown', numberplate: 'QWE345' },
        { name: 'Robert', surname: 'Davis', numberplate: 'RTY678' },
        { name: 'Linda', surname: 'Miller', numberplate: 'UIO890' },
        { name: 'James', surname: 'Wilson', numberplate: 'PAS123' },
        { name: 'Barbara', surname: 'Moore', numberplate: 'DFG456' },
      ]);
  
      const currentPage = ref(1);
      const rowsPerPage = 5;
  
      const totalPages = computed(() => Math.ceil(rows.value.length / rowsPerPage));
  
      const paginatedRows = computed(() => {
        const start = (currentPage.value - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        return rows.value.slice(start, end);
      });
  
      const nextPage = () => {
        if (currentPage.value < totalPages.value) {
          currentPage.value++;
        }
      };
  
      const prevPage = () => {
        if (currentPage.value > 1) {
          currentPage.value--;
        }
      };
  
      return {
        rows,
        currentPage,
        totalPages,
        paginatedRows,
        nextPage,
        prevPage,
      };
    },
  };
  </script>
  
  <style>
  /* Add any custom styles here */
  </style>
  