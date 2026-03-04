<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Welcome Back" description="Sign in to access the admin panel">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-400 bg-green-400/10 rounded-lg px-4 py-2">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-5 font-montserrat">
            <div class="grid gap-5">
                <!-- Email -->
                <div class="grid gap-2">
                    <label for="email" class="text-sm font-medium text-white/80">Email address</label>
                    <input
                        id="email"
                        type="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                        class="w-full rounded-lg border border-white/20 bg-white/10 text-white placeholder-white/40 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400/50 outline-none transition-all backdrop-blur-sm"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Password -->
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-sm font-medium text-white/80">Password</label>
                        <a v-if="canResetPassword" :href="route('password.request')" class="text-xs text-blue-300/70 hover:text-blue-300 transition-colors" :tabindex="5">
                            Forgot password?
                        </a>
                    </div>
                    <input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Password"
                        class="w-full rounded-lg border border-white/20 bg-white/10 text-white placeholder-white/40 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400/50 outline-none transition-all backdrop-blur-sm"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <!-- Remember me -->
                <div class="flex items-center gap-3" :tabindex="3">
                    <input
                        id="remember"
                        type="checkbox"
                        v-model="form.remember"
                        :tabindex="4"
                        class="w-4 h-4 rounded border-white/30 bg-white/10 text-blue-500 focus:ring-blue-400/50 focus:ring-offset-0"
                    />
                    <label for="remember" class="text-sm text-white/60 cursor-pointer select-none">Remember me</label>
                </div>

                <!-- Submit button -->
                <button
                    type="submit"
                    class="mt-2 w-full rounded-lg bg-gradient-to-r from-[#1f2455] to-[#2a3a7a] hover:from-[#2a3a7a] hover:to-[#3a4a9a] text-white font-semibold py-3 px-4 text-sm transition-all duration-300 shadow-lg shadow-blue-900/30 hover:shadow-blue-800/40 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    :tabindex="4"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    {{ form.processing ? 'Signing in...' : 'Sign in' }}
                </button>
            </div>
        </form>
    </AuthBase>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

.font-montserrat {
    font-family: 'Montserrat', sans-serif;
}
</style>
