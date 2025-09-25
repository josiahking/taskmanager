<script setup>
import Modal from './TasksModal.vue';
import { useTaskStore } from '@/stores/TaskStore';
import { ref } from 'vue';
import { PRIORITY_LEVELS } from '@/utils/Constants';
import { useProjectStore } from '@/stores/ProjectStore';
import { useToast } from 'vue-toastification';

// define
const taskStore = useTaskStore();
const projectStore = useProjectStore();
const emit = defineEmits(['taskCreated']);
const toast = useToast();

// data
const showModal = ref(false);
const taskPriority = ref('Low');
const taskProjectId = ref(null);
const taskName = ref('');

// methods
function addTask() {
    showModal.value = true;
}
function resetForm() {
    taskName.value = '';
    taskPriority.value = 'Low';
    taskProjectId.value = null;
}
function saveTask() {
    if(taskName.value == ""){
        toast.error("Task name is required!");
        return;
    }
    const task = {
        name: taskName.value,
        priority: taskPriority.value,
        project_id: taskProjectId.value,
    };
    taskStore.saveTask(task);
    setTimeout(resetForm, 100);
    showModal.value = false;
    emit('taskCreated');
}

</script>

<template>
    <div class="my-6">
        <button data-add-task @click="addTask" class="rounded bg-gray-900 px-4 py-2 text-sm text-white hover:bg-blue-600 "> + Add Task</button>
    </div>

    <Teleport to="body">
        <Transition
            enter-from-class="opacity-0"
            enter-active-class="transition-opacity duration-300 ease-in-out"
            leave-from-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in-out"
        >
            <Modal :show="showModal" @close-modal="showModal = false" data-task-modal>
                <template #header> Add New Task </template>
                <form @submit.prevent id="add-task-form" class="mx-auto max-w-md space-y-6 rounded bg-white p-6 shadow-md">

                    <div class="flex flex-col">
                        <label for="task" class="mb-2 text-sm font-medium text-gray-700">Task</label>
                        <input
                            type="text"
                            id="task"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter task"
                            v-model="taskName"
                            required
                        />
                    </div>

                    <div class="flex flex-col">
                        <label for="priority" class="mb-2 text-sm font-medium text-gray-700">Priority</label>
                        <select
                            id="priority"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            v-model="taskPriority"
                        >
                            <option :value="priority" v-for="(priority, idx) in PRIORITY_LEVELS" :key="idx">{{ priority }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label for="project" class="mb-2 text-sm font-medium text-gray-700">Project</label>
                        <select
                            id="project"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            v-model="taskProjectId"
                        >
                            <option v-for="project in projectStore.projects" :key="project.id" :value="project.id">{{ project.name }}</option>
                        </select>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full rounded bg-green-600 px-4 py-2 text-white transition-colors hover:bg-blue-700"
                            @click="saveTask"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </Modal>
        </Transition>
    </Teleport>
</template>
