import Tasks from '@/components/tasks/Tasks.vue';
import { useTaskStore } from '@/stores/TaskStore';
import { createTestingPinia } from '@pinia/testing';
import { mount } from '@vue/test-utils';
import { beforeEach, describe, expect, it, vi } from 'vitest';
import { nextTick } from 'vue';

const pinia = createTestingPinia({
    createSpy: vi.fn,
    stubActions: true,
});

describe('components/Tasks.vue', () => {
    let wrapper;
    const taskStore = useTaskStore();
    beforeEach(() => {
        wrapper = mount(Tasks, {
            global: {
                plugins: [pinia],
                stubs: {
                    Teleport: true,
                },
            },
            props: {
                projectDeleted: null,
            },
        });

        taskStore.$patch({
            tasks: [{ id: 1, name: 'New Task', priority: 'High', project_id: 1 }],
        });
    });

    it('can see all tasks', async () => {
        expect(wrapper.get('[data-task] span').text()).toContain('New Task');
    });

    it('can show modal for creating task', async () => {
        expect(wrapper.find('[data-add-task]').exists()).toBe(true);
        wrapper.find('[data-add-task]').trigger('click');
        await nextTick();
        expect(wrapper.find('[data-task-modal]').exists()).toBe(true);
        expect(wrapper.find('[data-task-modal] form').isVisible()).toBe(true);
    });

    it('has edit task button', async () => {
        expect(wrapper.find('div.actions button.edit').exists()).toBe(true);
    });

    it('can delete task', async () => {
        expect(wrapper.find('div.actions button.delete').exists()).toBe(true);
        wrapper.find('div.actions button.delete').trigger('click');
        expect(taskStore.deleteTask).toHaveBeenCalled();
        setTimeout(() => {
            expect(taskStore.tasks).toHaveLength(0);
        }, 1000);
    });

    it('can drag n drop task to re-order priority', async () => {
        const initialTasks = [
            { id: 1, name: 'New Task 1', priority: 'High', project_id: 1 },
            { id: 2, name: 'New Task 2', priority: 'High', project_id: 1 },
            { id: 3, name: 'New Task 3', priority: 'Medium', project_id: 1 },
            { id: 4, name: 'New Task 4', priority: 'Low', project_id: 1 },
            { id: 5, name: 'New Task 5', priority: 'Backlog', project_id: 1 },
        ];
        taskStore.$patch({
            tasks: initialTasks,
        });
        expect(taskStore.tasks).toHaveLength(5);
        wrapper.findComponent({ name: 'draggable' }).vm.$emit('change', {
            moved: {
                element: initialTasks[4],
                oldIndex: 4,
                newIndex: 0,
            },
        });
        setTimeout(() => {
            expect(taskStore.tasks[0].name).toBe('New Task 5');
            expect(taskStore.tasks[0].priority).toBe('Urgent');
        }, 1000);
    });
});
