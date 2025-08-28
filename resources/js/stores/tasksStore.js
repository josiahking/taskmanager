import { reactive } from "vue";

export let tasks = reactive([
    { id: 1, name: 'Task 1', project_id: 1, priority: 'high' },
    { id: 2, name: 'Task 2', project_id: 1, priority: 'medium' },
    { id: 2, name: 'Task 3', project_id: 1, priority: 'low' },
]);