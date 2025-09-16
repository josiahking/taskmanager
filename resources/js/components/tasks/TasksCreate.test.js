import { useTaskStore } from '@/stores/TaskStore';
import { createTestingPinia } from '@pinia/testing';
import { mount } from '@vue/test-utils';
import { beforeEach, describe, expect, it, vi } from 'vitest';

import TasksCreate from '@/components/tasks/TasksCreate.vue';
const pinia = createTestingPinia({
  createSpy: vi.fn,
  stubActions: true
});

describe('tasks/TasksCreate.vue', () => {
    let wrapper;

    beforeEach(() => {
        wrapper = mount(TasksCreate, {
            global: {
                plugins: [pinia],
                stubs: {
                    Teleport: true,
                },
                provide: {
                    priorityLevels: ['Low', 'Medium', 'High'],
                },
            },
        });
    });

    it('can show modal with form', async () => {
        const addTaskBtn = wrapper.get('[data-add-task]');
        expect(addTaskBtn.exists()).toBe(true);
        await addTaskBtn.trigger('click');
        expect(wrapper.vm.showModal).toBe(true);
        expect(wrapper.find('[data-task-modal]').exists()).toBe(true);
        expect(wrapper.find('[data-task-modal]').isVisible()).toBe(true);
        expect(wrapper.find('[data-task-modal] form').isVisible()).toBe(true);
    });

    it('can create new task without project', async () => {
        const taskStore = useTaskStore();
        const addTaskBtn = wrapper.get('[data-add-task]');
        expect(addTaskBtn.exists()).toBe(true);
        await addTaskBtn.trigger('click');
        const form = wrapper.find('[data-task-modal] form');
        expect(form.exists()).toBe(true);
        await form.get('input').setValue('Submit my project');
        await form.get('select').setValue('High');
        await form.get('button').trigger('click');

        expect(taskStore.saveTask).toHaveBeenCalled();
    });

    it('can create new task with project', async () => {
        const taskStore = useTaskStore();
        const addTaskBtn = wrapper.get('[data-add-task]');
        expect(addTaskBtn.exists()).toBe(true);
        await addTaskBtn.trigger('click');
        const form = wrapper.find('[data-task-modal] form');
        expect(form.exists()).toBe(true);
        await form.get('input').setValue('Submit my project');
        await form.get('select#priority').setValue('High');
        await form.get('select#project').setValue('Infinity Corp');
        await form.get('button').trigger('click');
        expect(taskStore.saveTask).toHaveBeenCalled();
    });
});
