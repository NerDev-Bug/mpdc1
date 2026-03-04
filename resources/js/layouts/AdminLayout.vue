<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="flex">
            <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform duration-200 ease-in-out"
                :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
            >
                <div class="flex items-center justify-between h-16 px-6 border-b border-gray-700">
                    <h1 class="text-lg font-bold tracking-wide">MPDC Admin</h1>
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="mt-4 px-3 space-y-1">
                    <Link :href="route('admin.dashboard')"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
                        :class="currentRoute === 'admin.dashboard' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </Link>
                    <Link :href="route('admin.news.index')"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
                        :class="currentRoute?.startsWith('admin.news') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        News Maintenance
                    </Link>
                    <Link :href="route('admin.inquiries.index')"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
                        :class="currentRoute?.startsWith('admin.inquiries') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Inquiries
                    </Link>
                </nav>
                <div class="absolute bottom-0 w-full border-t border-gray-700 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-sm font-bold">
                            {{ auth.user?.name?.charAt(0)?.toUpperCase() }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ auth.user?.name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth.user?.email }}</p>
                        </div>
                    </div>
                    <Link :href="route('home')" method="get" class="mt-3 flex items-center gap-2 text-xs text-gray-400 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Site
                    </Link>
                    <Link :href="route('logout')" method="post" as="button" class="mt-2 w-full flex items-center gap-2 text-xs text-gray-400 hover:text-red-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </Link>
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1 lg:ml-64">
                <!-- Top bar -->
                <header class="sticky top-0 z-40 bg-white border-b border-gray-200 h-16 flex items-center px-4 lg:px-8">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden mr-4 text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-800">{{ title }}</h2>
                    </div>
                </header>

                <!-- Page content -->
                <main class="p-4 lg:p-8">
                    <!-- Flash messages -->
                    <div v-if="(($page.props as any).flash as any)?.success" class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-800">
                        {{ (($page.props as any).flash as any).success }}
                    </div>
                    <div v-if="(($page.props as any).flash as any)?.error" class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-800">
                        {{ (($page.props as any).flash as any).error }}
                    </div>
                    <slot />
                </main>
            </div>
        </div>

        <!-- Mobile overlay -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
    title?: string;
}>();

const page = usePage();
const auth = computed(() => page.props.auth as any);
const currentRoute = computed(() => {
    try {
        return (route() as any).current();
    } catch {
        return '';
    }
});

const sidebarOpen = ref(true);
</script>
