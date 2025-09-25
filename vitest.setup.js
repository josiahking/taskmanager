import { config } from '@vue/test-utils';
import { vi } from 'vitest';

vi.mock('@inertiajs/vue3', () => ({
    Head: { template: '<div><slot /></div>' },
    Link: { template: '<a><slot /></a>' },
    useForm: () => ({
        data: {},
        errors: {},
        processing: false,
        post: vi.fn(),
        reset: vi.fn(),
    }),
    usePage: () => ({
        props: {
            auth: { user: { id: 1, name: 'Test User', email: 'test@example.com' } },
        },
    }),
}));

config.global.mocks = {
    route: (name) => ({
        toString: () => `/${name}`,
        current: (check) => check === name, // mimic Ziggy's route().current()
    }),
    $page: {
        props: {
            auth: { user: { id: 1, name: 'Test User', email: 'test@example.com' } },
        },
    },
};
