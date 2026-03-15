<template>
  <AppLayout>
    <Head :title="mentor.name" />

    <!-- Cover Photo -->
    <div class="h-48 lg:h-64 bg-gradient-to-br from-indigo-600 to-purple-700 relative overflow-hidden">
      <img v-if="mentor.cover_photo_url" :src="mentor.cover_photo_url" class="w-full h-full object-cover" alt="" />
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Profile header -->
      <div class="relative -mt-16 pb-8">
        <div class="flex flex-col lg:flex-row lg:items-end gap-6">
          <img
            :src="mentor.profile_photo_url"
            :alt="mentor.name"
            class="w-28 h-28 lg:w-36 lg:h-36 rounded-2xl object-cover border-4 border-white shadow-xl"
          />
          <div class="flex-1">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4 justify-between">
              <div>
                <div class="flex items-center gap-3 mb-1">
                  <h1 class="text-2xl lg:text-3xl font-extrabold text-gray-900">{{ mentor.name }}</h1>
                  <span v-if="mentor.is_featured" class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">⭐ Featured</span>
                </div>
                <p class="text-indigo-600 font-semibold text-lg">{{ mentor.title }}</p>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                  <span v-if="mentor.location" class="flex items-center gap-1">
                    📍 {{ mentor.location }}
                  </span>
                  <span v-if="mentor.years_experience" class="flex items-center gap-1">
                    💼 {{ mentor.years_experience }} years experience
                  </span>
                </div>
              </div>
              <div class="flex flex-col items-start lg:items-end gap-2">
                <div class="flex items-center gap-2">
                  <StarRating :rating="mentor.avg_rating" show-value />
                  <span class="text-sm text-gray-500">({{ mentor.total_reviews }} reviews)</span>
                </div>
                <div class="text-sm text-gray-600">👥 {{ mentor.total_students }} students mentored</div>
                <div class="text-xl font-bold text-gray-900">₹{{ mentor.hourly_rate }}<span class="text-sm font-normal text-gray-500">/hr</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-16">
        <!-- Left column - Main info -->
        <div class="lg:col-span-2 space-y-8">

          <!-- About -->
          <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">About</h2>
            <p class="text-gray-700 leading-relaxed">{{ mentor.bio }}</p>
          </div>

          <!-- Skills -->
          <div v-if="mentor.skills?.length" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Skills & Expertise</h2>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="skill in mentor.skills"
                :key="skill"
                class="bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg text-sm font-medium"
              >
                {{ skill }}
              </span>
            </div>
          </div>

          <!-- Experience -->
          <div v-if="mentor.professionals?.length" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-5">Experience</h2>
            <div class="space-y-5">
              <div v-for="exp in mentor.professionals" :key="exp.id" class="flex gap-4">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                  <span class="text-lg">💼</span>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">{{ exp.position }}</h4>
                  <p class="text-indigo-600 text-sm font-medium">{{ exp.company }}</p>
                  <p class="text-xs text-gray-500 mt-0.5">
                    {{ exp.start_date }} — {{ exp.is_current ? 'Present' : exp.end_date }}
                    <span v-if="exp.location"> · {{ exp.location }}</span>
                  </p>
                  <p v-if="exp.description" class="text-sm text-gray-600 mt-2">{{ exp.description }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Education -->
          <div v-if="mentor.education?.length" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-5">Education</h2>
            <div class="space-y-5">
              <div v-for="edu in mentor.education" :key="edu.id" class="flex gap-4">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                  <span class="text-lg">🎓</span>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">{{ edu.institution }}</h4>
                  <p class="text-sm text-gray-700">{{ edu.degree }}{{ edu.field_of_study ? ' · ' + edu.field_of_study : '' }}</p>
                  <p class="text-xs text-gray-500 mt-0.5">{{ edu.start_year }} — {{ edu.is_current ? 'Present' : edu.end_year }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Certificates -->
          <div v-if="mentor.certificates?.length" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-5">Certifications</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div v-for="cert in mentor.certificates" :key="cert.id" class="border border-gray-100 rounded-xl p-4">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <span>🏆</span>
                  </div>
                  <div>
                    <h4 class="font-semibold text-sm text-gray-900">{{ cert.name }}</h4>
                    <p class="text-xs text-gray-600 mt-0.5">{{ cert.issuing_org }}</p>
                    <p v-if="cert.issue_date" class="text-xs text-gray-400 mt-0.5">{{ cert.issue_date }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Reviews -->
          <div v-if="mentor.reviews?.length" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-5">Reviews</h2>
            <div class="space-y-5">
              <div v-for="review in mentor.reviews" :key="review.id" class="border-b border-gray-100 pb-5 last:border-0 last:pb-0">
                <div class="flex items-start gap-3">
                  <img :src="review.user.profile_photo_url" :alt="review.user.name" class="w-9 h-9 rounded-full object-cover" />
                  <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                      <span class="font-semibold text-sm text-gray-900">{{ review.user.name }}</span>
                      <span class="text-xs text-gray-400">{{ review.created_at }}</span>
                    </div>
                    <StarRating :rating="review.rating" class="mb-2" />
                    <p v-if="review.title" class="font-medium text-sm text-gray-800 mb-1">{{ review.title }}</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ review.body }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right column - Packages -->
        <div class="space-y-5">
          <div class="bg-white rounded-2xl border border-gray-100 p-5 sticky top-24">
            <h3 class="font-bold text-gray-900 mb-4">Available Packages</h3>

            <div v-if="mentor.packages?.length" class="space-y-4">
              <Link
                v-for="pkg in mentor.packages"
                :key="pkg.id"
                :href="`/packages/${pkg.slug}`"
                class="block border border-gray-100 rounded-xl p-4 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all"
              >
                <div class="flex justify-between items-start mb-2">
                  <h4 class="font-semibold text-sm text-gray-900 leading-snug flex-1 mr-2">{{ pkg.title }}</h4>
                  <span class="text-indigo-600 font-bold text-sm whitespace-nowrap">₹{{ pkg.price }}</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                  <span>{{ pkg.sessions }} session{{ pkg.sessions !== 1 ? 's' : '' }}</span>
                  <span>•</span>
                  <span>{{ pkg.package_type?.name }}</span>
                </div>
                <div class="flex items-center gap-1 mt-2">
                  <StarRating :rating="pkg.avg_rating" />
                  <span class="text-xs text-gray-500">({{ pkg.total_reviews }})</span>
                </div>
              </Link>
            </div>

            <div v-else class="text-center py-6 text-gray-500 text-sm">
              No packages available yet
            </div>

            <!-- Social links -->
            <div v-if="mentor.linkedin || mentor.twitter" class="mt-5 pt-5 border-t border-gray-100">
              <p class="text-xs font-medium text-gray-500 mb-3 uppercase tracking-wide">Connect</p>
              <div class="flex gap-3">
                <a v-if="mentor.linkedin" :href="mentor.linkedin" target="_blank" class="flex items-center gap-2 text-sm text-blue-700 hover:text-blue-900">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                  LinkedIn
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import StarRating from '@/Components/StarRating.vue';

defineProps({
  mentor: Object,
});
</script>
