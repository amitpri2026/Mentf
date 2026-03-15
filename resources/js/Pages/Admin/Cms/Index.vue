<template>
  <AdminLayout>
    <Head title="CMS Pages" />

    <div class="max-w-4xl space-y-6">

      <!-- About Us -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-1">About Us Page</h2>
        <p class="text-sm text-gray-500 mb-4">Content shown at <code class="bg-gray-100 px-1 rounded">/about</code>. HTML is supported.</p>

        <form @submit.prevent="saveSection('about')" class="space-y-4">
          <textarea v-model="forms.about.page_about" rows="12"
            class="input-field text-sm font-mono w-full"
            placeholder="<h2>About Us</h2><p>...</p>"></textarea>

          <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <p v-if="saved.about" class="text-sm text-emerald-600 font-medium">✓ Saved</p>
            <div v-else></div>
            <button type="submit" class="btn-primary" :disabled="saving.about">
              {{ saving.about ? 'Saving…' : 'Save About Page' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Privacy Policy -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-1">Privacy Policy Page</h2>
        <p class="text-sm text-gray-500 mb-4">Content shown at <code class="bg-gray-100 px-1 rounded">/privacy</code>. HTML is supported.</p>

        <form @submit.prevent="saveSection('privacy')" class="space-y-4">
          <textarea v-model="forms.privacy.page_privacy" rows="14"
            class="input-field text-sm font-mono w-full"
            placeholder="<h2>Privacy Policy</h2><p>...</p>"></textarea>

          <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <p v-if="saved.privacy" class="text-sm text-emerald-600 font-medium">✓ Saved</p>
            <div v-else></div>
            <button type="submit" class="btn-primary" :disabled="saving.privacy">
              {{ saving.privacy ? 'Saving…' : 'Save Privacy Page' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-1">Contact Page</h2>
        <p class="text-sm text-gray-500 mb-4">Contact details shown at <code class="bg-gray-100 px-1 rounded">/contact</code>.</p>

        <form @submit.prevent="saveSection('contact')" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
              <input v-model="forms.contact.page_contact_email" type="email"
                placeholder="hello@mentf.com" class="input-field text-sm" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
              <input v-model="forms.contact.page_contact_phone" type="text"
                placeholder="+91 98765 43210" class="input-field text-sm" />
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
            <input v-model="forms.contact.page_contact_address" type="text"
              placeholder="City, State, Country" class="input-field text-sm" />
          </div>

          <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <p v-if="saved.contact" class="text-sm text-emerald-600 font-medium">✓ Saved</p>
            <div v-else></div>
            <button type="submit" class="btn-primary" :disabled="saving.contact">
              {{ saving.contact ? 'Saving…' : 'Save Contact Info' }}
            </button>
          </div>
        </form>
      </div>

    </div>
  </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ settings: Object });

const v = (key) => props.settings?.[key]?.value || '';

const forms = reactive({
  about:   { page_about: v('page_about') },
  privacy: { page_privacy: v('page_privacy') },
  contact: {
    page_contact_email:   v('page_contact_email'),
    page_contact_phone:   v('page_contact_phone'),
    page_contact_address: v('page_contact_address'),
  },
});

const saving = reactive({ about: false, privacy: false, contact: false });
const saved  = reactive({ about: false, privacy: false, contact: false });

function saveSection(section) {
  saving[section] = true;
  saved[section]  = false;

  router.post('/admin/cms', { ...forms[section] }, {
    onSuccess: () => {
      saved[section] = true;
      setTimeout(() => { saved[section] = false; }, 3000);
    },
    onFinish: () => { saving[section] = false; },
    preserveState: true,
  });
}
</script>
