<script setup>
import CardComponent from "@/Components/CardComponent.vue";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount } from "vue";
import { router } from "@inertiajs/vue3";
import ConfirmDelete from "@/Components/ConfirmDelete.vue";

const props = defineProps({
    siswas: Array,
});

const showDeleteModal = ref(false);
const selectedId = ref(null);

const askDelete = (id) => {
    selectedId.value = id;
    showDeleteModal.value = true;
};

const deleteSiswa = () => {
    router.delete(route("siswas.destroy", selectedId.value));
    showDeleteModal.value = false;
};

const editSiswa = (id) => {
    router.get(route("siswas.edit", id));
};

const showSiswa = (id) => {
    router.get(route("siswas.show", id));
};

const kelasFilter = ref("");

const filterSiswas = () => {
    router.get(
        route("siswas.index"),
        { kelas: kelasFilter.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};
const siswaFilter = ref("");
const filterSiswasByName = () => {
    router.get(
        route("siswas.index"),
        { siswa: siswaFilter.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};
</script>

<template>
    <CardComponent title="Siswa">
        <Link
            :href="route('siswas.create')"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded-lg shadow-sm mb-4 inline-block"
        >
            Tambah Siswa
        </Link>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Filter Kelas -->
            <div class="relative">
                <span
                    class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400"
                >
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
                            stroke-width="1.5"
                            d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"
                        />
                    </svg>
                </span>

                <input
                    type="text"
                    placeholder="Filter Kelas..."
                    v-model="kelasFilter"
                    @input="filterSiswas"
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                />
            </div>

            <!-- Filter Nama -->
            <div class="relative">
                <span
                    class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400"
                >
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
                            stroke-width="1.5"
                            d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"
                        />
                    </svg>
                </span>

                <input
                    type="text"
                    placeholder="Filter Nama..."
                    v-model="siswaFilter"
                    @input="filterSiswasByName"
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                />
            </div>
        </div>

        <!-- Table of Siswas -->
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead
                class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default"
            >
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">No</th>
                    <th scope="col" class="px-6 py-3 font-medium">Nama</th>
                    <th scope="col" class="px-6 py-3 font-medium">Kelas</th>
                    <th scope="col" class="px-6 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default"
                    v-for="(siswa, index) in siswas"
                    :key="siswa.id"
                >
                    <td class="px-6 py-4">{{ index + 1 }}</td>
                    <td class="px-6 py-4">{{ siswa.nama }}</td>
                    <td class="px-6 py-4">{{ siswa.kelas }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <!-- View -->
                            <button
                                @click="showSiswa(siswa.id)"
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
                                @click="editSiswa(siswa.id)"
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
                                @click="askDelete(siswa.id)"
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
        <ConfirmDelete
            :show="showDeleteModal"
            title="Hapus Siswa"
            message="Apakah Anda yakin ingin menghapus siswa ini?"
            @cancel="showDeleteModal = false"
            @confirm="deleteSiswa"
        />
    </CardComponent>
</template>
