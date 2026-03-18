<template>
  <AdminLayout>
    <div class="max-w-3xl mx-auto">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-slate-900">Notifications</h2>
        <button @click="markAllRead" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
          Mark all as read
        </button>
      </div>

      <div v-if="notifications.data.length === 0" class="text-center py-16 text-slate-500">
        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        No notifications yet.
      </div>

      <div v-else class="space-y-2">
        <div v-for="notif in notifications.data" :key="notif.id"
          :class="['bg-white rounded-xl border p-4 flex items-start gap-4 transition', notif.read_at ? 'border-slate-100 opacity-70' : 'border-blue-200 bg-blue-50/30']">
          <div :class="['w-9 h-9 rounded-full flex items-center justify-center shrink-0', typeColor(notif.type)]">
            <span class="text-sm">{{ typeIcon(notif.type) }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-800">{{ notif.title }}</p>
            <p class="text-sm text-slate-600 mt-0.5">{{ notif.message }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ formatDate(notif.created_at) }}</p>
          </div>
          <div class="flex items-center gap-2 shrink-0">
            <span v-if="!notif.read_at" class="w-2 h-2 rounded-full bg-blue-500"></span>
            <button @click="deleteNotif(notif.id)" class="text-slate-300 hover:text-red-500 transition">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="notifications.last_page > 1" class="mt-6 flex justify-center gap-2">
        <Link v-for="link in notifications.links" :key="link.label"
          :href="link.url || ''"
          :class="['px-3 py-1.5 text-sm rounded-lg border', link.active ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600 hover:bg-slate-50', !link.url ? 'opacity-40 cursor-default' : '']"
          v-html="link.label" />
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ notifications: Object });

function typeColor(type) {
  const map = { registration: 'bg-green-100 text-green-600', package: 'bg-blue-100 text-blue-600', enrollment: 'bg-purple-100 text-purple-600', helpdesk: 'bg-orange-100 text-orange-600' };
  return map[type] || 'bg-slate-100 text-slate-600';
}
function typeIcon(type) {
  const map = { registration: '👤', package: '📦', enrollment: '✅', helpdesk: '🎫' };
  return map[type] || '🔔';
}
function formatDate(d) {
  return new Date(d).toLocaleString();
}
function markAllRead() {
  router.post('/admin/notifications/mark-all-read');
}
function deleteNotif(id) {
  router.delete(`/admin/notifications/${id}`, { preserveScroll: true });
}
</script>
