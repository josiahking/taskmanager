<script setup>
import Project from '@/components/Project.vue';
import Tasks from '@/components/tasks/Tasks.vue';
import { provide, ref } from 'vue';

function handleProjectSorting(projectId){
  projectToShow.value = projectId;
  showAllTasks.value = false;
}

function handleDelete(projectId){
  projectDeleted.value = projectId
}

function handleShowAllTask(){
  projectToShow.value = null;
}
const projectToShow = ref(null);
const showAllTasks = ref(true);
const projectDeleted = ref(null);
provide('activeProject', projectToShow);
</script>

<template>
  <div class="flex h-20 items-center bg-gray-200 p-2">
    <h2 class="text-2xl font-bold">Task Manager</h2>
  </div>

  <div class="flex h-screen">
    <aside class="w-1/4 bg-gray-100 p-4">
      <Project 
        @project-to-sort="handleProjectSorting"
        @delete-project="handleDelete"
      />
    </aside>

    <main class="flex-1 p-6">
      <Tasks 
        :tasksToShow="projectToShow" 
        v-model:showAllTasks="showAllTasks"
        :projectDeleted="projectDeleted"
        @update:showAllTasks="handleShowAllTask"
      />
    </main>
  </div>
</template>
