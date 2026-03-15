<template>
  <AdminLayout>
    <Head title="Admin Dashboard" />

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
      <div v-for="stat in statCards" :key="stat.label" class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500">{{ stat.label }}</p>
            <p class="text-3xl font-extrabold mt-1" :class="stat.color">{{ stat.value }}</p>
          </div>
          <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl" :class="stat.bg">
            {{ stat.icon }}
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Recent Users -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-900">Recent Users</h3>
          <Link href="/admin/users" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</Link>
        </div>
        <div class="space-y-3">
          <div v-for="user in recentUsers" :key="user.id" class="flex items-center gap-3 py-2">
            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold text-sm flex-shrink-0">
              {{ user.name.charAt(0) }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900 truncate">{{ user.name }}</p>
              <p class="text-xs text-gray-500">{{ user.email }}</p>
            </div>
            <span
              class="text-xs font-medium px-2 py-0.5 rounded-full flex-shrink-0"
              :class="{
                'bg-purple-100 text-purple-700': user.role === 'admin',
                'bg-indigo-100 text-indigo-700': user.role === 'mentor',
                'bg-gray-100 text-gray-600': user.role === 'mentee',
              }"
            >
              {{ user.role }}
            </span>
          </div>
        </div>
      </div>

      <!-- Recent Enrollments -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-900">Recent Enrollments</h3>
          <Link href="/admin/enrollments" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</Link>
        </div>
        <div class="space-y-3">
          <div v-for="enrollment in recentEnrollments" :key="enrollment.id" class="flex items-center gap-3 py-2">
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900 truncate">{{ enrollment.user.name }}</p>
              <p class="text-xs text-gray-500 truncate">{{ enrollment.package.title }}</p>
            </div>
            <div class="text-right flex-shrink-0">
              <p class="text-sm font-bold text-indigo-600">${{ enrollment.amount_paid }}</p>
              <p class="text-xs text-gray-400">{{ enrollment.created_at }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick links -->
    <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
      <Link href="/admin/users" class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 hover:border-indigo-200 hover:bg-indigo-50 transition-all">
        <span class="text-2xl">👥</span>
        <span class="font-medium text-gray-800 text-sm">Manage Users</span>
      </Link>
      <Link href="/admin/categories" class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 hover:border-indigo-200 hover:bg-indigo-50 transition-all">
        <span class="text-2xl">🏷️</span>
        <span class="font-medium text-gray-800 text-sm">Categories</span>
      </Link>
      <Link href="/admin/packages" class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 hover:border-indigo-200 hover:bg-indigo-50 transition-all">
        <span class="text-2xl">📦</span>
        <span class="font-medium text-gray-800 text-sm">Packages</span>
      </Link>
      <Link href="/admin/enrollments" class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 hover:border-indigo-200 hover:bg-indigo-50 transition-all">
        <span class="text-2xl">📋</span>
        <span class="font-medium text-gray-800 text-sm">Enrollments</span>
      </Link>
    </div>
  </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  stats: Object,
  recentUsers: Array,
  recentEnrollments: Array,
});

const statCards = computed(() => [
  { label: 'Total Users', value: props.stats?.total_users || 0, color: 'text-indigo-600', bg: 'bg-indigo-50', icon: '👥' },
  { label: 'Mentors', value: props.stats?.total_mentors || 0, color: 'text-purple-600', bg: 'bg-purple-50', icon: '🏆' },
  { label: 'Packages', value: props.stats?.total_packages || 0, color: 'text-blue-600', bg: 'bg-blue-50', icon: '📦' },
  { label: 'Enrollments', value: props.stats?.total_enrollments || 0, color: 'text-green-600', bg: 'bg-green-50', icon: '📋' },
  { label: 'Mentees', value: props.stats?.total_mentees || 0, color: 'text-amber-600', bg: 'bg-amber-50', icon: '🎓' },
  { label: 'Categories', value: props.stats?.total_categories || 0, color: 'text-blue-600', bg: 'bg-blue-50', icon: '🏷️' },
  { label: 'Active Packages', value: props.stats?.active_packages || 0, color: 'text-emerald-600', bg: 'bg-emerald-50', icon: '✅' },
  { label: 'Reviews', value: props.stats?.total_reviews || 0, color: 'text-rose-600', bg: 'bg-rose-50', icon: '⭐' },
]);
</script>
