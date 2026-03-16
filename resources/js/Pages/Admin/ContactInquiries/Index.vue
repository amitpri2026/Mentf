<template>
  <AdminLayout>
    <Head title="Contact Inquiries" />

    <div class="space-y-4">

      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-lg font-bold text-slate-900">Contact Inquiries</h2>
          <p class="text-sm text-slate-500 mt-0.5">
            {{ unread_count }} unread · {{ inquiries.total }} total
          </p>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div v-if="inquiries.data.length === 0" class="text-center py-16 text-slate-400 text-sm">
          No inquiries yet.
        </div>

        <table v-else class="w-full text-sm">
          <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
              <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Phone</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Message</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Received</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
              <th class="px-5 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr
              v-for="item in inquiries.data"
              :key="item.id"
              :class="item.is_read ? 'bg-white' : 'bg-blue-50/40'"
            >
              <td class="px-5 py-4 font-semibold text-slate-900 whitespace-nowrap">
                <span v-if="!item.is_read" class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2 align-middle"></span>
                {{ item.name }}
              </td>
              <td class="px-5 py-4 text-slate-600">
                <a :href="`mailto:${item.email}`" class="hover:text-blue-600">{{ item.email }}</a>
              </td>
              <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                <a :href="`tel:${item.phone}`" class="hover:text-blue-600">{{ item.phone }}</a>
              </td>
              <td class="px-5 py-4 text-slate-500 max-w-xs">
                <span class="line-clamp-2">{{ item.message || '—' }}</span>
              </td>
              <td class="px-5 py-4 text-slate-400 whitespace-nowrap text-xs">{{ formatDate(item.created_at) }}</td>
              <td class="px-5 py-4 whitespace-nowrap">
                <span v-if="item.is_read" class="text-xs text-slate-400 font-medium">Read</span>
                <span v-else class="text-xs text-blue-600 font-semibold">New</span>
              </td>
              <td class="px-5 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2">
                  <button
                    v-if="!item.is_read"
                    @click="markRead(item)"
                    class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                    title="Mark as read"
                  >
                    Mark read
                  </button>
                  <button
                    @click="deleteInquiry(item)"
                    class="text-xs text-red-500 hover:text-red-700 font-medium"
                    title="Delete"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="inquiries.last_page > 1" class="flex items-center justify-between px-5 py-4 border-t border-slate-100">
          <p class="text-xs text-slate-500">
            Showing {{ inquiries.from }}–{{ inquiries.to }} of {{ inquiries.total }}
          </p>
          <div class="flex gap-2">
            <Link
              v-if="inquiries.prev_page_url"
              :href="inquiries.prev_page_url"
              class="text-xs px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600"
            >
              Previous
            </Link>
            <Link
              v-if="inquiries.next_page_url"
              :href="inquiries.next_page_url"
              class="text-xs px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600"
            >
              Next
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  inquiries: Object,
  unread_count: Number,
});

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('en-IN', {
    day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit',
  });
}

function markRead(item) {
  router.patch(`/admin/contact-inquiries/${item.id}/read`);
}

function deleteInquiry(item) {
  if (confirm('Delete this inquiry?')) {
    router.delete(`/admin/contact-inquiries/${item.id}`);
  }
}
</script>
