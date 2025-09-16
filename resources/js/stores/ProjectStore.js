import { defineStore } from "pinia";

export const useProjectStore =defineStore('projects', {
    state() {
        return {
            projects: []
        }
    },
    actions: {
        saveProject(project) {
            const id = this.projects.length + 1;
            project.id = id;
            this.projects.push(project)
        },
        saveEditProject(index, name) {
            this.projects[index].name = name;
        },
        deleteProject(index) {
            this.projects.splice(index, 1);
        }

    },
    persist: true
});