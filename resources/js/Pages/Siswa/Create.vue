<script setup>
import CardComponent from "@/Components/CardComponent.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    nama: "",
    kelas: "",
});

const props = defineProps({
    errors: Object,
});
</script>

<template>
    <CardComponent title="Create Siswa">
        <form
            action=""
            @submit.prevent="form.post(route('siswas.store'))"
            class="space-y-6"
        >
            <div>
                <label
                    for="nama"
                    class="block mb-2 text-sm font-medium text-gray-900"
                    >Nama</label
                >
                <input
                    v-model="form.nama"
                    type="text"
                    id="nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan Nama"
                    required
                />
                <div v-if="props.errors.nama" class="text-red-600 text-sm mt-1">{{ props.errors.nama }}</div>
            </div>

            <div>
                <label
                    for="kelas"
                    class="block mb-2 text-sm font-medium text-gray-900"
                    >Kelas</label
                >
                <input
                    v-model="form.kelas"
                    type="text"
                    id="kelas"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan Kelas"
                    required
                />
                <div v-if="props.errors.kelas" class="text-red-600 text-sm mt-1">{{ props.errors.kelas }}</div>
            </div>

            <button
                type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
            >
                Submit
            </button>
        </form>
    </CardComponent>
</template>
