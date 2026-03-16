<template>
  <AppLayout>
    <Head title="Contact Us" />

    <div class="max-w-5xl mx-auto px-4 py-12 sm:py-16">
      <!-- Header -->
      <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Get in Touch</h1>
        <p class="text-gray-500 text-lg">We'd love to hear from you. Reach out and we'll get back to you shortly.</p>
      </div>

      <div class="grid lg:grid-cols-3 gap-6">

        <!-- Left: Contact details + quick links -->
        <div class="space-y-5">

          <!-- Contact Details -->
          <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5">
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

            <div v-if="!email && !phone" class="text-sm text-gray-400">Contact details not configured yet.</div>
          </div>

          <!-- Quick actions -->
          <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white">
            <h2 class="text-sm font-bold mb-2">Looking for a mentor?</h2>
            <p class="text-blue-100 text-xs leading-relaxed mb-4">
              Browse our curated list of expert mentors and find the perfect match for your goals.
            </p>
            <Link href="/mentors"
              class="inline-block bg-white text-blue-700 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">
              Browse Mentors
            </Link>
            <div class="mt-5 pt-4 border-t border-blue-500">
              <h3 class="text-xs font-semibold mb-1">Are you a mentor?</h3>
              <p class="text-blue-200 text-xs leading-relaxed mb-3">Join MentF and start helping learners achieve their goals.</p>
              <Link href="/register"
                class="inline-block border border-white text-white text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-white hover:text-blue-700 transition-colors">
                Apply to Mentor
              </Link>
            </div>
          </div>
        </div>

        <!-- Right: Inquiry Form -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-8">
          <h2 class="text-base font-bold text-gray-900 mb-1">Send us a message</h2>
          <p class="text-sm text-gray-500 mb-6">Fill in your details and we'll get back to you as soon as possible.</p>

          <!-- Success -->
          <div v-if="$page.props.flash?.success" class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium">
            {{ $page.props.flash.success }}
          </div>

          <form @submit.prevent="submit" class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  placeholder="Your name"
                  class="input-field"
                  :class="{ 'border-red-400': errors.name }"
                />
                <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</p>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                <input
                  v-model="form.phone"
                  type="tel"
                  required
                  placeholder="+91 98765 43210"
                  class="input-field"
                  :class="{ 'border-red-400': errors.phone }"
                />
                <p v-if="errors.phone" class="text-red-500 text-xs mt-1">{{ errors.phone }}</p>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
              <input
                v-model="form.email"
                type="email"
                required
                placeholder="you@example.com"
                class="input-field"
                :class="{ 'border-red-400': errors.email }"
              />
              <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Message <span class="text-gray-400 font-normal">(optional)</span></label>
              <textarea
                v-model="form.message"
                rows="4"
                placeholder="Tell us how we can help you..."
                class="input-field resize-none"
                :class="{ 'border-red-400': errors.message }"
              ></textarea>
              <p v-if="errors.message" class="text-red-500 text-xs mt-1">{{ errors.message }}</p>
            </div>

            <button
              type="submit"
              :disabled="processing"
              class="btn-primary w-full justify-center py-3 text-sm"
            >
              <span v-if="processing">Sending...</span>
              <span v-else>Send Message</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ email: String, phone: String });

const processing = ref(false);
const form = reactive({ name: '', email: '', phone: '', message: '' });
const errors = reactive({});

function submit() {
  processing.value = true;
  Object.keys(errors).forEach(k => delete errors[k]);
  router.post('/contact', { ...form }, {
    onError: (errs) => Object.assign(errors, errs),
    onSuccess: () => { form.name = ''; form.email = ''; form.phone = ''; form.message = ''; },
    onFinish: () => { processing.value = false; },
  });
}
</script>
