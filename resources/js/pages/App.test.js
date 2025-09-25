import { useProjectStore } from '@/stores/ProjectStore';
import { useTaskStore } from '@/stores/TaskStore';
import { createTestingPinia } from '@pinia/testing';
import { mount } from '@vue/test-utils';
import { beforeEach, describe, expect, it, vi } from 'vitest';
import App from './App.vue';
import Project from '@/components/Project.vue';
import Tasks from '@/components/tasks/Tasks.vue';

const pinia = createTestingPinia({
    createSpy: vi.fn,
    stubActions: true,
});

describe('App.vue', () => {
    let wrapper;
    const taskStore = useTaskStore();
    const projectStore = useProjectStore();

    beforeEach(() => {
        wrapper = mount(App, {
            global: {
                plugins: [pinia],
            },
        });
        taskStore.$patch({
            tasks: [
                { id: 1, name: 'New Task 1', priority: 'High', project_id: 1 },
                { id: 2, name: 'New Task 2', priority: 'High', project_id: 1 },
            ],
        });
        projectStore.$patch({
            projects: [{ id: 1, name: 'New Project' }],
        });
    });

    it('renders the component', () => {
        expect(wrapper.text()).toContain('Task Manager');
    });

    it('can filter tasks when a project is clicked', async () => {

        expect(wrapper.findComponent(Project).exists()).toBe(true);
        expect(wrapper.findComponent(Tasks).exists()).toBe(true);
        const projectButton = wrapper.find('ul li span.project');
        await projectButton.trigger('click');
        const tasksList = wrapper.findAll("[data-tasks-list]");
        expect(tasksList.length).toBe(1);
        expect(wrapper.find("[data-show-all]").isVisible()).toBe(true);
    });

    it("can delete project and unlink from tasks", async () => {
        const projectDeleteButton = wrapper.find('[data-project-id="1"] .delete');
        await projectDeleteButton.trigger('click');
        setTimeout(() => {
            const tasksList = wrapper.findAll("[data-tasks-list]");
            const projectIsLinkedToTask = tasksList.some(task => task.project_id == 1);
            expect(projectIsLinkedToTask).toBe(false);
        }, 1000);
    });
});
