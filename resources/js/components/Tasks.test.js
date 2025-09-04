import { mount } from '@vue/test-utils';
import { describe, expect, it, beforeEach } from 'vitest';

import Tasks from '@/components/Tasks.vue';

describe('components/Tasks.vue', () => {

    let wrapper;

    beforeEach(() => {
        wrapper = mount(Tasks, {
            global: {
                stubs: {
                    Teleport: true,
                },
            },
        });
        wrapper.vm.tasks.length = 0;
        wrapper.vm.tasks.push({
            name: 'Task 1',
            priority: 'low',
            project_id: null,
            id: 1,
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
        const addTaskBtn = wrapper.get('[data-add-task]');
        expect(addTaskBtn.exists()).toBe(true);
        await addTaskBtn.trigger('click');
        const form = wrapper.find('[data-task-modal] form');
        expect(form.exists()).toBe(true);
        await form.get('input').setValue('Submit my project');
        await form.get('select').setValue('High');
        await form.get('button').trigger('click');

        expect(wrapper.vm.tasks.length).toBe(2);
    });

    it('can see all tasks', async () => {
        expect(wrapper.get('div span[data-task]').text()).toContain('Task 1');
    });

    it('can create new task with project', async () => {
        const addTaskBtn = wrapper.get('[data-add-task]');
        expect(addTaskBtn.exists()).toBe(true);
        await addTaskBtn.trigger('click');
        const form = wrapper.find('[data-task-modal] form');
        expect(form.exists()).toBe(true);
        await form.get('input').setValue('Submit my project');
        await form.get('select#priority').setValue('High');
        await form.get('select#project').setValue('High');
        await form.get('button').trigger('click');

        expect(wrapper.vm.tasks.length).toBe(2);
        expect(wrapper.vm.tasks[1].project_id).not.toBeNull();
    });

    it('can edit task', async () => {
        expect(wrapper.find('div.group button.edit').exists()).toBe(true);
        wrapper.find('div.group button.edit').trigger('click');
        const form = wrapper.find('[data-task-modal] form');
        expect(wrapper.vm.showModal).toBe(true);
        setTimeout(async () => {
            expect(form.exists()).toBe(true);
            expect(form.find('button').text()).toBe('Update');
            await form.get('input').setValue('Submit my project');
            await form.get('select#priority').setValue('High');
            await form.get('select#project').setValue('2');
            await form.get('button').trigger('click');
            expect(wrapper.vm.tasks.length).toBe(1);
            expect(wrapper.vm.tasks[0].project_id).toBe(2);
        }, 1000);
    });

    it('can delete task', async () => {
        expect(wrapper.find('div.group button.delete').exists()).toBe(true);
        wrapper.find('div.group button.delete').trigger('click');
        expect(wrapper.vm.tasks.length).toBe(0);
    });

    it('can drag n drop task to re-order priority', async () => {});
});
