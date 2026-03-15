<template>
  <AppLayout>
    <Head title="Browse Mentors" />

    <!-- Page header -->
    <div class="bg-white border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Find Your Mentor</h1>
        <p class="text-slate-500 text-sm mt-1">Connect with {{ mentors.total }} expert mentors across 14 categories</p>
      </div>
    </div>

    <div class="bg-slate-50 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-6">

          <!-- Filters Sidebar -->
          <aside class="w-60 flex-shrink-0 hidden lg:block">
            <div class="bg-white rounded-xl border border-slate-200 p-5 sticky top-24">
              <h3 class="font-semibold text-slate-900 text-sm mb-4">Filters</h3>

              <div class="space-y-4">
                <div>
                  <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Search</label>
                  <input v-model="localFilters.search" type="text" placeholder="Name, skill, title..."
                    class="input-field text-sm" @input="debouncedSearch" />
                </div>

                <div>
                  <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Category</label>
                  <select v-model="localFilters.category" @change="applyFilters" class="input-field text-sm">
                    <option value="">All Categories</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.slug">{{ cat.name }}</option>
                  </select>
                </div>

                <div>
                  <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Min Rating</label>
                  <select v-model="localFilters.min_rating" @change="applyFilters" class="input-field text-sm">
                    <option value="">Any Rating</option>
                    <option value="4.5">4.5+ ★</option>
                    <option value="4.0">4.0+ ★</option>
                    <option value="3.5">3.5+ ★</option>
                  </select>
                </div>

                <div>
                  <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Max Rate ($/hr)</label>
                  <input v-model="localFilters.max_rate" type="number" min="0" placeholder="e.g. 200"
                    class="input-field text-sm" @change="applyFilters" />
                </div>
              </div>

              <button @click="clearFilters" class="w-full mt-5 text-xs font-semibold text-blue-600 hover:text-blue-800 py-2 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                Clear All Filters
              </button>
            </div>
          </aside>

          <!-- Main Content -->
          <div class="flex-1 min-w-0">
            <!-- Sort bar -->
            <div class="flex items-center justify-between mb-5">
              <p class="text-sm text-slate-500 font-medium">
                <span class="text-slate-900 font-semibold">{{ mentors.total }}</span> mentors found
              </p>
              <select v-model="localFilters.sort" @change="applyFilters"
                class="text-sm border border-slate-200 bg-white rounded-lg px-3 py-2 text-slate-700 focus:outline-none focus:border-blue-400">
                <option value="featured">Featured First</option>
                <option value="rating">Top Rated</option>
                <option value="reviews">Most Reviews</option>
                <option value="students">Most Students</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
              </select>
            </div>

            <!-- Grid -->
            <div v-if="mentors.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
              <MentorCard v-for="mentor in mentors.data" :key="mentor.id" :mentor="mentor" />
            </div>

            <div v-else class="text-center py-20 bg-white rounded-xl border border-slate-200">
              <div class="text-4xl mb-3">🔍</div>
              <h3 class="text-base font-semibold text-slate-900 mb-1">No mentors found</h3>
              <p class="text-slate-500 text-sm">Try adjusting your filters</p>
            </div>

            <!-- Pagination -->
            <div v-if="mentors.last_page > 1" class="mt-8 flex items-center justify-center gap-1.5">
              <button
                v-for="page in mentors.last_page"
                :key="page"
                @click="goToPage(page)"
                class="w-9 h-9 rounded-lg text-sm font-medium transition-colors"
                :class="page === mentors.current_page
                  ? 'bg-blue-600 text-white shadow-sm'
                  : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'"
              >
                {{ page }}
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
import MentorCard from '@/Components/MentorCard.vue';

const props = defineProps({
  mentors: Object,
  categories: Array,
  filters: Object,
});

const localFilters = reactive({
  search:     props.filters?.search || '',
  category:   props.filters?.category || '',
  min_rating: props.filters?.min_rating || '',
  max_rate:   props.filters?.max_rate || '',
  sort:       props.filters?.sort || 'featured',
});

let searchTimeout = null;
function debouncedSearch() {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => applyFilters(), 400);
}

function applyFilters() {
  const params = {};
  Object.entries(localFilters).forEach(([k, v]) => { if (v) params[k] = v; });
  router.get('/mentors', params, { preserveState: true, preserveScroll: true });
}

function clearFilters() {
  Object.keys(localFilters).forEach(k => { localFilters[k] = k === 'sort' ? 'featured' : ''; });
  router.get('/mentors');
}

function goToPage(page) {
  router.get('/mentors', { ...localFilters, page }, { preserveScroll: true });
}
</script>
