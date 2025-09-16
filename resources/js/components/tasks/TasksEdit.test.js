import { useTaskStore } from '@/stores/TaskStore';
import { createTestingPinia } from '@pinia/testing';
import { mount } from '@vue/test-utils';
import { beforeEach, describe, expect, it, vi } from 'vitest';
import { setActivePinia } from 'pinia';
import TasksEdit from '@/components/tasks/TasksEdit.vue';

const pinia = createTestingPinia({
  createSpy: vi.fn,
  stubActions: true
});
setActivePinia(pinia);

describe('tasks/TasksEdit.vue', () => {
    let wrapper;
    const taskStore = useTaskStore();
    beforeEach(() => {
        wrapper = mount(TasksEdit, {
            global: {
                plugins: [pinia],
                stubs: {
                    Teleport: true,
                },
            },
            props: {
                showModal: true,
                editingTask: 0
            }
        });
        
        taskStore.$patch({
            tasks: [{ id: 1, name: 'New Task', priority: 'High', project_id: 1 }]
        });
        wrapper.vm.showModal = true;
    });

    it('can show modal with form', async () => {
        expect(wrapper.find('[data-task-edit-modal]').exists()).toBe(true);
        expect(wrapper.find('[data-task-edit-modal]').isVisible()).toBe(true);
        expect(wrapper.find('[data-task-edit-modal] form').isVisible()).toBe(true);
    });

    it('can edit task', async () => {
        const form = wrapper.find('[data-task-edit-modal] form');
        expect(wrapper.vm.showModal).toBe(true);
        expect(wrapper.vm.editingTask).toBe(0);
        expect(form.exists()).toBe(true);
        expect(form.find('button').text()).toBe('Save');
        await form.get('input').setValue('Call with client');
        await form.get('select#priority').setValue('High');
        await form.get('select#project').setValue('2');
        await form.get('button').trigger('click');
        expect(taskStore.saveEditTask).toHaveBeenCalled();
        setTimeout(() => {
            expect(taskStore.tasks[0].name).toBe('Call with client');
        }, 500);
    });
});
