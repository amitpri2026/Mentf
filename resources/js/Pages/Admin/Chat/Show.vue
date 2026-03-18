<template>
  <AdminLayout>
    <div class="max-w-3xl mx-auto">
      <!-- Header -->
      <div class="flex items-center gap-4 mb-6">
        <Link href="/admin/chat" class="text-slate-400 hover:text-slate-700">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </Link>
        <div class="flex items-center gap-3">
          <div class="flex -space-x-2">
            <img :src="conversation.mentor.profile_photo_url" class="w-9 h-9 rounded-full object-cover ring-2 ring-white" />
            <img :src="conversation.mentee.profile_photo_url" class="w-9 h-9 rounded-full object-cover ring-2 ring-white" />
          </div>
          <div>
            <p class="font-semibold text-slate-900">{{ conversation.mentor.name }} ↔ {{ conversation.mentee.name }}</p>
            <p v-if="conversation.package" class="text-xs text-blue-600">{{ conversation.package.title }}</p>
          </div>
        </div>
      </div>

      <!-- Messages (read-only) -->
      <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-4" style="max-height: 70vh; overflow-y: auto">
        <div v-if="messages.length === 0" class="text-center text-slate-400 py-12">No messages yet.</div>
        <div v-for="msg in messages" :key="msg.id" class="flex items-start gap-3">
          <img :src="msg.sender.profile_photo_url" class="w-8 h-8 rounded-full object-cover shrink-0 mt-1" />
          <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
              <span class="text-sm font-semibold text-slate-800">{{ msg.sender.name }}</span>
              <span :class="['text-xs px-2 py-0.5 rounded-full', msg.sender.role === 'mentor' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600']">
                {{ msg.sender.role }}
              </span>
              <span class="text-xs text-slate-400">{{ formatTime(msg.created_at) }}</span>
            </div>
            <p class="text-sm text-slate-700 bg-slate-50 rounded-xl px-4 py-2.5 inline-block">{{ msg.message }}</p>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineProps({ conversation: Object, messages: Array });
function formatTime(d) { return new Date(d).toLocaleString(); }
</script>
