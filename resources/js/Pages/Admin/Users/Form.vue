<template>
  <AdminLayout>
    <Head :title="user ? 'Edit User' : 'Create User'" />

    <div class="max-w-2xl">
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ user ? 'Edit User' : 'Create New User' }}</h2>

        <form @submit.prevent="submit" class="space-y-5">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
              <input v-model="form.name" type="text" required class="input-field" />
              <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</p>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
              <input v-model="form.email" type="email" required class="input-field" />
              <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
              <select v-model="form.role" class="input-field">
                <option value="mentee">Mentee</option>
                <option value="mentor">Mentor</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Password {{ user ? '(leave blank to keep)' : '' }}</label>
              <input v-model="form.password" type="password" :required="!user" class="input-field" placeholder="Min. 8 characters" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Title / Position</label>
            <input v-model="form.title" type="text" class="input-field" placeholder="e.g. Senior Engineer at Google" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
            <textarea v-model="form.bio" rows="3" class="input-field" placeholder="Short biography..."></textarea>
          </div>

          <div class="flex items-center gap-5">
            <label class="flex items-center gap-2 text-sm text-gray-700">
              <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
              Active account
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-700">
              <input v-model="form.is_featured" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
              Featured mentor
            </label>
          </div>

          <div class="flex gap-3 pt-2">
            <button type="submit" :disabled="processing" class="btn-primary px-6 py-2.5 text-sm">
              {{ processing ? 'Saving...' : (user ? 'Update User' : 'Create User') }}
            </button>
            <Link href="/admin/users" class="btn-secondary px-6 py-2.5 text-sm">Cancel</Link>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  user: Object,
});

const processing = ref(false);
const errors = reactive({});
const form = reactive({
  name: props.user?.name || '',
  email: props.user?.email || '',
  password: '',
  role: props.user?.role || 'mentee',
  title: props.user?.title || '',
  bio: props.user?.bio || '',
  is_active: props.user?.is_active ?? true,
  is_featured: props.user?.is_featured ?? false,
});

function submit() {
  processing.value = true;
  const url = props.user ? `/admin/users/${props.user.id}` : '/admin/users';
  const method = props.user ? 'put' : 'post';

  router[method](url, form, {
    onError: (errs) => { Object.assign(errors, errs); processing.value = false; },
    onFinish: () => { processing.value = false; },
  });
}
</script>
