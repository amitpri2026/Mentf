<template>
  <AppLayout>
    <Head title="Mentor Dashboard" />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      <!-- Header -->
      <div class="mb-8 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-slate-900">Mentor Dashboard</h1>
          <p class="text-slate-500 mt-0.5 text-sm">Manage your packages and track your students</p>
        </div>
        <div class="flex items-center gap-4">
          <Link href="/mentor/profile"
            class="text-sm font-medium text-slate-600 hover:text-blue-600 flex items-center gap-1 transition-colors">
            ✏️ Edit Profile
          </Link>
          <Link :href="`/mentors/${$page.props.auth.user?.slug}`"
            class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
            View public profile →
          </Link>
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
          <div class="text-3xl font-extrabold text-blue-600 mb-1">{{ stats.total_packages }}</div>
          <div class="text-sm text-slate-500">Packages</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
          <div class="text-3xl font-extrabold text-emerald-600 mb-1">{{ recentEnrollments.length }}</div>
          <div class="text-sm text-slate-500">Total Students</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
          <div class="flex items-center gap-1 mb-1">
            <span class="text-3xl font-extrabold text-amber-500">{{ stats.avg_rating?.toFixed(1) || '—' }}</span>
            <span class="text-amber-400 text-xl">★</span>
          </div>
          <div class="text-sm text-slate-500">Average Rating</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
          <div class="text-3xl font-extrabold text-purple-600 mb-1">{{ stats.total_reviews }}</div>
          <div class="text-sm text-slate-500">Reviews</div>
        </div>
      </div>

      <!-- Packages panel -->
      <div class="bg-white rounded-xl border border-slate-200 mb-6">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
          <h2 class="text-base font-bold text-slate-900">My Packages</h2>
          <div class="flex gap-2">
            <Link href="/mentor/packages/create"
              class="text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold transition-colors flex items-center gap-1">
              <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
              </svg>
              New
            </Link>
            <Link href="/mentor/packages"
              class="text-xs px-3 py-1.5 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-lg font-semibold transition-colors">
              Manage All
            </Link>
          </div>
        </div>

        <div v-if="packages.length > 0" class="divide-y divide-slate-100">
          <div v-for="pkg in packages" :key="pkg.id"
            class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50 transition-colors">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2">
                <h4 class="font-medium text-sm text-slate-900 truncate">{{ pkg.title }}</h4>
                <span class="flex-shrink-0 text-xs px-1.5 py-0.5 rounded font-medium"
                  :class="pkg.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'">
                  {{ pkg.is_active ? 'Active' : 'Draft' }}
                </span>
              </div>
              <p class="text-xs text-slate-400 mt-0.5">{{ pkg.category?.name }}</p>
            </div>
            <!-- enrollment avatars for this package -->
            <div class="flex items-center -space-x-2 flex-shrink-0">
              <template v-for="(e, i) in enrollmentsForPackage(pkg.id).slice(0, 5)" :key="e.id">
                <img :src="e.user.profile_photo_url" :alt="e.user.name" :title="e.user.name"
                  class="w-7 h-7 rounded-full object-cover ring-2 ring-white" />
              </template>
              <div v-if="enrollmentsForPackage(pkg.id).length > 5"
                class="w-7 h-7 rounded-full bg-slate-200 ring-2 ring-white flex items-center justify-center text-xs font-bold text-slate-600">
                +{{ enrollmentsForPackage(pkg.id).length - 5 }}
              </div>
            </div>
            <div class="text-right flex-shrink-0 min-w-[70px]">
              <div class="text-sm font-bold text-blue-600">{{ pkg.currency }} {{ pkg.price }}</div>
              <button @click="filterPackageId = filterPackageId === pkg.id ? null : pkg.id"
                class="text-xs text-slate-400 hover:text-blue-500 transition-colors">
                {{ enrollmentsForPackage(pkg.id).length }} student{{ enrollmentsForPackage(pkg.id).length !== 1 ? 's' : '' }}
              </button>
            </div>
            <Link :href="`/mentor/packages/${pkg.id}/edit`"
              class="text-xs px-2.5 py-1 border border-slate-200 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors flex-shrink-0">
              Edit
            </Link>
          </div>
        </div>

        <div v-else class="text-center py-12 text-slate-400">
          <div class="text-4xl mb-3">📦</div>
          <p class="text-sm">No packages yet.</p>
          <Link href="/mentor/packages/create" class="mt-3 inline-block text-sm text-blue-500 font-medium hover:underline">
            Create your first package →
          </Link>
        </div>
      </div>

      <!-- ── All Students ── -->
      <div class="bg-white rounded-xl border border-slate-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 flex-wrap gap-3">
          <div class="flex items-center gap-3">
            <h2 class="text-base font-bold text-slate-900">Enrolled Students</h2>
            <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-2 py-0.5 rounded-full">
              {{ filteredEnrollments.length }}
            </span>
          </div>
          <div class="flex items-center gap-3">
            <!-- Package filter -->
            <select v-model="filterPackageId"
              class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 text-slate-700 focus:outline-none focus:border-blue-400 bg-white">
              <option :value="null">All Packages</option>
              <option v-for="pkg in packages" :key="pkg.id" :value="pkg.id">{{ pkg.title }}</option>
            </select>
            <!-- Status filter -->
            <select v-model="filterStatus"
              class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 text-slate-700 focus:outline-none focus:border-blue-400 bg-white">
              <option value="">All Statuses</option>
              <option value="active">Active</option>
              <option value="completed">Completed</option>
              <option value="pending">Pending</option>
            </select>
          </div>
        </div>

        <!-- Table -->
        <div v-if="filteredEnrollments.length > 0" class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Student</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Package</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Amount</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Enrolled On</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="e in filteredEnrollments" :key="e.id"
                class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-3.5">
                  <div class="flex items-center gap-3">
                    <img :src="e.user.profile_photo_url" :alt="e.user.name"
                      class="w-8 h-8 rounded-full object-cover flex-shrink-0" />
                    <div class="min-w-0">
                      <div class="font-medium text-slate-900 truncate">{{ e.user.name }}</div>
                      <div class="text-xs text-slate-400 truncate">{{ e.user.email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3.5">
                  <span class="text-slate-700 truncate max-w-[200px] block">{{ e.package.title }}</span>
                </td>
                <td class="px-4 py-3.5">
                  <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full"
                    :class="{
                      'bg-green-100 text-green-700': e.status === 'active',
                      'bg-blue-100 text-blue-700': e.status === 'completed',
                      'bg-amber-100 text-amber-700': e.status === 'pending',
                      'bg-slate-100 text-slate-600': !['active','completed','pending'].includes(e.status),
                    }">
                    <span class="w-1.5 h-1.5 rounded-full"
                      :class="{
                        'bg-green-500': e.status === 'active',
                        'bg-blue-500': e.status === 'completed',
                        'bg-amber-500': e.status === 'pending',
                        'bg-slate-400': !['active','completed','pending'].includes(e.status),
                      }"></span>
                    {{ e.status.charAt(0).toUpperCase() + e.status.slice(1) }}
                  </span>
                </td>
                <td class="px-4 py-3.5 font-medium text-slate-700">
                  {{ e.currency }} {{ e.amount_paid }}
                </td>
                <td class="px-4 py-3.5 text-slate-500">{{ e.enrolled_at }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-else class="text-center py-14 text-slate-400">
          <div class="text-4xl mb-3">👥</div>
          <p class="text-sm font-medium text-slate-500">No students found</p>
          <p v-if="filterPackageId || filterStatus" class="text-xs text-slate-400 mt-1">Try clearing the filters</p>
          <p v-else class="text-xs text-slate-400 mt-1">Students will appear here once they enroll</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  packages: Array,
  recentEnrollments: Array,
  stats: Object,
});

const filterPackageId = ref(null);
const filterStatus    = ref('');

function enrollmentsForPackage(pkgId) {
  return props.recentEnrollments.filter(e => e.package.id === pkgId);
}

const filteredEnrollments = computed(() => {
  return props.recentEnrollments.filter(e => {
    if (filterPackageId.value && e.package.id !== filterPackageId.value) return false;
    if (filterStatus.value && e.status !== filterStatus.value) return false;
    return true;
  });
});
</script>
