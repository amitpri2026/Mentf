<template>
  <AdminLayout>
    <Head :title="user ? 'Edit User' : 'Create User'" />

    <div class="max-w-2xl space-y-5">

      <!-- Main form -->
      <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-bold text-slate-900">{{ user ? 'Edit User' : 'Create New User' }}</h2>
          <Link v-if="user" :href="`/admin/users/${user.id}/profile`"
            class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Full Profile Editor
          </Link>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
              <input v-model="form.name" type="text" required class="input-field" />
              <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</p>
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
              <input v-model="form.email" type="email" required class="input-field" />
              <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Role</label>
              <select v-model="form.role" class="input-field">
                <option value="mentee">Mentee</option>
                <option value="mentor">Mentor</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Location</label>
              <input v-model="form.location" type="text" class="input-field" placeholder="City, Country" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Title / Position</label>
            <input v-model="form.title" type="text" class="input-field" placeholder="e.g. Senior Engineer at Google" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Bio</label>
            <textarea v-model="form.bio" rows="3" class="input-field" placeholder="Short biography..."></textarea>
          </div>

          <div class="flex items-center gap-5">
            <label class="flex items-center gap-2 text-sm text-slate-700">
              <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
              Active account
            </label>
            <label class="flex items-center gap-2 text-sm text-slate-700">
              <input v-model="form.is_featured" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
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

      <!-- Change Password (edit mode only) -->
      <div v-if="user" class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="text-base font-bold text-slate-900 mb-1">Change Password</h3>
        <p class="text-sm text-slate-500 mb-4">Set a new password for this user. They will need to use it on next login.</p>
        <form @submit.prevent="changePassword" class="flex items-end gap-3">
          <div class="flex-1">
            <label class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
            <input v-model="pwForm.password" type="text" required minlength="8" class="input-field"
              placeholder="Min. 8 characters" />
            <p v-if="pwErrors.password" class="text-red-500 text-xs mt-1">{{ pwErrors.password }}</p>
          </div>
          <button type="submit" :disabled="pwProcessing"
            class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-semibold transition disabled:opacity-60 whitespace-nowrap">
            {{ pwProcessing ? 'Saving…' : 'Set Password' }}
          </button>
        </form>
        <p v-if="pwSuccess" class="text-green-600 text-sm mt-2 font-medium">{{ pwSuccess }}</p>
      </div>

    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ user: Object });

const processing = ref(false);
const errors = reactive({});
const form = reactive({
  name:        props.user?.name || '',
  email:       props.user?.email || '',
  role:        props.user?.role || 'mentee',
  title:       props.user?.title || '',
  bio:         props.user?.bio || '',
  location:    props.user?.location || '',
  is_active:   props.user?.is_active ?? true,
  is_featured: props.user?.is_featured ?? false,
});

function submit() {
  processing.value = true;
  const url    = props.user ? `/admin/users/${props.user.id}` : '/admin/users';
  const method = props.user ? 'put' : 'post';
  router[method](url, form, {
    onError:  (errs) => { Object.assign(errors, errs); processing.value = false; },
    onFinish: () => { processing.value = false; },
  });
}

// Password change
const pwForm      = reactive({ password: '' });
const pwErrors    = reactive({});
const pwProcessing = ref(false);
const pwSuccess   = ref('');

function changePassword() {
  pwProcessing.value = true;
  pwSuccess.value    = '';
  router.put(`/admin/users/${props.user.id}`, {
    ...form,
    password: pwForm.password,
  }, {
    onSuccess: () => { pwForm.password = ''; pwSuccess.value = 'Password updated successfully.'; pwProcessing.value = false; },
    onError:   (errs) => { Object.assign(pwErrors, errs); pwProcessing.value = false; },
  });
}
</script>
