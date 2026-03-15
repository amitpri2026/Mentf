<template>
  <AdminLayout>
    <Head title="Site Settings" />

    <div class="max-w-2xl space-y-6">

      <!-- Stats Numbers -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-1">Homepage Stats</h2>
        <p class="text-sm text-gray-500 mb-6">
          Override the numbers shown on the homepage hero and stats bar.
          Leave blank to use live database counts.
        </p>

        <form @submit.prevent="save" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Expert Mentors
                <span class="text-xs text-gray-400 font-normal ml-1">(live: {{ liveStats.mentors }})</span>
              </label>
              <input v-model="form.stat_mentors" type="text" placeholder="e.g. 500"
                class="input-field text-sm" />
              <p class="text-xs text-gray-400 mt-1">Shown as "{{ form.stat_mentors || liveStats.mentors }}+ Expert Mentors"</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Happy Students
                <span class="text-xs text-gray-400 font-normal ml-1">(live: {{ liveStats.students }})</span>
              </label>
              <input v-model="form.stat_students" type="text" placeholder="e.g. 2000"
                class="input-field text-sm" />
              <p class="text-xs text-gray-400 mt-1">Shown as "{{ form.stat_students || liveStats.students }}+ Happy Students"</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Learning Packages
                <span class="text-xs text-gray-400 font-normal ml-1">(live: {{ liveStats.packages }})</span>
              </label>
              <input v-model="form.stat_packages" type="text" placeholder="e.g. 150"
                class="input-field text-sm" />
              <p class="text-xs text-gray-400 mt-1">Shown as "{{ form.stat_packages || liveStats.packages }}+ Packages"</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Categories
                <span class="text-xs text-gray-400 font-normal ml-1">(live: {{ liveStats.categories }})</span>
              </label>
              <input v-model="form.stat_categories" type="text" placeholder="e.g. 14"
                class="input-field text-sm" />
              <p class="text-xs text-gray-400 mt-1">Shows exact value, no suffix</p>
            </div>
          </div>

          <!-- Hero tagline -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
              Announcement Bar Text
              <span class="text-xs text-gray-400 font-normal ml-1">(top blue bar)</span>
            </label>
            <input v-model="form.hero_tagline" type="text"
              placeholder="🌟 Connect with world-class mentors across 14 categories"
              class="input-field text-sm" />
            <p class="text-xs text-gray-400 mt-1">Leave blank to use the default text</p>
          </div>

          <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <p v-if="saved" class="text-sm text-emerald-600 font-medium">✓ Settings saved</p>
            <div v-else></div>
            <button type="submit" class="btn-primary" :disabled="saving">
              <svg v-if="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
              </svg>
              {{ saving ? 'Saving…' : 'Save Settings' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Preview -->
      <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6">
        <h3 class="text-sm font-semibold text-slate-700 mb-4">Preview — Stats Bar</h3>
        <div class="grid grid-cols-4 gap-4 bg-white rounded-xl border border-slate-200 p-5">
          <div v-for="s in preview" :key="s.label" class="text-center">
            <div class="text-2xl font-bold text-slate-900">{{ s.value }}</div>
            <div class="text-xs text-slate-400 uppercase tracking-wider mt-1">{{ s.label }}</div>
          </div>
        </div>
      </div>

    </div>
  </AdminLayout>
</template>

<script setup>
import { reactive, ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  settings: Object,
});

// Live counts from DB (passed via settings metadata or we derive from existing data)
const liveStats = computed(() => ({
  mentors:    '—',
  students:   '—',
  packages:   '—',
  categories: '—',
}));

const form = reactive({
  stat_mentors:    props.settings?.stat_mentors?.value    || '',
  stat_students:   props.settings?.stat_students?.value   || '',
  stat_packages:   props.settings?.stat_packages?.value   || '',
  stat_categories: props.settings?.stat_categories?.value || '',
  hero_tagline:    props.settings?.hero_tagline?.value    || '',
});

const saving = ref(false);
const saved  = ref(false);

function save() {
  saving.value = true;
  saved.value  = false;
  router.post('/admin/settings', { ...form }, {
    onSuccess: () => { saved.value = true; setTimeout(() => { saved.value = false; }, 3000); },
    onFinish:  () => { saving.value = false; },
    preserveState: true,
  });
}

const preview = computed(() => [
  { value: (form.stat_mentors    || '—') + '+', label: 'Expert Mentors' },
  { value: (form.stat_students   || '—') + '+', label: 'Happy Students' },
  { value: (form.stat_packages   || '—') + '+', label: 'Learning Packages' },
  { value: (form.stat_categories || '—'),        label: 'Categories' },
]);
</script>
