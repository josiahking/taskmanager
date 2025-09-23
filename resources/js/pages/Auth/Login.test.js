import { mount } from '@vue/test-utils';
import { describe, expect, it, beforeEach } from 'vitest';
import Login from './Login.vue';

describe('Login.vue', () => {
    let wrapper;
    beforeEach(() => {
        wrapper = mount(Login);
    });
    
    it('renders login form fields', () => {
        // Check if basic labels are there
        expect(wrapper.text()).toContain('Email');
        expect(wrapper.text()).toContain('Password');
        expect(wrapper.text()).toContain('Log in');
    });

    it('binds email input correctly', async () => {
        const emailInput = wrapper.find('input[type="email"]');
        await emailInput.setValue('test@example.com');
        // Check reactive form model updated
        expect(wrapper.vm.form.email).toBe('test@example.com');
    });

    it('disables button when processing', async () => {
        wrapper.vm.form.processing = true;
        setTimeout(() => {
            const button = wrapper.find('button[type="submit"]');
            expect(button.attributes('disabled')).toBeDefined();
        }, 300);
    });
});
