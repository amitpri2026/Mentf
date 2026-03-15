<template>
  <AppLayout>
    <Head :title="post.title" />

    <div class="max-w-3xl mx-auto px-4 py-12 sm:py-16">

      <!-- Back -->
      <Link href="/blog" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-8 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Blog
      </Link>

      <!-- Article -->
      <article class="bg-white rounded-2xl border border-gray-100 p-8 sm:p-10">
        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-3">
          {{ formatDate(post.published_at) }}
        </p>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
          {{ post.title }}
        </h1>
        <p v-if="post.excerpt" class="text-gray-500 text-base border-l-4 border-blue-200 pl-4 mb-8 italic">
          {{ post.excerpt }}
        </p>

        <div class="prose-content" v-html="post.content"></div>
      </article>

      <!-- CTA -->
      <div class="mt-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-7 text-white text-center">
        <h3 class="text-lg font-bold mb-2">Ready to find your mentor?</h3>
        <p class="text-blue-100 text-sm mb-5">Connect with an expert who can help you reach your goals faster.</p>
        <Link href="/mentors"
          class="inline-block bg-white text-blue-700 text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-50 transition-colors">
          Browse Mentors
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ post: Object });

function formatDate(d) {
  return new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' });
}
</script>

<style scoped>
.prose-content :deep(h2) {
  font-size: 1.375rem;
  font-weight: 700;
  color: #111827;
  margin-top: 2rem;
  margin-bottom: 0.75rem;
}
.prose-content :deep(h3) {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin-top: 1.75rem;
  margin-bottom: 0.5rem;
}
.prose-content :deep(p) {
  color: #4b5563;
  line-height: 1.8;
  margin-bottom: 1rem;
}
.prose-content :deep(ul) {
  list-style: disc;
  padding-left: 1.5rem;
  color: #4b5563;
  margin-bottom: 1rem;
  line-height: 1.75;
}
.prose-content :deep(ol) {
  list-style: decimal;
  padding-left: 1.5rem;
  color: #4b5563;
  margin-bottom: 1rem;
  line-height: 1.75;
}
.prose-content :deep(li) {
  margin-bottom: 0.35rem;
}
.prose-content :deep(a) {
  color: #2563eb;
  text-decoration: underline;
}
.prose-content :deep(strong) {
  font-weight: 600;
  color: #1f2937;
}
.prose-content :deep(blockquote) {
  border-left: 4px solid #dbeafe;
  padding-left: 1rem;
  color: #6b7280;
  font-style: italic;
  margin: 1.5rem 0;
}
</style>
