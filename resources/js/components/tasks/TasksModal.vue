<script setup>
import { XMarkIcon } from '@heroicons/vue/24/outline';

defineProps({
    show: Boolean
})
</script>

<template>
    <div v-if="show" class="modal fixed inset-0 bg-[rgba(0,0,0,0.7)] place-items-center flex">
        <div class="modal-content bg-white rounded p-3 w-[80%] md:w-[500px] max-w-[500px] mx-auto shadow">
            <div class="flex items-center justify-between border-b p-2 mb-3 border-b-gray-200">
                <h3>
                    <slot name="header" />
                </h3>
                <button class="bg-red-500 p-2 rounded" @click="$emit('close-modal')">
                    <XMarkIcon class="w-4 h-4 text-white" />
                </button>
            </div>
            <div class="modal-body p-2">
                <slot />
            </div>
            <div v-if="$slots.footer" class="flex border-t p-2 mb-3 border-t-gray-200">
                <slot name="footer" />
            </div>
        </div>
    </div>
</template>