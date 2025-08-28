import { mount } from '@vue/test-utils';
import { describe, it, expect } from 'vitest';

import Project from '@/components/Project.vue';


function setupProject(wrapper, name = 'Test Project') {
  const input = wrapper.find('input');
  return input.setValue(name).then(() => {
    return wrapper.find('form').trigger('submit.prevent');
  });
}

describe('components/Project.vue', () => {
  it('adds a new project when form is submitted', async () => {
    const wrapper = mount(Project);
    await setupProject(wrapper, 'New Project');
    wrapper.vm.projects.length = 1;
    expect(wrapper.vm.projects.length).toBe(1);
    const projectNames = wrapper.findAll('ul li span').map(span => span.text());
    expect(projectNames).toContain('New Project');
    expect(wrapper.vm.project).toBe('');
  });
  
  it("can delete existing project", async () => {
    const wrapper = mount(Project);
    wrapper.vm.projects.length = 0;
    expect(wrapper.vm.projects).toEqual([]);
    await setupProject(wrapper, 'Project To Delete');
    const deleteButton = wrapper.find('ul li svg.delete');
    await deleteButton.trigger('click');

    expect(wrapper.text()).not.toContain('Project To Delete');
  });

  it("can edit existing project", async () => {
    const wrapper = mount(Project);
    wrapper.vm.projects.length = 0;
    await setupProject(wrapper, 'Edit Project');

    const editButton = wrapper.find('ul li svg.edit');
    await editButton.trigger('click');

    const editInput = wrapper.find('ul li input');
    await editInput.setValue('Updated Project');
    const saveButton = wrapper.find('ul li button.save');
    await saveButton.trigger('click');

    expect(wrapper.text()).toContain('Updated Project');
    expect(wrapper.text()).not.toContain('Edit Project');
  });

  it("can cancel a project during editing", async () => {
    const wrapper = mount(Project);
    wrapper.vm.projects.length = 0;
    await setupProject(wrapper, 'Edit Project');

    const editButton = wrapper.find('ul li svg.edit');
    await editButton.trigger('click');

    const editInput = wrapper.find('ul li input');
    await editInput.setValue('Updated Project');
    const saveButton = wrapper.find('ul li button.cancel');
    await saveButton.trigger('click');

    expect(wrapper.text()).toContain('Edit Project');
    expect(wrapper.text()).not.toContain('Updated Project');
  });

});