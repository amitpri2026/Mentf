<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center px-4">
    <Head title="Login" />

    <div class="w-full max-w-md">
      <!-- Logo -->
      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-2">
          <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
            <span class="text-white font-bold">M</span>
          </div>
          <span class="text-2xl font-bold text-gray-900">Ment<span class="text-indigo-600">F</span></span>
        </Link>
        <h1 class="text-2xl font-bold text-gray-900 mt-6 mb-2">Welcome back!</h1>
        <p class="text-gray-600 text-sm">Sign in to your account</p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <form @submit.prevent="submit" class="space-y-5">
          <div v-if="$page.props.flash?.error" class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
            {{ $page.props.flash.error }}
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <input
              v-model="form.email"
              type="email"
              required
              autocomplete="email"
              class="input-field"
              :class="{ 'border-red-400': errors.email }"
              placeholder="you@example.com"
            />
            <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <input
              v-model="form.password"
              type="password"
              required
              autocomplete="current-password"
              class="input-field"
              :class="{ 'border-red-400': errors.password }"
              placeholder="Enter your password"
            />
            <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password }}</p>
          </div>

          <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-600">
              <input v-model="form.remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
              Remember me
            </label>
            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Forgot password?</a>
          </div>

          <button
            type="submit"
            :disabled="processing"
            class="btn-primary w-full justify-center py-3 text-base"
          >
            <span v-if="processing">Signing in...</span>
            <span v-else>Sign In</span>
          </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
          Don't have an account?
          <Link href="/register" class="text-indigo-600 font-semibold hover:text-indigo-800">Sign up free</Link>
        </p>

        <!-- Demo credentials -->
        <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
          <p class="text-xs font-semibold text-gray-600 mb-2">Demo Accounts:</p>
          <div class="space-y-1">
            <p class="text-xs text-gray-600">Admin: admin@mentf.com / password</p>
            <p class="text-xs text-gray-600">Mentor: sarah@mentf.com / password</p>
            <p class="text-xs text-gray-600">Mentee: alex@example.com / password</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();
const processing = ref(false);

const form = reactive({
  email: '',
  password: '',
  remember: false,
});

const errors = reactive({});

function submit() {
  processing.value = true;
  router.post('/login', form, {
    onError: (errs) => {
      Object.assign(errors, errs);
      processing.value = false;
    },
    onFinish: () => {
      processing.value = false;
    },
  });
}
</script>
