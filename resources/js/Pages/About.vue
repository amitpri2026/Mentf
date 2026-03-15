<template>
  <AppLayout>
    <Head title="About Us" />

    <div class="max-w-3xl mx-auto px-4 py-12 sm:py-16">
      <!-- Header -->
      <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">About MentF</h1>
        <p class="text-gray-500 text-lg">Connecting learners with world-class mentors.</p>
      </div>

      <!-- Content -->
      <div class="prose-content bg-white rounded-2xl border border-gray-100 p-8 sm:p-10"
        v-html="content"></div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ content: String });
</script>

<style scoped>
.prose-content :deep(h2) {
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  margin-top: 1.75rem;
  margin-bottom: 0.75rem;
}
.prose-content :deep(h3) {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin-top: 1.5rem;
  margin-bottom: 0.5rem;
}
.prose-content :deep(p) {
  color: #4b5563;
  line-height: 1.75;
  margin-bottom: 1rem;
}
.prose-content :deep(ul) {
  list-style: disc;
  padding-left: 1.5rem;
  color: #4b5563;
  margin-bottom: 1rem;
  line-height: 1.75;
}
.prose-content :deep(li) {
  margin-bottom: 0.25rem;
}
.prose-content :deep(a) {
  color: #2563eb;
  text-decoration: underline;
}
.prose-content :deep(strong) {
  font-weight: 600;
  color: #1f2937;
}
</style>
