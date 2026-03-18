<template>
  <AdminLayout>
    <!-- Stats -->
    <div class="grid grid-cols-4 gap-4 mb-6">
      <div v-for="s in statCards" :key="s.label" class="bg-white rounded-xl border border-slate-200 p-4">
        <p class="text-xs text-slate-500 font-medium">{{ s.label }}</p>
        <p class="text-2xl font-bold mt-1" :class="s.color">{{ s.value }}</p>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-5 flex items-center gap-3 flex-wrap">
      <input v-model="search" @input="doFilter" type="text" placeholder="Search tickets..."
        class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 flex-1 min-w-[200px]" />
      <select v-model="statusFilter" @change="doFilter" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
        <option value="">All Statuses</option>
        <option value="open">Open</option>
        <option value="in_progress">In Progress</option>
        <option value="resolved">Resolved</option>
        <option value="closed">Closed</option>
      </select>
      <select v-model="priorityFilter" @change="doFilter" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
        <option value="">All Priorities</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
        <option value="urgent">Urgent</option>
      </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
          <tr>
            <th class="text-left px-4 py-3 font-semibold text-slate-600">Ticket</th>
            <th class="text-left px-4 py-3 font-semibold text-slate-600">User</th>
            <th class="text-left px-4 py-3 font-semibold text-slate-600">Priority</th>
            <th class="text-left px-4 py-3 font-semibold text-slate-600">Status</th>
            <th class="text-left px-4 py-3 font-semibold text-slate-600">Replies</th>
            <th class="text-left px-4 py-3 font-semibold text-slate-600">Date</th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr v-for="ticket in tickets.data" :key="ticket.id" class="hover:bg-slate-50 transition">
            <td class="px-4 py-3">
              <p class="font-medium text-slate-900 truncate max-w-[200px]">{{ ticket.subject }}</p>
              <p v-if="ticket.category" class="text-xs text-slate-400">{{ ticket.category }}</p>
            </td>
            <td class="px-4 py-3">
              <p class="text-slate-700">{{ ticket.user?.name }}</p>
              <p class="text-xs text-slate-400">{{ ticket.user?.email }}</p>
            </td>
            <td class="px-4 py-3"><span :class="priorityBadge(ticket.priority)">{{ ticket.priority }}</span></td>
            <td class="px-4 py-3"><span :class="statusBadge(ticket.status)">{{ ticket.status.replace('_', ' ') }}</span></td>
            <td class="px-4 py-3 text-slate-500">{{ ticket.replies_count }}</td>
            <td class="px-4 py-3 text-xs text-slate-400">{{ formatDate(ticket.created_at) }}</td>
            <td class="px-4 py-3">
              <Link :href="`/admin/helpdesk/${ticket.id}`" class="text-blue-600 hover:text-blue-800 font-medium text-xs">View</Link>
            </td>
          </tr>
          <tr v-if="tickets.data.length === 0">
            <td colspan="7" class="px-4 py-12 text-center text-slate-400">No tickets found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="tickets.last_page > 1" class="mt-4 flex justify-center gap-2">
      <Link v-for="link in tickets.links" :key="link.label" :href="link.url || ''"
        :class="['px-3 py-1.5 text-sm rounded-lg border', link.active ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600']"
        v-html="link.label" />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ tickets: Object, agents: Array, filters: Object, stats: Object });

const search = ref(props.filters?.search || '');
const statusFilter = ref(props.filters?.status || '');
const priorityFilter = ref(props.filters?.priority || '');

const statCards = [
  { label: 'Total', value: props.stats.total, color: 'text-slate-800' },
  { label: 'Open', value: props.stats.open, color: 'text-blue-600' },
  { label: 'In Progress', value: props.stats.in_progress, color: 'text-yellow-600' },
  { label: 'Resolved', value: props.stats.resolved, color: 'text-green-600' },
];

function doFilter() {
  router.get('/admin/helpdesk', { search: search.value, status: statusFilter.value, priority: priorityFilter.value }, { preserveState: true, replace: true });
}

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
