<script setup>
import { useTaskStore } from '@/stores/TaskStore';
import { Bars3Icon } from '@heroicons/vue/24/outline';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { ref, watch } from 'vue';
import draggable from 'vuedraggable';
import TasksCreate from './TasksCreate.vue';
import TasksEdit from './TasksEdit.vue';

// define
const taskStore = useTaskStore();
const emit = defineEmits(['update:showAllTasks']);
const showModal = ref(false);
const editingTask = ref(null);

// props
const props = defineProps({
    showAllTasks: { type: Boolean, default: true },
    tasksToShow: Number,
    projectDeleted: Number,
});

// methods
function shouldShow(task) {
    return props.tasksToShow == null || task.project_id === props.tasksToShow;
}
function editTask(index) {
    showModal.value = true;
    editingTask.value = index;
}

function showAll() {
    emit('update:showAllTasks', true);
}
// watch
watch(props.projectDeleted, (newVal) => {
    tasks.forEach((task) => {
        if (task.project_id == newVal) {
            task.project_id = null;
        }
    });
});
</script>

<template>
    <div class="group flex items-center justify-between">
        <h1 class="mb-4 text-xl font-bold">Tasks</h1>
        <div>
            <button
                v-show="!props.showAllTasks"
                data-show-all
                @click="showAll"
                class="rounded bg-blue-500 px-3 py-1 text-sm text-white hover:bg-blue-600"
            >
                Show All
            </button>
        </div>
    </div>
    <div class="tasks items-center space-y-2">
        <draggable v-model="taskStore.tasks" data-tasks-list item-key="id" handle=".drag-icon" @change="taskStore.updatePriorities">
            <template #item="{ element, index }">
                <div
                    v-if="shouldShow(element)"
                    class="group flex items-center justify-between rounded-lg bg-white px-4 py-3 shadow-sm transition hover:bg-gray-50"
                >
                    <div class="flex w-full items-center gap-3" data-task>
                        <Bars3Icon class="drag-icon h-5 w-5 cursor-move text-gray-400" />

                        <div class="flex w-full flex-col">
                            <span class="truncate text-sm font-medium text-gray-800" :title="element.name">
                                {{ element.name }}
                            </span>
                            <span
                                class="text-xs font-semibold"
                                :class="{
                                    'text-red-600': element.priority === 'Urgent',
                                    'text-orange-500': element.priority === 'High',
                                    'text-yellow-500': element.priority === 'Medium',
                                    'text-lime-500': element.priority === 'Low',
                                    'text-gray-500': element.priority === 'Backlog',
                                }"
                            >
                                {{ element.priority }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 opacity-0 transition-opacity group-hover:opacity-100 actions">
                        <button @click="editTask(index)" aria-label="Edit Task" class="edit">
                            <PencilSquareIcon class="h-5 w-5 text-blue-500 hover:text-blue-700" />
                        </button>
                        <button @click="taskStore.deleteTask(index)" aria-label="Delete Task" class="delete">
                            <TrashIcon class="h-5 w-5 text-red-500 hover:text-red-700" />
                        </button>
                    </div>
                </div>
            </template>
        </draggable>
    </div>
    <TasksCreate />
    <TasksEdit :showModal="showModal" :editingTask="editingTask" @closeModal="showModal = false" />
</template>
