<script setup>
import Project from '@/Components/Project.vue';
import Tasks from '@/components/Tasks.vue';


</script>

<template>
  <div class="flex h-20 items-center bg-gray-200 p-2">
    <h2 class="text-2xl font-bold">Task Manager</h2>
  </div>

  <div class="flex h-screen">
    <aside class="w-1/4 bg-gray-100 p-4">
      <Project></Project>
    </aside>

    <main class="flex-1 p-6">
      <h1 class="mb-4 text-xl font-bold">Tasks</h1>
      <Tasks></Tasks>
      
    </main>
  </div>
</template>
