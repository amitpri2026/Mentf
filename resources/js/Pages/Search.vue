<template>
  <AppLayout>
    <Head :title="`Search: ${query}`" />

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <!-- Search bar -->
      <div class="mb-8">
        <form @submit.prevent="doSearch" class="flex gap-3 max-w-2xl">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search mentors, packages, skills..."
            class="input-field flex-1"
          />
          <button type="submit" class="btn-primary px-6">Search</button>
        </form>
        <p v-if="query" class="text-sm text-gray-600 mt-3">
          Results for "<strong>{{ query }}</strong>"
        </p>
      </div>

      <div v-if="query">
        <!-- Mentors -->
        <div v-if="mentors.length > 0" class="mb-10">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Mentors ({{ mentors.length }})</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <Link
              v-for="mentor in mentors"
              :key="mentor.id"
              :href="`/mentors/${mentor.slug}`"
              class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition-all"
            >
              <img :src="mentor.profile_photo_url" :alt="mentor.name" class="w-12 h-12 rounded-xl object-cover" />
              <div>
                <h4 class="font-semibold text-gray-900 text-sm">{{ mentor.name }}</h4>
                <p class="text-xs text-indigo-600">{{ mentor.title }}</p>
                <div class="flex items-center gap-1 mt-0.5">
                  <span class="text-amber-400 text-xs">★</span>
                  <span class="text-xs text-gray-600">{{ mentor.avg_rating?.toFixed(1) }}</span>
                </div>
              </div>
            </Link>
          </div>
        </div>

        <!-- Packages -->
        <div v-if="packages.length > 0">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Packages ({{ packages.length }})</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <Link
              v-for="pkg in packages"
              :key="pkg.id"
              :href="`/packages/${pkg.slug}`"
              class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition-all"
            >
              <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                <span class="text-xl">📦</span>
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-gray-900 text-sm truncate">{{ pkg.title }}</h4>
                <p class="text-xs text-gray-500">{{ pkg.mentor?.name }} · {{ pkg.category?.name }}</p>
              </div>
              <span class="text-indigo-600 font-bold text-sm flex-shrink-0">₹{{ pkg.price }}</span>
            </Link>
          </div>
        </div>

        <!-- No results -->
        <div v-if="mentors.length === 0 && packages.length === 0" class="text-center py-20">
          <div class="text-5xl mb-4">🔍</div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">No results found</h3>
          <p class="text-gray-600">Try different keywords or <Link href="/mentors" class="text-indigo-600 font-medium">browse all mentors</Link></p>
        </div>
      </div>

      <div v-else class="text-center py-20 text-gray-500">
        <div class="text-5xl mb-4">🔍</div>
        <p>Start typing to search for mentors and packages</p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  query: String,
  mentors: Array,
  packages: Array,
});

const searchQuery = ref(props.query || '');

function doSearch() {
  if (searchQuery.value.trim()) {
    router.get('/search', { q: searchQuery.value });
  }
}
</script>
