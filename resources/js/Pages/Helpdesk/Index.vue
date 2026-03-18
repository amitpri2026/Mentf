<template>
  <div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 px-6 py-4">
      <div class="max-w-4xl mx-auto flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-900">Support Tickets</h1>
        <Link href="/helpdesk/create"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          New Ticket
        </Link>
      </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-6">
      <div v-if="tickets.length === 0" class="text-center py-20 text-slate-400">
        <svg class="w-14 h-14 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
        </svg>
        <p class="font-medium text-slate-700">No support tickets yet</p>
        <p class="text-sm mt-1">Submit a ticket if you need help.</p>
      </div>

      <div v-else class="space-y-3">
        <Link v-for="ticket in tickets" :key="ticket.id" :href="`/helpdesk/${ticket.id}`"
          class="flex items-start gap-4 bg-white rounded-xl border border-slate-200 p-4 hover:border-blue-300 hover:shadow-sm transition">
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-wrap">
              <p class="font-semibold text-slate-900">{{ ticket.subject }}</p>
              <span :class="statusBadge(ticket.status)">{{ ticket.status.replace('_', ' ') }}</span>
              <span :class="priorityBadge(ticket.priority)">{{ ticket.priority }}</span>
            </div>
            <p class="text-xs text-slate-400 mt-1">{{ ticket.replies_count }} replies · {{ formatDate(ticket.created_at) }}</p>
          </div>
          <svg class="w-5 h-5 text-slate-300 shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({ tickets: Array });
function statusBadge(s) {
  const m = { open: 'bg-blue-100 text-blue-700', in_progress: 'bg-yellow-100 text-yellow-700', resolved: 'bg-green-100 text-green-700', closed: 'bg-slate-100 text-slate-600' };
  return `text-xs px-2 py-0.5 rounded-full font-medium ${m[s] || m.open}`;
}
function priorityBadge(p) {
  const m = { low: 'bg-slate-100 text-slate-600', medium: 'bg-blue-100 text-blue-700', high: 'bg-orange-100 text-orange-700', urgent: 'bg-red-100 text-red-700' };
  return `text-xs px-2 py-0.5 rounded-full font-medium ${m[p] || m.medium}`;
}
function formatDate(d) { return new Date(d).toLocaleDateString(); }
</script>
