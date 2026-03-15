<template>
  <AdminLayout>
    <Head title="Enrollments" />

    <div class="bg-white rounded-2xl border border-gray-100">
      <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-900">All Enrollments</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Student</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Package</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Payment</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="enrollment in enrollments.data" :key="enrollment.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <p class="text-sm font-medium text-gray-900">{{ enrollment.user?.name }}</p>
                <p class="text-xs text-gray-500">{{ enrollment.user?.email }}</p>
              </td>
              <td class="px-6 py-4">
                <p class="text-sm text-gray-900 max-w-xs truncate">{{ enrollment.package?.title }}</p>
                <p class="text-xs text-gray-500">by {{ enrollment.package?.mentor?.name }}</p>
              </td>
              <td class="px-6 py-4 text-sm font-bold text-indigo-600">${{ enrollment.amount_paid }}</td>
              <td class="px-6 py-4">
                <span
                  class="text-xs font-semibold px-2.5 py-1 rounded-full"
                  :class="{
                    'bg-yellow-100 text-yellow-700': enrollment.status === 'pending',
                    'bg-green-100 text-green-700': enrollment.status === 'active',
                    'bg-blue-100 text-blue-700': enrollment.status === 'completed',
                    'bg-red-100 text-red-700': enrollment.status === 'cancelled',
                  }"
                >
                  {{ enrollment.status }}
                </span>
              </td>
              <td class="px-6 py-4">
                <span
                  class="text-xs font-semibold px-2.5 py-1 rounded-full"
                  :class="{
                    'bg-yellow-100 text-yellow-700': enrollment.payment_status === 'pending',
                    'bg-green-100 text-green-700': enrollment.payment_status === 'paid',
                    'bg-red-100 text-red-700': enrollment.payment_status === 'refunded',
                  }"
                >
                  {{ enrollment.payment_status }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                {{ new Date(enrollment.created_at).toLocaleDateString() }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="enrollments.last_page > 1" class="p-4 border-t border-gray-100 flex justify-between items-center">
        <p class="text-sm text-gray-600">{{ enrollments.from }}-{{ enrollments.to }} of {{ enrollments.total }}</p>
        <div class="flex gap-2">
          <button v-for="p in enrollments.last_page" :key="p" @click="goToPage(p)"
            class="w-8 h-8 text-xs rounded-lg"
            :class="p === enrollments.current_page ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'">
            {{ p }}
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ enrollments: Object });

function goToPage(page) {
  router.get('/admin/enrollments', { page }, { preserveState: true });
}
</script>
