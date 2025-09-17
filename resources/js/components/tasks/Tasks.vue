<script setup>
import { useTaskStore } from '@/stores/TaskStore';
import { Bars3Icon, InboxIcon } from '@heroicons/vue/24/outline';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { nextTick, onMounted, ref, watch } from 'vue';
import draggable from 'vuedraggable';
import TasksCreate from './TasksCreate.vue';
import TasksEdit from './TasksEdit.vue';

// define
const taskStore = useTaskStore();
const emit = defineEmits(['update:showAllTasks']);
const showModal = ref(false);
const editingTask = ref(null);
const isEmptyTaskList = ref(false);
const taskList = ref(null);

// props
const props = defineProps({
    showAllTasks: { type: Boolean, default: true },
    tasksToShow: Number,
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
function deleteTask(index){
    taskStore.deleteTask(index);
    checkTaskList();
}
async function checkTaskList(){
    await nextTick();
    isEmptyTaskList.value = taskList.value?.children[0].children?.length === 0;
}
// watch
watch(() => props.tasksToShow, async () => {
    checkTaskList();
});

// onMounted
onMounted(checkTaskList)
</script>

<template>
    <div class="group flex items-center justify-between">
        <h1 class="mb-4 text-xl font-bold">Tasks</h1>
        <div v-if="taskStore.tasks.length > 0">
            <button v-show="!props.showAllTasks" data-show-all @click="showAll"
                class="rounded px-3 py-1 text-sm text-white" style="background-color: #1b478f;">
                Show All
            </button>
        </div>
    </div>
    <div class="tasks items-center space-y-2" ref="taskList" >
        <draggable v-model="taskStore.tasks" data-tasks-list item-key="id" handle=".drag-icon"
            @change="taskStore.updatePriorities">
            <template #item="{ element, index }">
                <div v-if="shouldShow(element)"
                    class="group flex items-center justify-between rounded-lg bg-white px-4 py-3 shadow-sm transition hover:bg-gray-50">
                    <div class="flex w-full items-center gap-3" data-task>
                        <Bars3Icon class="drag-icon h-5 w-5 cursor-move text-gray-400" />

                        <div class="flex w-full flex-col">
                            <span class="truncate text-sm font-medium text-gray-800" :title="element.name">
                                {{ element.name }}
                            </span>
                            <span class="text-xs font-semibold" :class="{
                                    'text-red-600': element.priority === 'Urgent',
                                    'text-orange-500': element.priority === 'High',
                                    'text-yellow-500': element.priority === 'Medium',
                                    'text-lime-500': element.priority === 'Low',
                                    'text-gray-500': element.priority === 'Backlog',
                                }">
                                {{ element.priority }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 opacity-0 transition-opacity group-hover:opacity-100 actions">
                        <button @click="editTask(index)" aria-label="Edit Task" class="edit">
                            <PencilSquareIcon class="h-5 w-5 text-blue-500 hover:text-blue-700" />
                        </button>
                        <button @click="deleteTask(index)" aria-label="Delete Task" class="delete">
                            <TrashIcon class="h-5 w-5 text-red-500 hover:text-red-700" />
                        </button>
                    </div>
                </div>
            </template>
        </draggable>
        <div v-if="isEmptyTaskList" class="flex items-center place-items-center justify-center h-40 text-gray-400">
            <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                <InboxIcon class="h-20 w-20 mb-4" />
                <span class="ml-2 text-sm">{{ props.tasksToShow != null ? "No tasks available for the project" : "No task available" }}</span>
            </div>
        </div>
    </div>
    <TasksCreate @taskCreated="checkTaskList" />
    <TasksEdit :showModal="showModal" :editingTask="editingTask" @closeModal="showModal = false" />
</template>
