<script setup>
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { ref } from 'vue';
import {projects} from '@/stores/projectsStore';

const project = ref('');
const editingIndex = ref(null);
const currentlyEditing = ref('');
const emit = defineEmits(['project-to-sort']);

function createProject() {
    projects.push({ name: project.value, id: projects.length + 1 });
    project.value = '';
}

function editProject(index, name) {
    editingIndex.value = index;
    currentlyEditing.value = name;
}

function deleteProject(index) {
    projects.splice(index, 1);
}

function saveProject(index){
    projects[index].name = currentlyEditing.value;
    editingIndex.value = null;
}

function cancelEditProject(){
    editingIndex.value = null;
}
</script>

<template>
    <div>
        <h2 class="mb-4 text-lg font-bold">Projects</h2>
        <ul class="divide-y divide-gray-300">
            <li 
                v-for="(project, idx) in projects" 
                :data-project-id="project.id" 
                :key="idx" 
                class="group flex p-4 transition-colors hover:cursor-pointer hover:bg-gray-300"
                @click="emit('project-to-sort', project.id)"
            >
                <div v-if="editingIndex != idx" class="flex w-full">
                    <span class="text-md font-medium text-gray-800 w-full">
                        {{ project.name }}
                    </span>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <PencilSquareIcon class="h-5 w-5 cursor-pointer edit text-blue-500 hover:text-blue-700" @click="editProject(idx, project.name)" />
                        <TrashIcon class="h-5 w-5 cursor-pointer delete text-red-500 hover:text-red-700" @click="deleteProject(idx)" />
                    </div>
                </div>
                <div v-if="editingIndex == idx" class="flex w-full">
                    <span class="ml-2 text-sm text-blue-500 flex w-full">
                        <input type="text" 
                            v-model="currentlyEditing" 
                            class="w-full border border-gray-300 p-2 bg-white mr-3 rounded text-black focus:border-gray-300 focus:ring-1 focus:ring-gray-200 focus:outline-none" 
                        />
                        <button class="bg-green-600 save rounded p-2 text-white mr-2 hover:cursor-pointer" @click="saveProject(idx)">Save</button>
                        <button class="bg-red-500 cancel rounded p-2 text-white hover:cursor-pointer" @click="cancelEditProject">Cancel</button>
                    </span>
                </div>
            </li>
        </ul>
    </div>
    <form @submit.prevent="createProject">
        <div class="mt-3 flex bg-white">
            <input
                type="text"
                v-model="project"
                class="w-full rounded-l border border-gray-300 p-2 focus:border-gray-300 focus:ring-1 focus:ring-gray-200 focus:outline-none"
            />
            <button class="rounded-r bg-red-400 p-2 text-white">Create</button>
        </div>
    </form>
</template>
