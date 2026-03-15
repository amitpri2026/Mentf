<template>
  <AppLayout>
    <Head title="Contact Us" />

    <div class="max-w-3xl mx-auto px-4 py-12 sm:py-16">
      <!-- Header -->
      <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Get in Touch</h1>
        <p class="text-gray-500 text-lg">We'd love to hear from you. Reach out and we'll get back to you shortly.</p>
      </div>

      <div class="grid sm:grid-cols-2 gap-6">

        <!-- Contact Details -->
        <div class="bg-white rounded-2xl border border-gray-100 p-8 space-y-6">
          <h2 class="text-base font-bold text-gray-900">Contact Details</h2>

          <div v-if="email" class="flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
              <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Email</p>
              <a :href="`mailto:${email}`" class="text-blue-600 hover:text-blue-800 text-sm font-medium">{{ email }}</a>
            </div>
          </div>

          <div v-if="phone" class="flex items-start gap-4">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
              <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Phone</p>
              <a :href="`tel:${phone}`" class="text-gray-800 hover:text-gray-900 text-sm font-medium">{{ phone }}</a>
            </div>
          </div>

          <div v-if="address" class="flex items-start gap-4">
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center shrink-0">
              <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Address</p>
              <p class="text-gray-800 text-sm">{{ address }}</p>
            </div>
          </div>
        </div>

        <!-- Quick actions -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-8 text-white flex flex-col justify-between">
          <div>
            <h2 class="text-base font-bold mb-2">Looking for a mentor?</h2>
            <p class="text-blue-100 text-sm leading-relaxed mb-6">
              Browse our curated list of expert mentors and find the perfect match for your goals.
            </p>
            <Link href="/mentors"
              class="inline-block bg-white text-blue-700 text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-50 transition-colors">
              Browse Mentors
            </Link>
          </div>

          <div class="mt-8 pt-6 border-t border-blue-500">
            <h3 class="text-sm font-semibold mb-2">Are you a mentor?</h3>
            <p class="text-blue-200 text-xs leading-relaxed mb-4">
              Join MentF and start helping learners achieve their goals.
            </p>
            <Link href="/register"
              class="inline-block border border-white text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-white hover:text-blue-700 transition-colors">
              Apply to Mentor
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ email: String, phone: String, address: String });
</script>
