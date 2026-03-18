<template>
  <AdminLayout>
    <div class="max-w-3xl mx-auto">
      <!-- Header -->
      <div class="flex items-start gap-4 mb-6">
        <Link href="/admin/helpdesk" class="text-slate-400 hover:text-slate-700 mt-1">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </Link>
        <div class="flex-1">
          <h2 class="text-lg font-bold text-slate-900">{{ ticket.subject }}</h2>
          <div class="flex items-center gap-2 mt-1 flex-wrap">
            <span :class="statusBadge(ticket.status)">{{ ticket.status.replace('_', ' ') }}</span>
            <span :class="priorityBadge(ticket.priority)">{{ ticket.priority }}</span>
            <span class="text-xs text-slate-400">by {{ ticket.user?.name }} · {{ formatDate(ticket.created_at) }}</span>
          </div>
        </div>
        <!-- Actions -->
        <div class="flex items-center gap-2">
          <select v-model="statusVal" @change="updateTicket" class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs">
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
          </select>
          <select v-model="assignedTo" @change="updateTicket" class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs">
            <option value="">Unassigned</option>
            <option v-for="agent in agents" :key="agent.id" :value="agent.id">{{ agent.name }}</option>
          </select>
        </div>
      </div>

      <!-- Messages -->
      <div class="space-y-4 mb-4">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
          <div class="flex items-center gap-2 mb-3">
            <img :src="ticket.user?.profile_photo_url" class="w-7 h-7 rounded-full object-cover" />
            <p class="text-sm font-semibold text-slate-800">{{ ticket.user?.name }}</p>
            <span class="text-xs text-slate-400">{{ formatDate(ticket.created_at) }}</span>
          </div>
          <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ ticket.message }}</p>
        </div>

        <div v-for="reply in ticket.replies" :key="reply.id"
          :class="['rounded-xl border p-5', reply.is_staff_reply ? 'bg-blue-50 border-blue-200' : 'bg-white border-slate-200']">
          <div class="flex items-center gap-2 mb-3">
            <img :src="reply.user?.profile_photo_url" class="w-7 h-7 rounded-full object-cover" />
            <p class="text-sm font-semibold text-slate-800">{{ reply.user?.name }}</p>
            <span v-if="reply.is_staff_reply" class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded-full">Staff</span>
            <span class="text-xs text-slate-400">{{ formatDate(reply.created_at) }}</span>
          </div>
          <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ reply.message }}</p>
        </div>
      </div>

      <!-- Reply form -->
      <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-semibold text-slate-800 mb-3">Staff Reply</h3>
        <form @submit.prevent="submitReply">
          <textarea v-model="replyForm.message" rows="4" required maxlength="5000"
            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none mb-3"
            placeholder="Type your reply to the user..."></textarea>
          <button type="submit" :disabled="replyForm.processing"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition disabled:opacity-60">
            Send Reply
          </button>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ ticket: Object, agents: Array });
const replyForm = useForm({ message: '' });
const statusVal = ref(props.ticket.status);
const assignedTo = ref(props.ticket.assigned_to || '');

function submitReply() {
  replyForm.post(`/admin/helpdesk/${props.ticket.id}/reply`, { onSuccess: () => replyForm.reset() });
}
function updateTicket() {
  router.patch(`/admin/helpdesk/${props.ticket.id}`, { status: statusVal.value, assigned_to: assignedTo.value || null }, { preserveScroll: true });
}
function statusBadge(s) {
  const m = { open: 'bg-blue-100 text-blue-700', in_progress: 'bg-yellow-100 text-yellow-700', resolved: 'bg-green-100 text-green-700', closed: 'bg-slate-100 text-slate-600' };
  return `text-xs px-2 py-0.5 rounded-full font-medium ${m[s] || m.open}`;
}
function priorityBadge(p) {
  const m = { low: 'bg-slate-100 text-slate-600', medium: 'bg-blue-100 text-blue-700', high: 'bg-orange-100 text-orange-700', urgent: 'bg-red-100 text-red-700' };
  return `text-xs px-2 py-0.5 rounded-full font-medium ${m[p] || m.medium}`;
}
function formatDate(d) { return new Date(d).toLocaleString(); }
</script>
