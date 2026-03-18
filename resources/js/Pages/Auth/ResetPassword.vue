<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
      <div class="text-center mb-8">
        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">Reset Password</h1>
        <p class="text-slate-500 mt-1">Enter your new password below</p>
      </div>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
          <input v-model="form.email" type="email" required
            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <p v-if="form.errors?.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
          <input v-model="form.password" type="password" required
            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <p v-if="form.errors?.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</p>
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
          <input v-model="form.password_confirmation" type="password" required
            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <button type="submit" :disabled="form.processing"
          class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-60">
          Reset Password
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ token: String, email: String });
const form = useForm({ token: props.token, email: props.email, password: '', password_confirmation: '' });
function submit() { form.post('/reset-password'); }
</script>
