import { mount } from '@vue/test-utils';
import { describe, expect, it } from 'vitest';

import App from '../Pages/App.vue';

describe('App.vue', () => {
    it('renders the component', () => {
        const wrapper = mount(App, {
            props: { projects: [] }, // Pass empty projects list
        });
        expect(wrapper.text()).toContain('Task Manager');
    });

    // it('filters tasks when a project is clicked', async () => {
    //     const wrapper = mount(App, {
    //         data() {
    //             return {
    //                 projects: [
    //                     { id: 1, name: 'Project A' },
    //                     { id: 2, name: 'Project B' },
    //                 ],
    //                 tasks: [
    //                     { id: 101, name: 'Task 1', projectId: 1 },
    //                     { id: 102, name: 'Task 2', projectId: 2 },
    //                 ],
    //                 filteredTasks: [],
    //             };
    //         },
    //     });

    //     // Simulate clicking Project B
    //     const projectButton = wrapper.find('[data-project-id="2"]');
    //     await projectButton.trigger('click');

    //     // Assert filtered tasks only include Project B's tasks
    //     expect(wrapper.vm.filteredTasks).toEqual([{ id: 102, name: 'Task 2', projectId: 2 }]);
    // });
});
