import { PRIORITY_LEVELS } from '@/utils/Constants';
import { useForm } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
import { route } from 'ziggy-js';
import { useToast } from 'vue-toastification';

const toast = useToast();

export const useTaskStore = defineStore('tasks', {
    state() {
        return {
            tasks: [],
        };
    },
    actions: {
        saveTask(task) {
            const index = this.tasks.length - 1;
            task.order = index;
            const form = useForm(task);
            form.post(route('tasks.store'), {
                preserveScroll: true,
                onSuccess: (data) => {
                    this.setTasks(data.props.tasks);
                },
                onError: (error) => {
                    for(let err in error){
                        toast.error(error[err]);
                    }
                },
            });
        },
        updatePriorities(event) {
            const { newIndex, element } = event.moved;
            if (element && typeof newIndex === 'number') {
                const bucketSize = Math.ceil(this.tasks.length / PRIORITY_LEVELS.length);
                const lastPriority = PRIORITY_LEVELS.at(-1);
                const bucketIndex = Math.floor(newIndex / bucketSize);
                const newPriority = PRIORITY_LEVELS[bucketIndex] || lastPriority;
                this.tasks[newIndex].priority = newPriority;
                const task = this.tasks[newIndex];
                task.order = newIndex;
                const form = useForm(task);
                form.put(route('tasks.update'), {
                    preserveScroll: true,
                    onError: (error) => {
                        for(let err in error){
                            toast.error(error[err]);
                        }
                    },
                });
            }
        },
        saveEditTask(index, task) {
                           const form = useForm(task);
            form.put(route('tasks.update'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.tasks[index] = task;
                },
                onError: (error) => {
                    for(let err in error){
                        toast.error(error[err]);
                    }
                },
            });      
            
        },
        task(index) {
            return this.tasks[index];
        },
        deleteTask(index) {
            const task = this.task(index);
            const form = useForm({});
            form.delete(route('tasks.destroy', task.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.tasks.splice(index, 1);
                },
                onError: (error) => {
                    for(let err in error){
                        toast.error(error[err]);
                    }
                },
            });
        },
        unlinkProject(projectId) {
            const tasksToUnlink = [];
            this.tasks.forEach((task) => {
                if (task.project_id == projectId) {
                    task.project_id = null;
                    tasksToUnlink.push(task.id);
                }
            });
            if(tasksToUnlink.length > 0){
                const form = useForm({
                    tasks: tasksToUnlink,
                    project_id: projectId
                });
                form.put(route('tasks.unlinkproject'), {
                    preserveScroll: true,
                    onError: (error) => {
                        for(let err in error){
                            toast.error(error[err]);
                        }
                    },
                });
            }
        },
        setTasks(data) {
            if (typeof data != 'object') {
                return;
            }
            console.log(data)
            this.tasks = data;
        },
    },
    persist: true,
    getters: {},
});
