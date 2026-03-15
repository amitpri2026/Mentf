<template>
  <AppLayout>
    <Head title="Browse Packages" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Learning Packages</h1>
        <p class="text-gray-600 mt-1">{{ packages.total }} packages from expert mentors</p>
      </div>

      <div class="flex gap-8">
        <!-- Filters -->
        <aside class="w-64 flex-shrink-0 hidden lg:block">
          <div class="bg-white rounded-2xl border border-gray-100 p-5 sticky top-24">
            <h3 class="font-bold text-gray-900 mb-4">Filters</h3>

            <div class="space-y-5">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input v-model="localFilters.search" type="text" placeholder="Package name..." class="input-field text-sm" @input="debouncedSearch" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select v-model="localFilters.category" @change="applyFilters" class="input-field text-sm">
                  <option value="">All Categories</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.slug">{{ cat.name }}</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Package Type</label>
                <select v-model="localFilters.type" @change="applyFilters" class="input-field text-sm">
                  <option value="">All Types</option>
                  <option v-for="type in packageTypes" :key="type.id" :value="type.slug">{{ type.name }}</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Level</label>
                <select v-model="localFilters.level" @change="applyFilters" class="input-field text-sm">
                  <option value="">All Levels</option>
                  <option value="beginner">Beginner</option>
                  <option value="intermediate">Intermediate</option>
                  <option value="advanced">Advanced</option>
                  <option value="all">All Levels</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Max Price ($)</label>
                <input v-model="localFilters.max_price" type="number" min="0" placeholder="e.g. 500" class="input-field text-sm" @change="applyFilters" />
              </div>

              <button @click="clearFilters" class="w-full text-sm text-indigo-600 font-medium py-2 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-colors">
                Clear Filters
              </button>
            </div>
          </div>
        </aside>

        <!-- Grid -->
        <div class="flex-1 min-w-0">
          <div class="flex items-center justify-between mb-5">
            <p class="text-sm text-gray-600">{{ packages.total }} results</p>
            <select v-model="localFilters.sort" @change="applyFilters" class="text-sm border border-gray-300 rounded-lg px-3 py-2">
              <option value="popular">Most Popular</option>
              <option value="rating">Top Rated</option>
              <option value="newest">Newest</option>
              <option value="price_low">Price: Low to High</option>
              <option value="price_high">Price: High to Low</option>
            </select>
          </div>

          <div v-if="packages.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
            <PackageCard v-for="pkg in packages.data" :key="pkg.id" :package="pkg" />
          </div>

          <div v-else class="text-center py-20 bg-white rounded-2xl border border-gray-100">
            <div class="text-5xl mb-4">📦</div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No packages found</h3>
            <p class="text-gray-500 text-sm">Try adjusting your filters</p>
          </div>

          <!-- Pagination -->
          <div v-if="packages.last_page > 1" class="mt-8 flex items-center justify-between">
            <p class="text-sm text-gray-500">
              Page <span class="font-semibold text-gray-900">{{ packages.current_page }}</span> of <span class="font-semibold text-gray-900">{{ packages.last_page }}</span>
            </p>
            <div class="flex gap-2">
              <button
                @click="goToPage(packages.current_page - 1)"
                :disabled="packages.current_page === 1"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg border transition-colors"
                :class="packages.current_page === 1
                  ? 'border-gray-200 text-gray-300 cursor-not-allowed bg-white'
                  : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50'"
              >
                ← Prev
              </button>
              <button
                @click="goToPage(packages.current_page + 1)"
                :disabled="packages.current_page === packages.last_page"
                class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg border transition-colors"
                :class="packages.current_page === packages.last_page
                  ? 'border-gray-200 text-gray-300 cursor-not-allowed bg-white'
                  : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50'"
              >
                Next →
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PackageCard from '@/Components/PackageCard.vue';

const props = defineProps({
  packages: Object,
  categories: Array,
  packageTypes: Array,
  filters: Object,
});

const localFilters = reactive({
  search: props.filters?.search || '',
  category: props.filters?.category || '',
  type: props.filters?.type || '',
  level: props.filters?.level || '',
  min_price: props.filters?.min_price || '',
  max_price: props.filters?.max_price || '',
  sort: props.filters?.sort || 'popular',
});

let searchTimeout = null;
function debouncedSearch() {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => applyFilters(), 400);
}

function applyFilters() {
  const params = {};
  Object.entries(localFilters).forEach(([k, v]) => { if (v) params[k] = v; });
  router.get('/packages', params, { preserveState: true, preserveScroll: true });
}

function clearFilters() {
  Object.keys(localFilters).forEach(k => { localFilters[k] = k === 'sort' ? 'popular' : ''; });
  router.get('/packages');
}

function goToPage(page) {
  router.get('/packages', { ...localFilters, page }, { preserveScroll: true });
}
</script>
