<template>
  <AppLayout>
    <Head :title="pkg.title" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

          <!-- Header -->
          <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-700 relative">
              <img v-if="pkg.banner_url || pkg.thumbnail_url"
                :src="pkg.banner_url || pkg.thumbnail_url"
                class="w-full h-full object-cover" alt="" />
              <div class="absolute bottom-4 left-4 flex gap-2">
                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-3 py-1 rounded-full border border-white/30">
                  {{ pkg.package_type?.name }}
                </span>
                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-3 py-1 rounded-full border border-white/30 capitalize">
                  {{ pkg.level }} Level
                </span>
              </div>
            </div>
            <div class="p-6">
              <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">{{ pkg.category?.name }}</span>
                <span v-if="pkg.is_featured" class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-md">⭐ Featured</span>
              </div>
              <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ pkg.title }}</h1>
              <div class="flex flex-wrap items-center gap-5 text-sm text-gray-600 mb-4">
                <span class="flex items-center gap-1">
                  <span class="text-amber-400">★</span>
                  <strong>{{ pkg.avg_rating?.toFixed(1) }}</strong>
                  <span>({{ pkg.total_reviews }} reviews)</span>
                </span>
                <span>👥 {{ pkg.total_enrollments }} enrolled</span>
                <span>⏱ {{ pkg.sessions }} session{{ pkg.sessions !== 1 ? 's' : '' }} × {{ pkg.duration }}min</span>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">About this Package</h2>
            <p class="text-gray-700 leading-relaxed">{{ pkg.description }}</p>
          </div>

          <!-- What you'll learn -->
          <div v-if="pkg.outcomes" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">What You'll Learn</h2>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <li v-for="(outcome, i) in pkg.outcomes.split('\n').filter(Boolean)" :key="i" class="flex items-start gap-3">
                <span class="w-5 h-5 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">✓</span>
                <span class="text-sm text-gray-700">{{ outcome }}</span>
              </li>
            </ul>
          </div>

          <!-- Curriculum -->
          <div v-if="pkg.topics?.length" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Curriculum</h2>
            <div class="space-y-3">
              <div
                v-for="(topic, i) in pkg.topics"
                :key="topic.id"
                class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl"
              >
                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm font-bold flex-shrink-0">
                  {{ topic.session_number || i + 1 }}
                </div>
                <div class="flex-1">
                  <h4 class="font-medium text-sm text-gray-900">{{ topic.title }}</h4>
                  <p v-if="topic.description" class="text-xs text-gray-500 mt-0.5">{{ topic.description }}</p>
                </div>
                <span v-if="topic.duration" class="text-xs text-gray-400 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ topic.duration }}min
                </span>
              </div>
            </div>
          </div>

          <!-- Requirements -->
          <div v-if="pkg.requirements" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Requirements</h2>
            <ul class="space-y-2">
              <li v-for="(req, i) in pkg.requirements.split('\n').filter(Boolean)" :key="i" class="flex items-start gap-2 text-sm text-gray-700">
                <span class="text-blue-400 mt-1">•</span>{{ req }}
              </li>
            </ul>
          </div>

          <!-- Reviews -->
          <div v-if="pkg.reviews?.length" class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-5">Student Reviews</h2>
            <div class="space-y-5">
              <div v-for="review in pkg.reviews" :key="review.id" class="border-b border-gray-100 pb-5 last:border-0">
                <div class="flex items-start gap-3">
                  <img :src="review.user.profile_photo_url" :alt="review.user.name" class="w-9 h-9 rounded-full object-cover" />
                  <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                      <span class="font-semibold text-sm">{{ review.user.name }}</span>
                      <span class="text-xs text-gray-400">{{ review.created_at }}</span>
                    </div>
                    <StarRating :rating="review.rating" class="mb-2" />
                    <p class="text-sm text-gray-700">{{ review.body }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar - Enroll card -->
        <div class="space-y-5">
          <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
            <div class="text-4xl font-extrabold text-gray-900 mb-2">₹{{ pkg.price }}</div>
            <p class="text-sm text-gray-500 mb-5">{{ pkg.sessions }} session{{ pkg.sessions !== 1 ? 's' : '' }}, {{ pkg.duration }}min each</p>

            <div v-if="isEnrolled" class="bg-green-50 text-green-700 text-center py-3 px-4 rounded-xl font-semibold mb-4 border border-green-200">
              ✅ Already Enrolled
            </div>

            <template v-else>
              <button
                v-if="$page.props.auth.user"
                @click="enroll"
                :disabled="enrolling"
                class="btn-primary w-full justify-center mb-3 text-base"
              >
                <svg v-if="enrolling" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                {{ enrolling ? 'Enrolling...' : 'Enroll Now' }}
              </button>
              <Link v-else href="/login" class="btn-primary w-full justify-center mb-3 text-base">
                Login to Enroll
              </Link>
            </template>

            <!-- Package details -->
            <div class="space-y-3 pt-4 border-t border-gray-100">
              <div class="flex items-center gap-3 text-sm text-gray-700">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ pkg.sessions }} session{{ pkg.sessions !== 1 ? 's' : '' }} × {{ pkg.duration }} minutes
              </div>
              <div class="flex items-center gap-3 text-sm text-gray-700">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.782 3 18.897" />
                </svg>
                Language: {{ pkg.language?.toUpperCase() }}
              </div>
              <div class="flex items-center gap-3 text-sm text-gray-700">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Level: {{ pkg.level?.charAt(0).toUpperCase() + pkg.level?.slice(1) }}
              </div>
              <div class="flex items-center gap-3 text-sm text-gray-700">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Max {{ pkg.max_students }} students
              </div>
            </div>
          </div>

          <!-- Mentor card -->
          <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-bold text-gray-900 mb-4">Your Mentor</h3>
            <Link :href="`/mentors/${pkg.mentor?.slug}`" class="flex items-start gap-4 hover:bg-gray-50 rounded-xl p-2 -mx-2 transition-colors">
              <img :src="pkg.mentor?.profile_photo_url" :alt="pkg.mentor?.name" class="w-12 h-12 rounded-xl object-cover" />
              <div>
                <h4 class="font-bold text-gray-900 text-sm">{{ pkg.mentor?.name }}</h4>
                <p class="text-xs text-indigo-600">{{ pkg.mentor?.title }}</p>
                <div class="flex items-center gap-1 mt-1">
                  <span class="text-amber-400 text-xs">★</span>
                  <span class="text-xs font-medium text-gray-700">{{ pkg.mentor?.avg_rating?.toFixed(1) }}</span>
                  <span class="text-xs text-gray-500">({{ pkg.mentor?.total_reviews }})</span>
                </div>
              </div>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import StarRating from '@/Components/StarRating.vue';

const props = defineProps({
  package: Object,
  isEnrolled: Boolean,
});

const pkg = props.package;
const enrolling = ref(false);

function enroll() {
  enrolling.value = true;
  router.post(`/packages/${pkg.id}/enroll`, {}, {
    onFinish: () => { enrolling.value = false; },
  });
}
</script>
