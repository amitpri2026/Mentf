<template>
  <AdminLayout>
    <Head title="Categories" />

    <div class="bg-white rounded-2xl border border-gray-100">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900">All Categories</h2>
        <Link href="/admin/categories/create" class="btn-primary text-sm py-2 px-4">+ Add Category</Link>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Packages</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Order</th>
              <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="cat in categories" :key="cat.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg flex items-center justify-center text-base" :style="{ backgroundColor: (cat.color || '#6366F1') + '20' }">
                    {{ cat.icon || '📌' }}
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-900">{{ cat.name }}</p>
                    <p class="text-xs text-gray-500">{{ cat.slug }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ cat.packages_count }}</td>
              <td class="px-6 py-4">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" :class="cat.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'">
                  {{ cat.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ cat.sort_order }}</td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <Link :href="`/admin/categories/${cat.id}/edit`" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium px-3 py-1.5 rounded-lg hover:bg-indigo-50">Edit</Link>
                  <button @click="deleteCategory(cat)" class="text-xs text-red-600 hover:text-red-800 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50">Delete</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ categories: Array });

function deleteCategory(cat) {
  if (confirm(`Delete category "${cat.name}"?`)) {
    router.delete(`/admin/categories/${cat.id}`);
  }
}
</script>
