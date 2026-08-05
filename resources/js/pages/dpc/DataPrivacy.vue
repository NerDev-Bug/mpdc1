<template>
    <AppLayout>
        <SeoHead
            title="Privacy Policy"
            description="Read the MPDC Privacy Policy covering personal data collection, use, disclosure, retention, security, and privacy rights."
            canonical-path="/data-privacy"
            :structured-data="{
                '@type': 'WebPage',
                name: 'MPDC Privacy Policy',
            }"
        />
        <div class="flex flex-col min-h-screen bg-white">
            <!-- Hero Section with Responsive Background Image -->
            <main class="relative bg-white">
                <DataPrivacy1/>
            </main>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import DataPrivacy1 from './DataPrivacy1.vue';
</script>


<style scoped>

</style>
