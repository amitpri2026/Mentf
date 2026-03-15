<template>
  <Link :href="`/mentors/${mentor.slug}`" class="card group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 block">
    <!-- Top accent bar -->
    <div class="h-1.5 bg-gradient-to-r from-blue-500 to-blue-400"></div>

    <div class="p-5">
      <!-- Header row -->
      <div class="flex items-start justify-between mb-3">
        <div class="flex items-center gap-3">
          <img
            :src="mentor.profile_photo_url"
            :alt="mentor.name"
            class="w-12 h-12 rounded-xl object-cover ring-2 ring-slate-100"
          />
          <div>
            <h3 class="font-semibold text-slate-900 text-sm leading-tight">{{ mentor.name }}</h3>
            <p class="text-xs text-blue-600 font-medium mt-0.5">{{ mentor.title || 'Expert Mentor' }}</p>
          </div>
        </div>
        <span v-if="mentor.is_featured" class="text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200 px-2 py-0.5 rounded-full shrink-0">
          Featured
        </span>
      </div>

      <!-- Location -->
      <p v-if="mentor.location" class="text-xs text-slate-500 flex items-center gap-1 mb-3">
        <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        {{ mentor.location }}
      </p>

      <!-- Skills -->
      <div class="flex flex-wrap gap-1.5 mb-4">
        <span
          v-for="skill in mentor.skills?.slice(0, 3)"
          :key="skill"
          class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md font-medium"
        >
          {{ skill }}
        </span>
        <span v-if="mentor.skills?.length > 3" class="text-xs text-slate-400 px-1 py-0.5">
          +{{ mentor.skills.length - 3 }} more
        </span>
      </div>

      <!-- Stats footer -->
      <div class="flex items-center justify-between pt-3 border-t border-slate-100">
        <div class="flex items-center gap-1">
          <svg class="w-3.5 h-3.5 text-amber-400 fill-amber-400" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
          </svg>
          <span class="text-sm font-bold text-slate-800">{{ mentor.avg_rating?.toFixed(1) || '0.0' }}</span>
          <span class="text-xs text-slate-400">({{ mentor.total_reviews }})</span>
        </div>
        <div class="text-right">
          <span class="text-sm font-bold text-slate-900">${{ mentor.hourly_rate }}</span>
          <span class="text-xs text-slate-400">/hr</span>
        </div>
      </div>
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ mentor: Object });
</script>
