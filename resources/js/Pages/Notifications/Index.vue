<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto px-4 py-10">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-slate-900">Notifications</h1>
        <button v-if="notifications.data.length > 0" @click="markAllRead"
          class="text-sm text-blue-600 hover:text-blue-800 font-medium">
          Mark all as read
        </button>
      </div>

      <div v-if="notifications.data.length === 0" class="text-center py-20 text-slate-400">
        <svg class="w-14 h-14 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <p class="font-medium text-slate-700">No notifications yet</p>
      </div>

      <div class="space-y-2">
        <div v-for="notif in notifications.data" :key="notif.id"
          :class="['rounded-xl border p-4 flex items-start gap-4 transition', notif.read_at ? 'bg-white border-slate-100' : 'bg-blue-50/40 border-blue-200']">
          <!-- Icon -->
          <div :class="['w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-lg', typeColor(notif.type)]">
            {{ typeIcon(notif.type) }}
          </div>
          <!-- Content -->
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-800">{{ notif.title }}</p>
            <p class="text-sm text-slate-600 mt-0.5">{{ notif.message }}</p>
            <div class="flex items-center gap-3 mt-1.5">
              <p class="text-xs text-slate-400">{{ formatDate(notif.created_at) }}</p>
              <Link v-if="notif.action_url" :href="notif.action_url"
                class="text-xs text-blue-600 font-medium hover:underline">
                View →
              </Link>
            </div>
          </div>
          <!-- Unread dot + delete -->
          <div class="flex items-center gap-2 shrink-0">
            <span v-if="!notif.read_at" class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
            <button @click="deleteNotif(notif.id)" class="text-slate-300 hover:text-red-400 transition p-1">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="notifications.last_page > 1" class="mt-6 flex justify-center gap-2">
        <Link v-for="link in notifications.links" :key="link.label" :href="link.url || ''"
          :class="['px-3 py-1.5 text-sm rounded-lg border', link.active ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600 hover:bg-slate-50', !link.url ? 'opacity-40 pointer-events-none' : '']"
          v-html="link.label" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ notifications: Object });

function typeColor(type) {
  const m = { enrollment: 'bg-green-100 text-green-600', chat: 'bg-blue-100 text-blue-600', system: 'bg-slate-100 text-slate-600' };
  return m[type] || 'bg-purple-100 text-purple-600';
}
function typeIcon(type) {
  const m = { enrollment: '🎓', chat: '💬', system: '🔔' };
  return m[type] || '🔔';
}
function formatDate(d) {
  const date = new Date(d);
  const now = new Date();
  const diff = Math.floor((now - date) / 1000);
  if (diff < 60) return 'Just now';
  if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
  if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`;
  return date.toLocaleDateString();
}
function markAllRead() {
  router.post('/notifications/mark-all-read');
}
function deleteNotif(id) {
  router.delete(`/notifications/${id}`, { preserveScroll: true });
}
</script>
