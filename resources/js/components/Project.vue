<script setup>
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { inject, ref } from 'vue';
import { useProjectStore } from '@/stores/ProjectStore';

// define
const projectStore = useProjectStore();
const project = ref('');
const editingIndex = ref(null);
const currentlyEditing = ref('');
const emit = defineEmits(['project-to-sort','delete-project']);

// methods
function createProject() {
    if(!project.value){
        return;
    }
    projectStore.saveProject({ name: project.value });
    project.value = '';
}

function editProject(index, name) {
    editingIndex.value = index;
    currentlyEditing.value = name;
}

function deleteProject(index, projectId) {
    projectStore.deleteProject(index);
    emit('delete-project', projectId);
}

function saveProject(index){
    projectStore.saveEditProject(index, currentlyEditing.value);
    editingIndex.value = null;
}

function cancelEditProject(){
    editingIndex.value = null;
}

// inject
const activeProject = inject('activeProject');

</script>

<template>
    <div class="max-w-xl mx-auto">
        <h2 class="mb-6 text-lg font-bold">Projects</h2>
        <ul class="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow-sm">
            <li 
                v-for="(project, idx) in projectStore.projects" 
                :data-project-id="project.id" 
                :key="idx" 
                class="group flex items-center justify-between p-4 transition-colors hover:cursor-pointer hover:bg-gray-200"
                :class="{
                    'bg-red-200': project.id === activeProject
                }"
                @click="emit('project-to-sort', project.id)"
            >
                <div v-if="editingIndex != idx" class="flex w-full">
                    <span class="text-md font-medium text-gray-800 w-full">
                        {{ project.name }}
                    </span>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <PencilSquareIcon class="h-5 w-5 cursor-pointer edit text-blue-500 hover:text-blue-700" @click="editProject(idx, project.name)" />
                        <TrashIcon 
                            class="h-5 w-5 cursor-pointer delete text-red-500 hover:text-red-700" 
                            @click="deleteProject(idx,project.id)" 
                        />
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
    <form @submit.prevent="createProject" class="mt-6">
        <div class="mt-3 rounded-lg flex bg-white shadow-sm">
            <input
                type="text"
                v-model="project"
                class="w-full rounded-l border border-gray-300 p-2 focus:border-gray-300 focus:ring-1 focus:ring-gray-200 focus:outline-none"
                placeholder="New project name"
            />
            <button class="rounded-r bg-red-400 p-2 text-white hover:cursor-pointer">Create</button>
        </div>
    </form>
</template>
