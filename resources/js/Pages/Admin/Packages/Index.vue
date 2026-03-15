<template>
  <AdminLayout>
    <Head title="Packages" />

    <div class="bg-white rounded-2xl border border-gray-100">
      <div class="p-6 border-b border-gray-100 flex gap-3">
        <input
          v-model="search"
          @input="debouncedSearch"
          type="text"
          placeholder="Search packages..."
          class="input-field max-w-xs text-sm"
        />
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Package</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mentor</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="pkg in packages.data" :key="pkg.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <p class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ pkg.title }}</p>
                <p class="text-xs text-gray-500">{{ pkg.package_type?.name }}</p>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ pkg.mentor?.name }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ pkg.category?.name }}</td>
              <td class="px-6 py-4 text-sm font-bold text-indigo-600">₹{{ pkg.price }}</td>
              <td class="px-6 py-4">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" :class="pkg.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'">
                  {{ pkg.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button @click="toggleActive(pkg)" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium px-2 py-1 rounded hover:bg-indigo-50">
                    {{ pkg.is_active ? 'Deactivate' : 'Activate' }}
                  </button>
                  <button @click="deletePkg(pkg)" class="text-xs text-red-600 hover:text-red-800 font-medium px-2 py-1 rounded hover:bg-red-50">Delete</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="packages.last_page > 1" class="p-4 border-t border-gray-100 flex justify-between items-center">
        <p class="text-sm text-gray-600">{{ packages.from }}-{{ packages.to }} of {{ packages.total }}</p>
        <div class="flex gap-2">
          <button v-for="p in packages.last_page" :key="p" @click="goToPage(p)"
            class="w-8 h-8 text-xs rounded-lg"
            :class="p === packages.current_page ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'">
            {{ p }}
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ packages: Object, filters: Object });
const search = ref(props.filters?.search || '');

let timeout = null;
function debouncedSearch() {
  clearTimeout(timeout);
  timeout = setTimeout(() => router.get('/admin/packages', { search: search.value }, { preserveState: true }), 400);
}

function goToPage(page) {
  router.get('/admin/packages', { search: search.value, page }, { preserveState: true });
}

function toggleActive(pkg) {
  router.put(`/admin/packages/${pkg.id}`, { is_active: !pkg.is_active }, { preserveState: true });
}

function deletePkg(pkg) {
  if (confirm(`Delete package "${pkg.title}"?`)) {
    router.delete(`/admin/packages/${pkg.id}`);
  }
}
</script>
