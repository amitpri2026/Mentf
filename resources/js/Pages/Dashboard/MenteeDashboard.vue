<template>
  <AppLayout>
    <Head title="My Dashboard" />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $page.props.auth.user?.name }}! 👋</h1>
        <p class="text-gray-600 mt-1">Track your learning journey</p>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
          <div class="text-3xl font-extrabold text-indigo-600 mb-1">{{ stats.total_enrollments }}</div>
          <div class="text-sm text-gray-600">Total Enrollments</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
          <div class="text-3xl font-extrabold text-green-600 mb-1">{{ stats.active_enrollments }}</div>
          <div class="text-sm text-gray-600">Active Programs</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
          <div class="text-3xl font-extrabold text-purple-600 mb-1">{{ stats.completed_enrollments }}</div>
          <div class="text-sm text-gray-600">Completed</div>
        </div>
      </div>

      <!-- Enrollments -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
          <h2 class="text-xl font-bold text-gray-900">My Enrollments</h2>
          <Link href="/packages" class="text-sm text-indigo-600 font-semibold hover:text-indigo-800">Browse More</Link>
        </div>

        <div v-if="enrollments.length > 0" class="space-y-4">
          <div v-for="enrollment in enrollments" :key="enrollment.id" class="flex items-center gap-4 p-4 border border-gray-100 rounded-xl hover:border-indigo-100 transition-colors">
            <img :src="enrollment.package.mentor.profile_photo_url" :alt="enrollment.package.mentor.name" class="w-12 h-12 rounded-xl object-cover" />
            <div class="flex-1 min-w-0">
              <h4 class="font-semibold text-gray-900 text-sm truncate">{{ enrollment.package.title }}</h4>
              <p class="text-xs text-gray-500">by {{ enrollment.package.mentor.name }}</p>
              <p class="text-xs text-gray-400 mt-0.5">{{ enrollment.package.category?.name }}</p>
            </div>
            <div class="text-right flex-shrink-0">
              <span
                class="text-xs font-semibold px-2 py-1 rounded-full"
                :class="{
                  'bg-green-100 text-green-700': enrollment.status === 'active',
                  'bg-blue-100 text-blue-700': enrollment.status === 'completed',
                  'bg-gray-100 text-gray-600': enrollment.status === 'pending',
                }"
              >
                {{ enrollment.status }}
              </span>
              <p v-if="enrollment.enrolled_at" class="text-xs text-gray-400 mt-1">{{ enrollment.enrolled_at }}</p>
            </div>
          </div>
        </div>

        <div v-else class="text-center py-12">
          <div class="text-5xl mb-4">🎓</div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">No enrollments yet</h3>
          <p class="text-gray-500 text-sm mb-5">Find a mentor and start your learning journey</p>
          <Link href="/mentors" class="btn-primary">Browse Mentors</Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  enrollments: Array,
  stats: Object,
});
</script>
