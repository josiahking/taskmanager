<script setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const token = ref('');
const loading = ref(false);
const success = ref(false);
token.value = usePage().props.token;

const generateToken = () => {
    loading.value = true
    success.value = false

    router.post(route('profile.token'), {}, {
        preserveScroll: true,
        onSuccess: (page) => {
            token.value = page.props.token
            success.value = true
        },
        onFinish: () => {
            loading.value = false
        },
    });
}

async function copyToken() {
    if (navigator.clipboard) {
        await navigator.clipboard.writeText(token.value);
    } else {
        console.error('Clipboard API not supported');
    }
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">API Token</h2>
            <p class="mt-1 text-sm text-gray-600">
                Click below to generate a new personal access token.
            </p>
        </header>

        <form @submit.prevent="generateToken" class="mt-6 space-y-6">
            <div>

                <div v-if="token" class="my-4">
                    <div class="flex items-center space-x-2">
                        <TextInput id="token" type="text" class="mt-1 block w-full bg-gray-100 text-gray-800"
                            v-model="token" readonly />
                        <button type="button" @click="copyToken"
                            class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Copy
                        </button>
                    </div>
                </div>

                <PrimaryButton :disabled="loading">Generate Token</PrimaryButton>

                <p v-if="success" class="text-sm text-green-600 mt-2">
                    Token generated successfully.
                </p>
            </div>

        </form>
    </section>

</template>
