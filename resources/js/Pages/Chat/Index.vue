<template>
  <div class="min-h-screen bg-slate-50">
    <!-- Header -->
    <div class="bg-white border-b border-slate-200 px-6 py-4">
      <div class="max-w-4xl mx-auto flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-900">Messages</h1>
        <Link href="/dashboard" class="text-sm text-blue-600 hover:text-blue-800">← Back to Dashboard</Link>
      </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-6">
      <div v-if="conversations.length === 0" class="text-center py-20 text-slate-500">
        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <p class="font-medium text-slate-700">No conversations yet</p>
        <p class="text-sm mt-1">Enroll in a package to start chatting with your mentor.</p>
      </div>

      <div v-else class="space-y-3">
        <Link v-for="conv in conversations" :key="conv.id" :href="`/chat/${conv.id}`"
          class="flex items-center gap-4 bg-white rounded-xl border border-slate-200 p-4 hover:border-blue-300 hover:shadow-sm transition">
          <img :src="conv.other_user.profile_photo_url" :alt="conv.other_user.name"
            class="w-12 h-12 rounded-full object-cover ring-2 ring-slate-100 shrink-0" />
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
              <p class="font-semibold text-slate-900">{{ conv.other_user.name }}</p>
              <span class="text-xs text-slate-400">{{ conv.last_message ? formatTime(conv.last_message.created_at) : '' }}</span>
            </div>
            <p v-if="conv.package" class="text-xs text-blue-600 mb-0.5">{{ conv.package.title }}</p>
            <p class="text-sm text-slate-500 truncate">{{ conv.last_message?.message || 'No messages yet' }}</p>
          </div>
          <span v-if="conv.unread_count > 0"
            class="bg-blue-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shrink-0">
            {{ conv.unread_count }}
          </span>
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({ conversations: Array });
function formatTime(d) {
  const date = new Date(d);
  const now = new Date();
  if (date.toDateString() === now.toDateString()) return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  return date.toLocaleDateString();
}
</script>
