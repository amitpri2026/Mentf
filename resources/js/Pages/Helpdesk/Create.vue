<template>
  <div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 px-6 py-4">
      <div class="max-w-2xl mx-auto flex items-center gap-4">
        <Link href="/helpdesk" class="text-slate-400 hover:text-slate-700">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </Link>
        <h1 class="text-xl font-bold text-slate-900">New Support Ticket</h1>
      </div>
    </div>

    <div class="max-w-2xl mx-auto px-6 py-6">
      <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form @submit.prevent="submit" class="space-y-5">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Subject *</label>
            <input v-model="form.subject" type="text" required maxlength="255"
              class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Briefly describe your issue" />
            <p v-if="form.errors.subject" class="text-red-500 text-xs mt-1">{{ form.errors.subject }}</p>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Priority *</label>
              <select v-model="form.priority" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="urgent">Urgent</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Category</label>
              <select v-model="form.category" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select category</option>
                <option value="account">Account</option>
                <option value="billing">Billing</option>
                <option value="technical">Technical Issue</option>
                <option value="enrollment">Enrollment</option>
                <option value="mentor">Mentor Issue</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Message *</label>
            <textarea v-model="form.message" rows="6" required maxlength="5000"
              class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
              placeholder="Please describe your issue in detail..."></textarea>
            <p v-if="form.errors.message" class="text-red-500 text-xs mt-1">{{ form.errors.message }}</p>
          </div>

          <button type="submit" :disabled="form.processing"
            class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-60">
            Submit Ticket
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
const form = useForm({ subject: '', message: '', priority: 'medium', category: '' });
function submit() { form.post('/helpdesk'); }
</script>
