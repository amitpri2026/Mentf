<template>
  <AdminLayout>
    <Head title="Users" />

    <div class="bg-white rounded-2xl border border-gray-100">
      <!-- Header -->
      <div class="p-6 border-b border-gray-100 flex items-center justify-between gap-4">
        <div class="flex gap-3 flex-1">
          <input
            v-model="search"
            @input="debouncedSearch"
            type="text"
            placeholder="Search users..."
            class="input-field max-w-xs text-sm"
          />
          <select v-model="role" @change="applyFilters" class="text-sm border border-gray-300 rounded-xl px-3 py-2">
            <option value="">All Roles</option>
            <option value="admin">Admin</option>
            <option value="mentor">Mentor</option>
            <option value="mentee">Mentee</option>
          </select>
        </div>
        <Link href="/admin/users/create" class="btn-primary text-sm py-2 px-4">+ Add User</Link>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
              <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold text-sm flex-shrink-0">
                    {{ user.name.charAt(0) }}
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                    <p class="text-xs text-gray-500">{{ user.email }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span
                  class="text-xs font-semibold px-2.5 py-1 rounded-full"
                  :class="{
                    'bg-purple-100 text-purple-700': user.role === 'admin',
                    'bg-indigo-100 text-indigo-700': user.role === 'mentor',
                    'bg-gray-100 text-gray-600': user.role === 'mentee',
                  }"
                >
                  {{ user.role }}
                </span>
              </td>
              <td class="px-6 py-4">
                <span
                  class="text-xs font-semibold px-2.5 py-1 rounded-full"
                  :class="user.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                >
                  {{ user.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                {{ new Date(user.created_at).toLocaleDateString() }}
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button v-if="user.role === 'mentor'" @click="toggleFeatured(user)"
                    class="text-xs font-medium px-3 py-1.5 rounded-lg transition-colors"
                    :class="user.is_featured ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-slate-500 hover:text-amber-700 hover:bg-amber-50'">
                    {{ user.is_featured ? '★ Featured' : '☆ Feature' }}
                  </button>
                  <Link v-if="user.role === 'mentor'" :href="`/admin/mentors/${user.id}/packages`"
                    class="text-xs text-emerald-600 hover:text-emerald-800 font-medium px-3 py-1.5 rounded-lg hover:bg-emerald-50 transition-colors">
                    Packages
                  </Link>
                  <Link :href="`/admin/users/${user.id}/edit`" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium px-3 py-1.5 rounded-lg hover:bg-indigo-50 transition-colors">Edit</Link>
                  <button @click="deleteUser(user)" class="text-xs text-red-600 hover:text-red-800 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">Delete</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="users.last_page > 1" class="p-4 border-t border-gray-100 flex items-center justify-between">
        <p class="text-sm text-gray-600">Showing {{ users.from }}-{{ users.to }} of {{ users.total }}</p>
        <div class="flex gap-2">
          <button
            v-for="page in users.last_page"
            :key="page"
            @click="goToPage(page)"
            class="w-8 h-8 text-xs rounded-lg"
            :class="page === users.current_page ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            {{ page }}
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  users: Object,
  filters: Object,
});

const search = ref(props.filters?.search || '');
const role = ref(props.filters?.role || '');

let timeout = null;
function debouncedSearch() {
  clearTimeout(timeout);
  timeout = setTimeout(() => applyFilters(), 400);
}

function applyFilters() {
  const params = {};
  if (search.value) params.search = search.value;
  if (role.value) params.role = role.value;
  router.get('/admin/users', params, { preserveState: true });
}

function goToPage(page) {
  router.get('/admin/users', { search: search.value, role: role.value, page }, { preserveState: true });
}

function toggleFeatured(user) {
  router.patch(`/admin/users/${user.id}`, { is_featured: !user.is_featured }, { preserveState: true });
}

function deleteUser(user) {
  if (confirm(`Delete user ${user.name}?`)) {
    router.delete(`/admin/users/${user.id}`);
  }
}
</script>
