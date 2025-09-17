import Project from '@/components/Project.vue';
import { mount } from '@vue/test-utils';
import { beforeEach } from 'node:test';
import { describe, expect, it, vi, beforeEach } from 'vitest';
import { createTestingPinia } from '@pinia/testing';
import { useProjectStore } from '@/stores/ProjectStore';

const pinia = createTestingPinia({
  createSpy: vi.fn,
  stubActions: true
});

describe('components/Project.vue', () => {
    let wrapper;
    const projectStore = useProjectStore();
    beforeEach(() => {
      wrapper = mount(Project, {
        global: {
          plugins: [pinia],
          provide: {
            activeProject: null,
          }
        },
      });
      projectStore.$patch({
            projects: [{ id: 1, name: 'New Project' }]
        });
    });

    it('adds a new project when form is submitted', async () => {
      const input = wrapper.find('input');
      input.setValue('New Project 2');
      wrapper.find('form').trigger('submit.prevent');
      expect(projectStore.saveProject).toHaveBeenCalled();
      setTimeout(() => {
        const projectNames = wrapper.findAll('ul li span.project').map((span) => span.text());
        expect(projectNames).toContain('New Project 2');
        expect(projectStore.projects).toHaveLength(2);
      }, 1000);
    });

    it('can delete existing project', async () => {
        const deleteButton = wrapper.find('ul li .actions svg.delete');
        await deleteButton.trigger('click');
        expect(projectStore.deleteProject).toHaveBeenCalled();
        setTimeout(() => expect(wrapper.find('ul li').text()).not.toContain('New Project'), 500);
    });

    it('can edit existing project', async () => {
      const editButton = wrapper.find('ul li .actions svg.edit');
      await editButton.trigger('click');

      const editInput = wrapper.find('ul li input');
      await editInput.setValue('Updated Project');
      const saveButton = wrapper.find('ul li button.save');
      await saveButton.trigger('click');

      expect(projectStore.saveEditProject).toHaveBeenCalled();
    });

    it('can cancel a project during editing', async () => {
        const editButton = wrapper.find('ul li svg.edit');
        await editButton.trigger('click');

        const editInput = wrapper.find('ul li input');
        await editInput.setValue('Updated Project');
        const saveButton = wrapper.find('ul li button.cancel');
        await saveButton.trigger('click');

        expect(wrapper.text()).toContain('New Project');
        expect(wrapper.text()).not.toContain('Updated Project');
    });
});
