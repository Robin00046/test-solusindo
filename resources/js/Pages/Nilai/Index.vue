<script setup>
import CardComponent from "@/Components/CardComponent.vue";
import { router } from "@inertiajs/vue3";
import { defineProps, ref, onMounted, onBeforeUnmount, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

import { Link } from "@inertiajs/vue3";
import ConfirmDelete from "@/Components/ConfirmDelete.vue";

// import ref

const props = defineProps({
    nilais: Array,
    siswas: Array,
});

const form = useForm({
    file: null,
});

const filters = ref({
    siswa: "",
    kelas: "",
    mapel: "",
});

const fileInput = ref(null);

const handleFile = (e) => {
    form.file = e.target.files[0];
};

const importNilai = () => {
    form.post(route("nilai.import"), {
        forceFormData: true, // WAJIB UNTUK FILE UPLOAD
        onSuccess: () => {
            // reset form file
            form.file = null;

            // reset input file
            if (fileInput.value) {
                fileInput.value.value = null;
            }
        },
    });
};

// ambil kelas dari group by kelas
const kelasOptions = computed(() => {
    const kelasSet = new Set();
    props.nilais.forEach((nilai) => {
        if (nilai.siswa && nilai.siswa.kelas) {
            kelasSet.add(nilai.siswa.kelas);
        }
    });
    return Array.from(kelasSet);
});

// ambil mapel dari group by mapel
const mapelOptions = computed(() => {
    const mapelSet = new Set();
    props.nilais.forEach((nilai) => {
        if (nilai.mapel) {
            mapelSet.add(nilai.mapel);
        }
    });
    return Array.from(mapelSet);
});

const editNilai = (id) => {
    router.get(route("nilais.edit", id));
};

const showNilai = (id) => {
    router.get(route("nilais.show", id));
};

const showDeleteModal = ref(false);
const selectedId = ref(null);

const askDelete = (id) => {
    selectedId.value = id;
    showDeleteModal.value = true;
};

const deleteNilai = () => {
    router.delete(route("nilais.destroy", selectedId.value));
    showDeleteModal.value = false;
};

const exportNilai = () => {
    window.location.href = route("nilai.export");
};

const applyFilters = () => {
    const query = {};

    if (filters.value.siswa) {
        query.siswa = filters.value.siswa;
    }
    if (filters.value.kelas) {
        query.kelas = filters.value.kelas;
    }
    if (filters.value.mapel) {
        query.mapel = filters.value.mapel;
    }

    router.get(route("nilais.index"), query, {
        preserveState: true,
        replace: true,
    });
};
</script>

<template>
    <CardComponent title="Nilai">
        <div
            class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default"
        >
            <!-- Button Export, Import and Create Tailwind Style  -->
            <div class="flex justify-between items-start p-4">
                <div class="space-y-4">
                    <!-- EXPORT BUTTON -->
                    <button
                        @click="exportNilai"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm"
                    >
                        Export Nilai
                    </button>

                    <!-- IMPORT SECTION -->
                    <div class="space-y-3">
                        <input
                            id="file_input"
                            type="file"
                            accept=".xlsx,.csv"
                            @change="handleFile"
                            class="cursor-pointer w-full bg-white border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 shadow-sm"
                            ref="fileInput"
                        />

                        <button
                            @click="importNilai"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm"
                        >
                            Import Nilai
                        </button>
                    </div>
                </div>

                <!-- CREATE -->
                <Link
                    href="/nilais/create"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm"
                >
                    Create Nilai
                </Link>
            </div>

            <!-- Filter By name Kelas Dan Mapel -->
            <!-- Filter Section -->
            <div class="p-4 bg-white border rounded-lg shadow-sm mb-4">
                <h3 class="text-lg font-semibold mb-3">Filter Nilai</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Filter Nama -->
                    <div>
                        <Label class="mb-1 block">Nama Siswa</Label>
                        <select
                            v-model="filters.siswa"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua Siswa</option>
                            <option
                                v-for="siswa in siswas"
                                :key="siswa.nama"
                                :value="siswa.nama"
                            >
                                {{ siswa.nama }}
                            </option>
                        </select>
                    </div>

                    <!-- Filter Kelas -->
                    <div>
                        <Label class="mb-1 block">Kelas</Label>
                        <select
                            v-model="filters.kelas"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua Kelas</option>
                            <option
                                v-for="kelas in kelasOptions"
                                :key="kelas"
                                :value="kelas"
                            >
                                {{ kelas }}
                            </option>
                        </select>
                    </div>

                    <!-- Filter Mapel -->
                    <div>
                        <Label class="mb-1 block">Mata Pelajaran</Label>
                        <select
                            v-model="filters.mapel"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua Mapel</option>
                            <option
                                v-for="mapel in mapelOptions"
                                :key="mapel"
                                :value="mapel"
                            >
                                {{ mapel }}
                            </option>
                        </select>
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-end">
                        <button
                            @click="applyFilters"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-sm"
                        >
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead
                    class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">No</th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Nama Siswa
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">Kelas</th>
                        <th scope="col" class="px-6 py-3 font-medium">Mapel</th>
                        <th scope="col" class="px-6 py-3 font-medium">Nilai</th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default"
                        v-for="nilai in nilais"
                        :key="nilai.id"
                    >
                        <!-- {{ nilai }} -->
                        <!-- urutan indx -->
                        <td class="px-6 py-4">
                            {{ nilais.indexOf(nilai) + 1 }}
                        </td>
                        <td class="px-6 py-4">{{ nilai.siswa.nama }}</td>
                        <td class="px-6 py-4">{{ nilai.siswa.kelas }}</td>
                        <td class="px-6 py-4">{{ nilai.mapel }}</td>
                        <td class="px-6 py-4">{{ nilai.nilai }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <!-- View -->
                                <button
                                    @click="showNilai(nilai.id)"
                                    class="p-2 rounded-lg hover:bg-gray-100 text-blue-600"
                                    title="View"
                                >
                                    <!-- Eye Icon -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z"
                                        />
                                    </svg>
                                </button>

                                <!-- Edit -->
                                <button
                                    @click="editNilai(nilai.id)"
                                    class="p-2 rounded-lg hover:bg-gray-100 text-yellow-600"
                                    title="Edit"
                                >
                                    <!-- Pencil Icon -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M18.5 2.5a2.121 2.121 0 013 3l-9 9L10 15l.5-2.5 9-9z"
                                        />
                                    </svg>
                                </button>

                                <!-- Delete -->
                                <button
                                    @click="askDelete(nilai.id)"
                                    class="p-2 rounded-lg hover:bg-gray-100 text-red-600"
                                    title="Delete"
                                >
                                    <!-- Trash Icon -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V5a2 2 0 00-2-2h-3a2 2 0 00-2 2v2M4 7h16"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- MODAL DELETE -->
        <ConfirmDelete
            :show="showDeleteModal"
            title="Hapus Nilai"
            message="Apakah Anda yakin ingin menghapus nilai ini?"
            @cancel="showDeleteModal = false"
            @confirm="deleteNilai"
        />
    </CardComponent>
</template>
