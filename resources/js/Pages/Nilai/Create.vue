<script setup>
// inport form

import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import CardComponent from "@/Components/CardComponent.vue";
const props = defineProps({
    siswas: Array,
});

const form = useForm({
    siswa_id: "",
    mapel: "",
    nilai: "",
});
</script>

<template>
    <CardComponent title="Create Nilai">
        <!--  -->
        <form
            @submit.prevent="form.post(route('nilais.store'))"
            class="space-y-6"
        >
            <div>
                <label
                    for="siswa_id"
                    class="block mb-2 text-sm font-medium text-gray-900"
                    >Siswa</label
                >
                <select
                    v-model="form.siswa_id"
                    id="siswa_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required
                >
                    <option value="" disabled selected>Select Siswa</option>
                    <option
                        v-for="siswa in props.siswas"
                        :key="siswa.id"
                        :value="siswa.id"
                    >
                        {{ siswa.nama }}
                    </option>
                </select>
            </div>

            <div>
                <label
                    for="mapel"
                    class="block mb-2 text-sm font-medium text-gray-900"
                    >Mata Pelajaran</label
                >
                <input
                    v-model="form.mapel"
                    type="text"
                    id="mapel"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan Mata Pelajaran"
                    required
                />
            </div>

            <div>
                <label
                    for="nilai"
                    class="block mb-2 text-sm font-medium text-gray-900"
                    >Nilai</label
                >
                <input
                    v-model="form.nilai"
                    type="number"
                    id="nilai"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan Nilai"
                    required
                />
            </div>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm"
                :disabled="form.processing"
            >
                Submit
            </button>
        </form>
    </CardComponent>
</template>
