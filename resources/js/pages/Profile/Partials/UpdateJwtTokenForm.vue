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
const user = usePage().props.auth.user;

console.log(user)

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
    })
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
                <PrimaryButton :disabled="loading">Generate Token</PrimaryButton>

                <p v-if="success" class="text-sm text-green-600 mt-2">
                    Token generated successfully.
                </p>
            </div>

            <div v-if="token" class="mt-4">
                <InputLabel for="token" value="Your Token" />
                <TextInput id="token" type="text" class="mt-1 block w-full bg-gray-100" :value="token" readonly />
            </div>
        </form>
    </section>

</template>
