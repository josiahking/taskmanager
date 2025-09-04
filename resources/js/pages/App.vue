<script setup>
import Project from '@/components/Project.vue';
import Tasks from '@/components/Tasks.vue';
import { ref } from 'vue';

function handleProjectSorting(projectId){
  projectToShow.value = projectId;
  showAllTasks.value = false;
}

const projectToShow = ref(null);
const showAllTasks = ref(true);
</script>

<template>
  <div class="flex h-20 items-center bg-gray-200 p-2">
    <h2 class="text-2xl font-bold">Task Manager</h2>
  </div>

  <div class="flex h-screen">
    <aside class="w-1/4 bg-gray-100 p-4">
      <Project @project-to-sort="handleProjectSorting"></Project>
    </aside>

    <main class="flex-1 p-6">
      <Tasks :tasksToShow="projectToShow" v-model:showAllTasks="showAllTasks"></Tasks>
    </main>
  </div>
</template>
