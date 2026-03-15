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
      <div v-if="mentors.data.length > 0" class="mb-12">
        <div class="flex items-end justify-between mb-6">
          <h2 class="text-2xl font-bold text-slate-900">Top Mentors in {{ category.name }}</h2>
          <Link :href="`/mentors?category=${category.slug}`" class="text-sm text-blue-600 font-semibold hover:text-indigo-800">
            See all →
          </Link>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <MentorCard v-for="mentor in mentors.data" :key="mentor.id" :mentor="mentor" />
        </div>

        <!-- Mentor Pagination -->
        <div v-if="mentors.last_page > 1" class="mt-6 flex items-center justify-between">
          <p class="text-sm text-slate-500">
            Page <span class="font-semibold text-slate-900">{{ mentors.current_page }}</span> of <span class="font-semibold text-slate-900">{{ mentors.last_page }}</span>
          </p>
          <div class="flex gap-2">
            <button
              @click="goToMentorPage(mentors.current_page - 1)"
              :disabled="mentors.current_page === 1"
              class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-lg border transition-colors"
              :class="mentors.current_page === 1 ? 'border-slate-200 text-slate-300 cursor-not-allowed bg-white' : 'border-slate-200 text-slate-700 bg-white hover:bg-slate-50'"
            >← Prev</button>
            <button
              @click="goToMentorPage(mentors.current_page + 1)"
              :disabled="mentors.current_page === mentors.last_page"
              class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-lg border transition-colors"
              :class="mentors.current_page === mentors.last_page ? 'border-slate-200 text-slate-300 cursor-not-allowed bg-white' : 'border-slate-200 text-slate-700 bg-white hover:bg-slate-50'"
            >Next →</button>
          </div>
        </div>
      </div>

      <!-- Packages -->
      <div v-if="packages.data.length > 0">
        <div class="flex items-end justify-between mb-6">
          <h2 class="text-2xl font-bold text-slate-900">Popular Packages</h2>
          <Link :href="`/packages?category=${category.slug}`" class="text-sm text-blue-600 font-semibold hover:text-indigo-800">
            See all →
          </Link>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <PackageCard v-for="pkg in packages.data" :key="pkg.id" :package="pkg" />
        </div>

        <!-- Package Pagination -->
        <div v-if="packages.last_page > 1" class="mt-6 flex items-center justify-between">
          <p class="text-sm text-slate-500">
            Page <span class="font-semibold text-slate-900">{{ packages.current_page }}</span> of <span class="font-semibold text-slate-900">{{ packages.last_page }}</span>
          </p>
          <div class="flex gap-2">
            <button
              @click="goToPackagePage(packages.current_page - 1)"
              :disabled="packages.current_page === 1"
              class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-lg border transition-colors"
              :class="packages.current_page === 1 ? 'border-slate-200 text-slate-300 cursor-not-allowed bg-white' : 'border-slate-200 text-slate-700 bg-white hover:bg-slate-50'"
            >← Prev</button>
            <button
              @click="goToPackagePage(packages.current_page + 1)"
              :disabled="packages.current_page === packages.last_page"
              class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-lg border transition-colors"
              :class="packages.current_page === packages.last_page ? 'border-slate-200 text-slate-300 cursor-not-allowed bg-white' : 'border-slate-200 text-slate-700 bg-white hover:bg-slate-50'"
            >Next →</button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MentorCard from '@/Components/MentorCard.vue';
import PackageCard from '@/Components/PackageCard.vue';

const props = defineProps({
  category: Object,
  mentors: Object,
  packages: Object,
});

function goToMentorPage(page) {
  router.get(`/categories/${props.category.slug}`, { mentor_page: page }, { preserveScroll: true });
}

function goToPackagePage(page) {
  router.get(`/categories/${props.category.slug}`, { package_page: page }, { preserveScroll: true });
}

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
