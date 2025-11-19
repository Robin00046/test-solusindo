<script setup>
import CardComponent from "@/Components/CardComponent.vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    nilai: Object,
});
</script>

<template>
    <CardComponent title="Detail Nilai">
        <!-- Tombol kembali -->
        <Link
            :href="route('nilais.index')"
            class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition mb-4"
        >
            ← Kembali
        </Link>

        <!-- Card Detail -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Informasi Nilai
            </h2>

            <div class="space-y-3">
                <div>
                    <span class="text-gray-500 font-medium">Nama Siswa</span>
                    <p class="text-gray-900 text-lg font-semibold">
                        {{ nilai.siswa?.nama ?? "Tidak ditemukan" }}
                    </p>
                </div>

                <div>
                    <span class="text-gray-500 font-medium">Kelas</span>
                    <p class="text-gray-900 text-lg font-semibold">
                        {{ nilai.siswa?.kelas ?? "-" }}
                    </p>
                </div>

                <div>
                    <span class="text-gray-500 font-medium"
                        >Mata Pelajaran</span
                    >
                    <p class="text-gray-900 text-lg font-semibold">
                        {{ nilai.mapel }}
                    </p>
                </div>

                <div>
                    <span class="text-gray-500 font-medium">Nilai</span>
                    <p class="text-gray-900 text-xl font-bold">
                        {{ nilai.nilai }}
                    </p>
                </div>
            </div>
        </div>
    </CardComponent>
</template>
