<script setup>
import CardComponent from "@/Components/CardComponent.vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    siswa: Object,
});
</script>

<template>
    <CardComponent title="Detail Siswa">
        <!-- Tombol kembali -->
        <Link
            :href="route('siswas.index')"
            class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition mb-4"
        >
            ← Kembali
        </Link>

        <!-- Card Detail -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Informasi Siswa
            </h2>

            <div class="space-y-3">
                <div>
                    <span class="text-gray-500 font-medium">Nama</span>
                    <p class="text-gray-900 text-lg font-semibold">
                        {{ siswa.nama }}
                    </p>
                </div>

                <div>
                    <span class="text-gray-500 font-medium">Kelas</span>
                    <p class="text-gray-900 text-lg font-semibold">
                        {{ siswa.kelas }}
                    </p>
                </div>
            </div>
        </div>
    </CardComponent>
</template>
