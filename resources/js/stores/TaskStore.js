import { defineStore } from 'pinia';
import { PRIORITY_LEVELS } from '@/utils/Constants';

export const useTaskStore = defineStore('tasks', {
    state() {
        return {
            tasks: [],
        }
    },
    actions: {
        saveTask(task){
            this.tasks.push(task);
        },
        updatePriorities(event) {
            const { newIndex, element } = event.moved;
            if (element && typeof newIndex === 'number') {
                const bucketSize = Math.ceil(this.tasks.length / PRIORITY_LEVELS.length);
                const lastPriority = PRIORITY_LEVELS.at(-1);
                const bucketIndex = Math.floor(newIndex / bucketSize);
                const newPriority = PRIORITY_LEVELS[bucketIndex] || lastPriority;
                this.tasks[newIndex].priority = newPriority;
            }
        },
        saveEditTask(index, task){
            this.tasks[index] = task;
        },
        task(index){
            return this.tasks[index];
        },
        deleteTask(index) {
            this.tasks.splice(index, 1);
        },
        unlinkProject(projectId) {
            this.tasks.forEach(task => {
                if (task.project_id == projectId) {
                    task.project_id = null;
                }
            });
        }
    },
    persist: true,
    getters: {
        
    }
});