import { mount } from '@vue/test-utils';
import { describe, expect, it, beforeEach } from 'vitest';
import Register from './Register.vue';

describe('Register.vue', () => {
    let wrapper;
    
    beforeEach(() => {
        wrapper = mount(Register);
    });

    it('renders register form fields', () => {
        expect(wrapper.text()).toContain('Name');
        expect(wrapper.text()).toContain('Email');
        expect(wrapper.text()).toContain('Password');
        expect(wrapper.text()).toContain('Confirm Password');
        expect(wrapper.text()).toContain('Register');
    });

    it('binds password confirmation', async () => {
        const confirmInput = wrapper.find('input[id="password_confirmation"]');

        await confirmInput.setValue('secret123');
        expect(wrapper.vm.form.password_confirmation).toBe('secret123');
    });
});
