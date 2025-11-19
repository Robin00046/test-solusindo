<!-- ConfirmDelete.vue -->
<script setup>
import Modal from "@/Components/ConfirmationModal.vue";

const emit = defineEmits(["confirm", "cancel"]);

defineProps({
    show: Boolean,
    title: {
        type: String,
        default: "Konfirmasi",
    },
    message: {
        type: String,
        default: "Yakin ingin menghapus data ini?",
    },
});
</script>

<template>
    <Modal :show="show" @close="emit('cancel')">
        <template #title>
            {{ title }}
        </template>

        <template #content>
            {{ message }}
        </template>

        <template #footer>
            <button
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded mr-2"
                @click="emit('cancel')"
            >
                Batal
            </button>

            <button
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                @click="emit('confirm')"
            >
                Hapus
            </button>
        </template>
    </Modal>
</template>
