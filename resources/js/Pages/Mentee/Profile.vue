<template>
  <AppLayout>
    <div class="max-w-4xl mx-auto px-4 py-8">

      <!-- Back -->
      <Link href="/dashboard/mentor" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Dashboard
      </Link>

      <!-- Cover + Avatar -->
      <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-5">
        <div class="h-32 bg-gradient-to-r from-blue-400 to-indigo-500 relative">
          <img v-if="mentee.cover_photo_url" :src="mentee.cover_photo_url" class="w-full h-full object-cover" />
        </div>
        <div class="px-6 pb-6">
          <div class="flex items-end justify-between -mt-10 mb-4">
            <img :src="mentee.profile_photo_url" :alt="mentee.name"
              class="w-20 h-20 rounded-full object-cover ring-4 ring-white shadow" />
            <!-- Chat button -->
            <div class="flex gap-2 mb-1">
              <Link v-if="conversation_id" :href="`/chat/${conversation_id}`"
                class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Chat
              </Link>
              <button v-else @click="startChat"
                class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Start Chat
              </button>
            </div>
          </div>

          <h1 class="text-xl font-bold text-slate-900">{{ mentee.name }}</h1>
          <p v-if="mentee.title" class="text-slate-500 text-sm mt-0.5">{{ mentee.title }}</p>

          <div class="flex items-center gap-4 mt-3 text-sm text-slate-500 flex-wrap">
            <span v-if="mentee.location" class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              {{ mentee.location }}
            </span>
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              {{ mentee.email }}
            </span>
          </div>

          <p v-if="mentee.bio" class="mt-4 text-slate-700 text-sm leading-relaxed">{{ mentee.bio }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Enrollments -->
        <div class="md:col-span-2 space-y-5">
          <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <h2 class="font-bold text-slate-900 mb-4">Enrolled Packages</h2>
            <div v-if="enrollments.length === 0" class="text-sm text-slate-400 py-4 text-center">No enrollments yet.</div>
            <div v-else class="space-y-2">
              <div v-for="e in enrollments" :key="e.id"
                class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <div>
                  <p class="text-sm font-medium text-slate-800">{{ e.package.title }}</p>
                  <p class="text-xs text-slate-400">Enrolled {{ e.enrolled_at }}</p>
                </div>
                <span :class="statusBadge(e.status)">{{ e.status }}</span>
              </div>
            </div>
          </div>

          <!-- Education -->
          <div v-if="mentee.education?.length" class="bg-white rounded-2xl border border-slate-200 p-5">
            <h2 class="font-bold text-slate-900 mb-4">Education</h2>
            <div class="space-y-3">
              <div v-for="edu in mentee.education" :key="edu.id" class="flex gap-3">
                <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center shrink-0 text-base">🎓</div>
                <div>
                  <p class="text-sm font-semibold text-slate-800">{{ edu.degree }} in {{ edu.field_of_study }}</p>
                  <p class="text-xs text-slate-500">{{ edu.institution }} · {{ edu.start_year }}–{{ edu.end_year || 'Present' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-5">
          <!-- Skills -->
          <div v-if="mentee.skills?.length" class="bg-white rounded-2xl border border-slate-200 p-5">
            <h2 class="font-bold text-slate-900 mb-3">Skills</h2>
            <div class="flex flex-wrap gap-2">
              <span v-for="skill in mentee.skills" :key="skill.id"
                class="text-xs bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full font-medium">
                {{ skill.name }}
              </span>
            </div>
          </div>

          <!-- Achievements -->
          <div v-if="mentee.achievements?.length" class="bg-white rounded-2xl border border-slate-200 p-5">
            <h2 class="font-bold text-slate-900 mb-3">Achievements</h2>
            <div class="space-y-2">
              <div v-for="ach in mentee.achievements" :key="ach.id" class="flex gap-2 items-start">
                <span class="text-base mt-0.5">🏆</span>
                <div>
                  <p class="text-sm font-medium text-slate-800">{{ ach.title }}</p>
                  <p v-if="ach.issuer" class="text-xs text-slate-400">{{ ach.issuer }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({ mentee: Object, enrollments: Array, conversation_id: Number });

function startChat() {
  router.post('/chat/start', { other_user_id: props.mentee.id });
}

function statusBadge(s) {
  const m = { active: 'bg-green-100 text-green-700', completed: 'bg-blue-100 text-blue-700', pending: 'bg-yellow-100 text-yellow-700' };
  return `text-xs px-2 py-0.5 rounded-full font-medium ${m[s] || 'bg-slate-100 text-slate-600'}`;
}
</script>
