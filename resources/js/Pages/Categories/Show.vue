<template>
  <AppLayout>
    <Head :title="category.name" />

    <!-- Page header — compact, light -->
    <div class="bg-slate-50 border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-2xl shrink-0">
            {{ getEmoji(category.slug) }}
          </div>
          <div>
            <div class="flex items-center gap-2 mb-0.5">
              <a href="/" class="text-xs text-slate-400 hover:text-slate-600 transition-colors">Home</a>
              <span class="text-slate-300 text-xs">/</span>
              <span class="text-xs text-slate-500">Categories</span>
              <span class="text-slate-300 text-xs">/</span>
              <span class="text-xs font-medium text-blue-600">{{ category.name }}</span>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ category.name }}</h1>
            <p v-if="category.description" class="text-sm text-slate-500 mt-0.5 max-w-xl">{{ category.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Top Mentors -->
      <div v-if="mentors.length > 0" class="mb-12">
        <div class="flex items-end justify-between mb-6">
          <h2 class="text-2xl font-bold text-slate-900">Top Mentors in {{ category.name }}</h2>
          <Link :href="`/mentors?category=${category.slug}`" class="text-sm text-blue-600 font-semibold hover:text-indigo-800">
            See all →
          </Link>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <MentorCard v-for="mentor in mentors" :key="mentor.id" :mentor="mentor" />
        </div>
      </div>

      <!-- Packages -->
      <div v-if="packages.length > 0">
        <div class="flex items-end justify-between mb-6">
          <h2 class="text-2xl font-bold text-slate-900">Popular Packages</h2>
          <Link :href="`/packages?category=${category.slug}`" class="text-sm text-blue-600 font-semibold hover:text-indigo-800">
            See all →
          </Link>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <PackageCard v-for="pkg in packages" :key="pkg.id" :package="pkg" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MentorCard from '@/Components/MentorCard.vue';
import PackageCard from '@/Components/PackageCard.vue';

defineProps({
  category: Object,
  mentors: Array,
  packages: Array,
});

function getEmoji(slug) {
  const map = {
    'artificial-intelligence': '🤖', 'business': '💼', 'competitive-exams': '📚',
    'design-architecture': '🎨', 'development': '💻', 'finance': '💰',
    'health-fitness': '💪', 'hr': '👥', 'infrastructure': '☁️',
    'legal': '⚖️', 'marketing': '📢', 'music': '🎵',
    'photography-video': '📷', 'project-management': '📋',
  };
  return map[slug] || '📌';
}
</script>
