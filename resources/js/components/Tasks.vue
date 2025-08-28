<script setup>
import Modal from '@/components/Modal.vue';
import { tasks } from '@/stores/tasksStore';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { ref } from 'vue';

function addTask() {
    showModal.value = true;
}

let showModal = ref(false);
</script>

<template>
    <div class="space-y-2">
        <div v-for="t in tasks" :key="t.id" class="group flex justify-between rounded bg-gray-100 p-2 hover:bg-gray-200">
            <div class="flex flex-2 gap-2">
                <span class="w-1/2">
                    {{ t.name }}
                </span>
                <span class="w-1/2" :class="t.priority === 'high' ? 'text-red-500' : t.priority === 'medium' ? 'text-yellow-500' : 'text-green-500'">
                    {{ t.priority }}
                </span>
            </div>
            <div class="flex items-center gap-1 opacity-0 transition-opacity group-hover:opacity-100">
                <button @click="deleteTask(t.id)" class="text-red-500">
                    <PencilSquareIcon class="edit h-4 w-5 cursor-pointer text-blue-500 hover:text-blue-700" />
                </button>
                <button>
                    <TrashIcon class="delete h-4 w-5 cursor-pointer text-red-500 hover:text-red-700" />
                </button>
            </div>
        </div>
    </div>
    <button @click="addTask" class="mt-4 rounded bg-blue-500 px-2 py-1 text-white">Add Task</button>
    <Teleport to="body">
        <Transition
        enter-from-class="opacity-0"
        enter-active-class="transition-opacity duration-300 ease-in-out"
        leave-from-class="opacity-100"
        leave-active-class="transition-opacity duration-200 ease-in-out"
        >
            <Modal :show="showModal" @close-modal="showModal = false">
                <template #header> Add Task </template>
                <form class="mx-auto grid max-w-md gap-6 rounded bg-white p-4 shadow-md">
                    <!-- Full-width Task Input -->
                    <div class="flex flex-col">
                        <label for="task" class="mb-1 text-sm font-medium text-gray-700">Task</label>
                        <input
                            type="text"
                            id="task"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter task"
                        />
                    </div>

                    <!-- Priority Row: Label + Select side-by-side -->
                    <div class="flex items-center gap-4">
                        <label for="priority" class="text-sm font-medium text-gray-700">Priority</label>
                        <select
                            id="priority"
                            class="flex-1 rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700">Add Task</button>
                </form>
            </Modal>
        </Transition>
    </Teleport>
</template>
