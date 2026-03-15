<template>
  <AppLayout>
    <Head title="Blog" />

    <div class="max-w-4xl mx-auto px-4 py-12 sm:py-16">
      <!-- Header -->
      <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">MentF Blog</h1>
        <p class="text-gray-500 text-lg">Tips, stories, and insights on mentorship and learning.</p>
      </div>

      <!-- Posts grid -->
      <div v-if="posts.length" class="grid sm:grid-cols-2 gap-6">
        <Link v-for="post in posts" :key="post.id" :href="`/blog/${post.slug}`"
          class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-blue-200 hover:shadow-md transition-all group">
          <div class="flex flex-col h-full">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-3">
              {{ formatDate(post.published_at) }}
            </p>
            <h2 class="text-base font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors leading-snug">
              {{ post.title }}
            </h2>
            <p v-if="post.excerpt" class="text-sm text-gray-500 leading-relaxed flex-1">
              {{ post.excerpt }}
            </p>
            <div class="mt-4 flex items-center gap-1 text-blue-600 text-sm font-medium">
              Read more
              <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
        </Link>
      </div>

      <!-- Empty state -->
      <div v-else class="text-center py-20 text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        <p class="text-lg font-medium">No posts yet</p>
        <p class="text-sm mt-1">Check back soon for articles on mentorship and learning.</p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ posts: Array });

function formatDate(d) {
  return new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' });
}
</script>
