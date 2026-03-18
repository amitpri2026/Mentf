<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto">
      <h2 class="text-lg font-semibold text-slate-900 mb-6">All Conversations</h2>

      <div v-if="conversations.data.length === 0" class="text-center py-16 text-slate-400">
        No conversations yet.
      </div>

      <div v-else class="space-y-3">
        <Link v-for="conv in conversations.data" :key="conv.id" :href="`/admin/chat/${conv.id}`"
          class="flex items-center gap-4 bg-white rounded-xl border border-slate-200 p-4 hover:border-blue-300 hover:shadow-sm transition">
          <div class="flex -space-x-2 shrink-0">
            <img :src="conv.mentor?.profile_photo_url" class="w-9 h-9 rounded-full object-cover ring-2 ring-white" />
            <img :src="conv.mentee?.profile_photo_url" class="w-9 h-9 rounded-full object-cover ring-2 ring-white" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="font-semibold text-slate-900 text-sm">{{ conv.mentor?.name }} ↔ {{ conv.mentee?.name }}</p>
            <p v-if="conv.package" class="text-xs text-blue-600">{{ conv.package?.title }}</p>
            <p class="text-xs text-slate-400">{{ conv.messages_count }} messages</p>
          </div>
          <span class="text-xs text-slate-400">{{ conv.last_message_at ? formatDate(conv.last_message_at) : '' }}</span>
        </Link>
      </div>

      <!-- Pagination -->
      <div v-if="conversations.last_page > 1" class="mt-6 flex justify-center gap-2">
        <Link v-for="link in conversations.links" :key="link.label" :href="link.url || ''"
          :class="['px-3 py-1.5 text-sm rounded-lg border', link.active ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600']"
          v-html="link.label" />
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineProps({ conversations: Object });
function formatDate(d) { return new Date(d).toLocaleDateString(); }
</script>
