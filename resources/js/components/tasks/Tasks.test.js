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

    it('can see all tasks', async () => {
        expect(wrapper.get('div span[data-task]').text()).toContain('Task 1');
    });

    it("can show modal to add task", () => {})

    it("can show modal to edit task", () => {})

    it('can delete task', async () => {
        expect(wrapper.find('div.group button.delete').exists()).toBe(true);
        wrapper.find('div.group button.delete').trigger('click');
        expect(wrapper.vm.tasks.length).toBe(0);
    });

    it('can drag n drop task to re-order priority', async () => {});
});
