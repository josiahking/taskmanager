<script setup>
import Project from '@/components/Project.vue';
import Tasks from '@/components/tasks/Tasks.vue';
import { provide, computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

// define
const projectToShow = ref(null);
const showAllTasks = ref(true);
const page = usePage();

// methods
function handleProjectSorting(projectId) {
  projectToShow.value = projectId;
  showAllTasks.value = false;
}

function handleShowAllTask() {
  projectToShow.value = null;
}

// provide
provide('activeProject', projectToShow);

// computed
const tasks = computed(() => page.props.tasks);
const projects = computed(() => page.props.projects);
console.log(tasks, projects)
</script>

<template>
  <div class="flex h-20 items-center justify-between bg-gray-100 px-6 shadow-sm">
    <div class="flex items-center gap-3">
      
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6h5v2H4v-2h5z" />
      </svg>

      <h2 class="text-2xl font-semibold text-gray-800">Task Manager</h2>
    </div>
  </div>

  <div class="flex h-screen">
    <aside class="w-1/4 bg-gray-100 p-4">
      <Project @project-to-sort="handleProjectSorting" />
    </aside>

    <main class="flex-1 p-6">
      <Tasks :tasksToShow="projectToShow" v-model:showAllTasks="showAllTasks"
        @update:showAllTasks="handleShowAllTask" />
    </main>
  </div>
</template>
