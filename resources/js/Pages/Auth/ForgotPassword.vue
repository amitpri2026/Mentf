<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
      <div class="text-center mb-8">
        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">Forgot Password</h1>
        <p class="text-slate-500 mt-1">Enter your email to receive a reset link</p>
      </div>

      <div v-if="$page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
        {{ $page.props.flash.success }}
      </div>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
          <input v-model="form.email" type="email" required
            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="you@example.com" />
          <p v-if="form.errors?.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
        </div>
        <button type="submit" :disabled="form.processing"
          class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-60">
          Send Reset Link
        </button>
      </form>

      <p class="text-center text-sm text-slate-500 mt-6">
        Remember your password?
        <Link href="/login" class="text-blue-600 font-medium hover:underline">Sign in</Link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
const form = useForm({ email: '' });
function submit() { form.post('/forgot-password'); }
</script>
