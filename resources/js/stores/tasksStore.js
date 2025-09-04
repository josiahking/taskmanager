import { reactive } from "vue";

export let tasks = reactive([
    { id: 1, name: 'Task 1', project_id: 1, priority: 'high' },
    { id: 2, name: 'Task 2', project_id: 2, priority: 'medium' },
    { id: 3, name: 'Task 3', project_id: 1, priority: 'low' },
    { id: 4, name: 'Task 3', project_id: null, priority: 'low' },
]);