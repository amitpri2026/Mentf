<template>
  <AppLayout>
    <Head title="My Packages" />

    <!-- Admin context banner -->
    <div v-if="adminUser" class="bg-amber-50 border-b border-amber-200">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 flex items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-sm">
          <span class="text-amber-600 font-semibold">Admin Mode</span>
          <span class="text-amber-500">·</span>
          <span class="text-amber-700">Managing packages for <strong>{{ adminUser.name }}</strong> ({{ adminUser.email }})</span>
        </div>
        <Link href="/admin/users" class="text-xs text-amber-700 hover:text-amber-900 font-medium border border-amber-300 rounded-lg px-3 py-1 hover:bg-amber-100 transition-colors">
          ← Back to Users
        </Link>
      </div>
    </div>

    <div class="bg-white border-b border-slate-200">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
        <div>
          <h1 class="text-xl font-bold text-slate-900">{{ adminUser ? `${adminUser.name}'s Packages` : 'My Packages' }}</h1>
          <p class="text-sm text-slate-500 mt-0.5">Manage mentorship offerings</p>
        </div>
        <Link :href="base + '/create'" class="btn-primary">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          New Package
        </Link>
      </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Empty state -->
      <div v-if="packages.length === 0" class="text-center py-20 bg-white rounded-xl border border-slate-200">
        <div class="text-5xl mb-4">📦</div>
        <h3 class="text-lg font-semibold text-slate-900 mb-2">No packages yet</h3>
        <p class="text-slate-500 text-sm mb-6">Create the first mentorship package</p>
        <Link :href="base + '/create'" class="btn-primary">Create First Package</Link>
      </div>

      <!-- Package list -->
      <div v-else class="space-y-4">
        <div v-for="pkg in packages" :key="pkg.id"
          class="bg-white rounded-xl border border-slate-200 overflow-hidden flex">

          <!-- Thumbnail -->
          <div class="w-36 flex-shrink-0 bg-slate-100 relative">
            <img v-if="pkg.thumbnail_url" :src="pkg.thumbnail_url" :alt="pkg.title"
              class="w-full h-full object-cover" />
            <div v-else class="w-full h-full flex items-center justify-center text-3xl text-slate-300">📦</div>
          </div>

          <!-- Content -->
          <div class="flex-1 p-5 flex items-center gap-6">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-1">
                <h3 class="font-semibold text-slate-900 truncate">{{ pkg.title }}</h3>
                <span class="flex-shrink-0 text-xs px-2 py-0.5 rounded-full font-medium"
                  :class="pkg.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'">
                  {{ pkg.is_active ? 'Active' : 'Draft' }}
                </span>
              </div>
              <div class="flex items-center gap-3 text-xs text-slate-500">
                <span>{{ pkg.category?.name }}</span>
                <span>·</span>
                <span>{{ pkg.package_type?.name }}</span>
                <span>·</span>
                <span>{{ pkg.sessions }} sessions</span>
                <span>·</span>
                <span>{{ pkg.topics?.length || 0 }} topics</span>
              </div>
            </div>

            <div class="text-center flex-shrink-0">
              <div class="text-lg font-bold text-blue-600">{{ pkg.currency }} {{ pkg.price }}</div>
              <div class="text-xs text-slate-500">{{ pkg.enrollments_count }} enrolled</div>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
              <Link :href="`${base}/${pkg.id}/edit`"
                class="px-3 py-1.5 text-sm font-medium text-slate-700 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                Edit
              </Link>
              <a :href="`/packages/${pkg.slug}`" target="_blank"
                class="px-3 py-1.5 text-sm font-medium text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                View
              </a>
              <button @click="confirmDelete(pkg)"
                class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete confirmation -->
    <div v-if="deleteTarget" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center px-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-2">Delete Package?</h3>
        <p class="text-slate-500 text-sm mb-6">
          "<span class="font-medium text-slate-700">{{ deleteTarget.title }}</span>" will be permanently deleted along with all its topics.
        </p>
        <div class="flex gap-3">
          <button @click="deleteTarget = null" class="flex-1 btn-secondary">Cancel</button>
          <button @click="doDelete" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-semibold transition-colors">
            Delete
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  packages: Array,
  adminUser: { type: Object, default: null },
});

const base = computed(() =>
  props.adminUser ? `/admin/mentors/${props.adminUser.id}/packages` : '/mentor/packages'
);

const deleteTarget = ref(null);
function confirmDelete(pkg) { deleteTarget.value = pkg; }
function doDelete() {
  router.delete(`${base.value}/${deleteTarget.value.id}`, {
    onFinish: () => { deleteTarget.value = null; }
  });
}
</script>
