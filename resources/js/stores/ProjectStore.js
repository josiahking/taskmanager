import { defineStore } from "pinia";
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { useToast } from 'vue-toastification';

const toast = useToast();

export const useProjectStore = defineStore('projects', {
    state() {
        return {
            projects: []
        }
    },
    actions: {
        saveProject(project) {
            const form = useForm(project);
            form.post(route('projects.store'), {
                preserveScroll: true,
                onSuccess: (data) => {
                    this.setProjects(data.props.projects);
                },
                onError: (error) => {
                    for(let err in error){
                        toast.error(error[err]);
                    }
                },
            });
        },
        saveEditProject(index, name) {
            const project = this.projects[index];
            project.name = name;
            const form = useForm(project);
            form.put(route('projects.update'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.projects[index] = project;
                },
                onError: (error) => {
                    for(let err in error){
                        toast.error(error[err]);
                    }
                },
            });
        },
        deleteProject(index) {
            const project = this.projects[index];
            const form = useForm({});
            form.delete(route('projects.destroy', project.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.projects.splice(index, 1);
                },
                onError: (error) => {
                    for(let err in error){
                        toast.error(error[err]);
                    }
                },
            });
        },
        setProjects(data){
            if(typeof data != "object"){
                return;
            }
            this.projects = data;
        }
    },
    persist: true
});