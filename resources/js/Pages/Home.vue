<script setup>
import { Head, Link } from "@inertiajs/vue3";
import GroupList from "@/Components/app/GroupList.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    groups: Array,
});
</script>

<template>
    <Head title="Social Media Website" />

    <!-- <AuthenticatedLayout> -->
        <div class="grid lg:grid-cols-12 gap-3 p-4 h-full">
            <div class="lg:col-span-3 lg:order-1 h-full overflow-hidden">
                <GroupList :groups="groups" />
            </div>
        </div>
    <!-- </AuthenticatedLayout> -->
</template>

<style></style>
