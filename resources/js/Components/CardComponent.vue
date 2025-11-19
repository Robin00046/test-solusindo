<template>
    <AppLayout :title="title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-5">
                        <div
                            v-if="
                                showAlert &&
                                ($page.props.flash?.error ||
                                    $page.props.flash?.success)
                            "
                            :class="[
                                'flex items-start justify-between p-3 rounded mb-3 text-white',
                                $page.props.flash?.error
                                    ? 'bg-red-500'
                                    : 'bg-green-500',
                            ]"
                        >
                            <span>
                                {{
                                    $page.props.flash.error ??
                                    $page.props.flash.success
                                }}
                            </span>

                            <button
                                @click="showAlert = false"
                                class="ml-4 font-bold"
                            >
                                ✕
                            </button>
                        </div>

                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
// use page
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
const $page = usePage();

const showAlert = ref(false);

// otomatis muncul kalau ada error baru
watch(
    () => [$page.props.flash?.success, $page.props.flash?.error],
    ([success, error]) => {
        if (success || error) {
            showAlert.value = true;
        }
    },
    { immediate: true }
);
// props to value nilai
defineProps({
    title: String,
});
</script>
