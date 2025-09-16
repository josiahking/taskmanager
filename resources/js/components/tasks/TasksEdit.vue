<script setup>
import Modal from '@/components/Modal.vue';
import { useTaskStore } from '@/stores/TaskStore';
import { reactive, watch } from 'vue';
import { PRIORITY_LEVELS } from '@/utils/constants';

// define
const taskStore = useTaskStore();
let task = reactive({});
const emit = defineEmits(['closeModal']);

// props
const props = defineProps({
    editingTask: { type: Number, default: null },
    showModal: Boolean,
    projects: Array,
});

// methods
function resetForm() {
    task = {};
}
function saveTask() {
    taskStore.saveEditTask(task);
    setTimeout(resetForm, 100);
    closeModal();
}
function closeModal() {
    emit('closeModal');
}

// watch
watch(
    () => props.showModal,
    (newVal) => {
        if (newVal) {
            task = taskStore.task(props.editingTask);
        }
    },
);

</script>

<template>
    <Teleport to="body">
        <Transition
            enter-from-class="opacity-0"
            enter-active-class="transition-opacity duration-300 ease-in-out"
            leave-from-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in-out"
        >
            <Modal :show="showModal" @close-modal="closeModal()" data-task-edit-modal>
                <template #header> Edit Task </template>
                <form @submit.prevent id="edit-task-form" class="mx-auto max-w-md space-y-6 rounded bg-white p-6 shadow-md">
                    <div class="flex flex-col">
                        <label for="task" class="mb-2 text-sm font-medium text-gray-700">Task</label>
                        <input
                            type="text"
                            id="task"
                            class="rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter task"
                            v-model="task.name"
                            required
                        />
                    </div>

                    <div class="flex flex-col">
                        <label for="priority" class="mb-2 text-sm font-medium text-gray-700">Priority</label>
                        <select
                            id="priority"
                            class="rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            v-model="task.priority"
                        >
                            <option :value="priority" v-for="(priority, idx) in PRIORITY_LEVELS" :key="idx">{{ priority }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label for="project" class="mb-2 text-sm font-medium text-gray-700">Project</label>
                        <select
                            id="project"
                            class="rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            v-model="task.project_id"
                        >
                            <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
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
