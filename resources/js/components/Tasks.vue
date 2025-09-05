<script setup>
import Modal from '@/components/Modal.vue';
import { projects } from '@/stores/projectsStore';
import { tasks } from '@/stores/tasksStore';
import { Bars3Icon } from '@heroicons/vue/24/outline';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { ref, watch } from 'vue';
import draggable from 'vuedraggable';

const emit = defineEmits(['update:showAllTasks', 'update:tasks']);

function addTask() {
    showModal.value = true;
    editingTask.value = null;
    resetForm();
}
function saveTask() {
    tasks.push({
        name: taskName.value,
        priority: taskPriority.value,
        project_id: taskProjectId.value,
    });
    setTimeout(resetForm, 100);
    showModal.value = false;
    emit('update:tasks', tasks);
}
function resetForm() {
    taskName.value = '';
    taskPriority.value = 'Low';
    taskProjectId.value = null;
}
function editTask(index) {
    showModal.value = true;
    const task = tasks[index];
    editingTask.value = index;
    taskName.value = task.name;
    taskPriority.value = task.priority;
    taskProjectId.value = task.project_id;
}
function deleteTask(index) {
    tasks.splice(index, 1);
}

function showAll() {
    emit('update:showAllTasks', true);
}

const showModal = ref(false);
const taskName = ref('');
const taskPriority = ref('Low');
const taskProjectId = ref(null);
const editingTask = ref(null);

const props = defineProps({
    showAllTasks: { type: Boolean, default: true },
    tasksToShow: Number,
    projectDeleted: Number,
    tasks: {
        type: Array,
        default: tasks,
    }
});
const priorityLevels = ['urgent', 'high', 'medium', 'low', 'backlog'];

watch(props.projectDeleted, (newVal) => {
    tasks.forEach((task) => {
        if (task.project_id == newVal) {
            task.project_id = null;
        }
    });
});
const localTasks = ref([...props.tasks]);
function shouldShow(task) {
  return props.tasksToShow == null || task.project_id === props.tasksToShow;
}
watch(localTasks, () => {
    updatePriorities();
});
function updatePriorities() {
    const bucketSize = Math.ceil(localTasks.value.length / priorityLevels.length);

    localTasks.value.forEach((task, index) => {
    const bucketIndex = Math.floor(index / bucketSize);
    task.priority = priorityLevels[bucketIndex] || 'low';
    });
    emit('update:tasks', localTasks.value);
}
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
        <draggable
            v-model="localTasks"
            data-tasks-list
            item-key="id"
            handle=".drag-icon"
        >
            <template #item="{element, index}">
                <div 
                    v-if="shouldShow(element)"
                    class="group flex justify-between rounded bg-gray-100 p-2 hover:bg-gray-200"
                >
                    <div class="flex flex-2 items-center gap-2">
                        <Bars3Icon class="drag-icon h-4 w-4 cursor-move text-gray-400" />
                        <span class="w-1/2" data-task="{{ element.name }}">
                            {{ element.name }}
                        </span>
                        <span class="w-1/2" :class="element.priority === 'high' ? 'text-red-500' : element.priority === 'medium' ? 'text-yellow-500' : 'text-green-500'">
                            {{ element.priority }}
                        </span>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 transition-opacity group-hover:opacity-100">
                        <button @click="editTask(index)" class="edit text-red-500">
                            <PencilSquareIcon class="edit h-4 w-5 cursor-pointer text-blue-500 hover:text-blue-700" />
                        </button>
                        <button class="delete" @click="deleteTask(index)">
                            <TrashIcon class="delete h-4 w-5 cursor-pointer text-red-500 hover:text-red-700" />
                        </button>
                    </div>
                </div>
            </template>
        </draggable>
    </div>
    <button data-add-task @click="addTask" class="mt-4 rounded bg-blue-500 px-2 py-1 text-white">Add Task</button>
    <Teleport to="body">
        <Transition
            enter-from-class="opacity-0"
            enter-active-class="transition-opacity duration-300 ease-in-out"
            leave-from-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in-out"
        >
            <Modal :show="showModal" @close-modal="showModal = false" data-task-modal>
                <template #header> {{ !editingTask ? 'Add New Task' : 'Edit Task' }} </template>
                <form @submit.prevent id="add-task-form" class="mx-auto grid max-w-md gap-6 rounded bg-white p-4 shadow-md">
                    <div class="flex flex-col">
                        <label for="task" class="mb-1 text-sm font-medium text-gray-700">Task</label>
                        <input
                            type="text"
                            id="task"
                            class="w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter task"
                            v-model="taskName"
                            required
                        />
                    </div>

                    <div class="flex items-center gap-4">
                        <label for="priority" class="text-sm font-medium text-gray-700">Priority</label>
                        <select
                            id="priority"
                            class="flex-1 rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            v-model="taskPriority"
                        >
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <label for="project" class="text-sm font-medium text-gray-700">Project</label>
                        <select
                            id="project"
                            class="flex-1 rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            v-model="taskProjectId"
                        >
                            <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
                        </select>
                    </div>

                    <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white transition-colors hover:bg-blue-700" @click="saveTask">
                        {{ editingTask ? 'Update' : 'Save' }}
                    </button>
                </form>
            </Modal>
        </Transition>
    </Teleport>
</template>
