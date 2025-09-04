import { mount } from '@vue/test-utils';
import { describe, expect, it } from 'vitest';

import App from '../Pages/App.vue';
import Project from '@/components/Project.vue';
import Tasks from '@/components/Tasks.vue';

describe('App.vue', () => {
    it('renders the component', () => {
        const wrapper = mount(App);
        expect(wrapper.text()).toContain('Task Manager');
    });

    it('can filter tasks when a project is clicked', async () => {
        const wrapper = mount(App, {
            data() {
                return {
                    projects: [
                        { name: 'Estiquette Shop', id: 1 },
                        { name: 'Alphabets and Numbers', id: 2 },
                    ],
                    tasks: [
                        { id: 1, name: 'Task 1', project_id: 1, priority: 'high' },
                        { id: 2, name: 'Task 2', project_id: 2, priority: 'medium' },
                        { id: 3, name: 'Task 3', project_id: 1, priority: 'low' },
                    ],
                };
            },
        });
        expect(wrapper.findComponent(Project).exists()).toBe(true);
        expect(wrapper.findComponent(Tasks).exists()).toBe(true);
        const projects = wrapper.vm.projects;
        const tasks = wrapper.vm.tasks;
        if (projects.length > 0 && tasks.length > 0) {
            const projectButton = wrapper.find('[data-project-id="1"]');
            await projectButton.trigger('click');
            const tasksList = wrapper.findAll("[data-tasks-list]");
            expect(tasksList.length).toBe(2);
            expect(wrapper.find("[data-show-all]").isVisible()).toBe(true);
        }
    });
});
