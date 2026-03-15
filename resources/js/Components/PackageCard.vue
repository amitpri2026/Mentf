<template>
  <Link :href="`/packages/${pkg.slug}`" class="card group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 block">
    <!-- Thumbnail / Header -->
    <div class="h-36 bg-slate-100 relative overflow-hidden">
      <img v-if="pkg.thumbnail_url" :src="pkg.thumbnail_url" :alt="pkg.title" class="w-full h-full object-cover" />
      <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100">
        <svg class="w-12 h-12 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
      </div>

      <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between">
        <span class="bg-white/95 text-slate-700 text-xs font-medium px-2.5 py-1 rounded-md shadow-sm">
          {{ pkg.package_type?.name || 'Program' }}
        </span>
        <span v-if="pkg.is_featured" class="bg-amber-400 text-amber-900 text-xs font-bold px-2 py-0.5 rounded-md">
          Featured
        </span>
      </div>
    </div>

    <div class="p-5">
      <!-- Category badge -->
      <span class="inline-flex items-center text-xs font-medium text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-md mb-2.5">
        {{ pkg.category?.name }}
      </span>

      <h3 class="font-semibold text-slate-900 text-sm leading-snug mb-3 line-clamp-2">{{ pkg.title }}</h3>

      <!-- Mentor -->
      <div class="flex items-center gap-2 mb-3">
        <img :src="pkg.mentor?.profile_photo_url" :alt="pkg.mentor?.name"
          class="w-5 h-5 rounded-full object-cover ring-1 ring-slate-200" />
        <span class="text-xs text-slate-500 font-medium">{{ pkg.mentor?.name }}</span>
      </div>

      <!-- Meta row -->
      <div class="flex items-center gap-3 text-xs text-slate-400 mb-4">
        <span class="flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          {{ pkg.sessions }} sessions
        </span>
        <span>·</span>
        <span>{{ pkg.total_enrollments }} enrolled</span>
        <span>·</span>
        <span class="capitalize">{{ pkg.level }}</span>
      </div>

      <!-- Rating & Price -->
      <div class="flex items-center justify-between pt-3 border-t border-slate-100">
        <div class="flex items-center gap-1">
          <svg class="w-3.5 h-3.5 text-amber-400 fill-amber-400" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
          </svg>
          <span class="text-sm font-bold text-slate-800">{{ pkg.avg_rating?.toFixed(1) || '0.0' }}</span>
          <span class="text-xs text-slate-400">({{ pkg.total_reviews }})</span>
        </div>
        <span class="text-lg font-bold text-blue-600">₹{{ pkg.price }}</span>
      </div>
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({ package: { type: Object, required: true } });
const pkg = props.package;
</script>
