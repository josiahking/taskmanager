<script setup>
import Project from '@/components/Project.vue';
import Tasks from '@/components/tasks/Tasks.vue';
import { provide, computed, ref } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import { useTaskStore } from '@/stores/TaskStore';
import { useProjectStore } from '@/stores/ProjectStore';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// define
const projectToShow = ref(null);
const showAllTasks = ref(true);
const page = usePage();
const taskStore = useTaskStore();
const projectStore = useProjectStore();

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
const tasks = computed(() => page.props?.tasks || []);
const projects = computed(() => page.props?.projects || []);
taskStore.setTasks(tasks.value);
projectStore.setProjects(projects.value);

</script>

<template>

  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Task Manager
      </h2>
    </template>

    <div class="flex h-screen">
      <aside class="w-1/4 bg-gray-100 p-4">
        <Project @project-to-sort="handleProjectSorting" />
      </aside>

      <main class="flex-1 p-6">
        <Tasks :tasksToShow="projectToShow" v-model:showAllTasks="showAllTasks"
          @update:showAllTasks="handleShowAllTask" />
      </main>
    </div>
  </AuthenticatedLayout>
</template>