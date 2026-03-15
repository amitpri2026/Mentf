<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center px-4 py-10">
    <Head title="Create Account" />

    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-2">
          <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
            <span class="text-white font-bold">M</span>
          </div>
          <span class="text-2xl font-bold text-gray-900">Ment<span class="text-indigo-600">F</span></span>
        </Link>
        <h1 class="text-2xl font-bold text-gray-900 mt-6 mb-2">Create your account</h1>
        <p class="text-gray-600 text-sm">Join thousands of mentors and learners</p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Role selection -->
        <div class="mb-6">
          <p class="text-sm font-semibold text-gray-700 mb-3">I want to join as:</p>
          <div class="grid grid-cols-2 gap-3">
            <button
              type="button"
              @click="form.role = 'mentee'"
              class="p-4 rounded-xl border-2 text-center transition-all"
              :class="form.role === 'mentee' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-gray-300'"
            >
              <div class="text-2xl mb-1">🎓</div>
              <div class="text-sm font-semibold" :class="form.role === 'mentee' ? 'text-indigo-700' : 'text-gray-700'">Mentee</div>
              <div class="text-xs text-gray-500">I want to learn</div>
            </button>
            <button
              type="button"
              @click="form.role = 'mentor'"
              class="p-4 rounded-xl border-2 text-center transition-all"
              :class="form.role === 'mentor' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-gray-300'"
            >
              <div class="text-2xl mb-1">💡</div>
              <div class="text-sm font-semibold" :class="form.role === 'mentor' ? 'text-indigo-700' : 'text-gray-700'">Mentor</div>
              <div class="text-xs text-gray-500">I want to teach</div>
            </button>
          </div>
          <p v-if="errors.role" class="text-red-500 text-xs mt-1">{{ errors.role }}</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
            <input v-model="form.name" type="text" required class="input-field" placeholder="John Doe" :class="{ 'border-red-400': errors.name }" />
            <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <input v-model="form.email" type="email" required class="input-field" placeholder="you@example.com" :class="{ 'border-red-400': errors.email }" />
            <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <input v-model="form.password" type="password" required class="input-field" placeholder="Min. 8 characters" :class="{ 'border-red-400': errors.password }" />
            <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
            <input v-model="form.password_confirmation" type="password" required class="input-field" placeholder="Confirm your password" />
          </div>

          <div class="flex items-start gap-2 pt-1">
            <input v-model="form.terms" type="checkbox" required class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            <label class="text-xs text-gray-600">
              I agree to the <a href="#" class="text-indigo-600 font-medium">Terms of Service</a> and <a href="#" class="text-indigo-600 font-medium">Privacy Policy</a>
            </label>
          </div>

          <button type="submit" :disabled="processing" class="btn-primary w-full justify-center py-3 text-base mt-2">
            <span v-if="processing">Creating account...</span>
            <span v-else>Create Account</span>
          </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
          Already have an account?
          <Link href="/login" class="text-indigo-600 font-semibold hover:text-indigo-800">Sign in</Link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';

const processing = ref(false);
const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'mentee',
  terms: false,
});
const errors = reactive({});

function submit() {
  processing.value = true;
  router.post('/register', form, {
    onError: (errs) => {
      Object.assign(errors, errs);
      processing.value = false;
    },
    onFinish: () => { processing.value = false; },
  });
}
</script>
