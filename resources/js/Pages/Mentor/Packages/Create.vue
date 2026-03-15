<template>
  <AppLayout>
    <Head title="Create Package" />

    <div class="bg-white border-b border-slate-200">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-1">
          <Link href="/mentor/packages" class="hover:text-blue-600 transition-colors">My Packages</Link>
          <span>/</span>
          <span class="text-slate-900 font-medium">New Package</span>
        </nav>
        <h1 class="text-xl font-bold text-slate-900">Create Mentorship Package</h1>
      </div>
    </div>

    <!-- Step progress bar -->
    <div class="bg-white border-b border-slate-100 sticky top-16 z-30">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center gap-0">
          <template v-for="(s, i) in steps" :key="s.id">
            <!-- Step -->
            <div class="flex items-center gap-2 cursor-pointer" @click="goToStep(i)">
              <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all flex-shrink-0"
                :class="i < step
                  ? 'bg-blue-500 text-white'
                  : i === step
                    ? 'bg-blue-600 text-white ring-4 ring-blue-100'
                    : 'bg-slate-100 text-slate-400'">
                <svg v-if="i < step" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
                <span v-else>{{ i + 1 }}</span>
              </div>
              <span class="text-sm font-medium hidden sm:block"
                :class="i === step ? 'text-blue-600' : i < step ? 'text-slate-600' : 'text-slate-400'">
                {{ s.label }}
              </span>
            </div>
            <!-- Connector -->
            <div v-if="i < steps.length - 1" class="flex-1 mx-3 h-px"
              :class="i < step ? 'bg-blue-400' : 'bg-slate-200'"></div>
          </template>
        </div>
      </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

      <!-- ── Step 1: Basics ── -->
      <div v-show="step === 0">
        <div class="bg-white rounded-xl border border-slate-200 p-7 space-y-6">
          <div>
            <h2 class="text-lg font-bold text-slate-900">Package Basics</h2>
            <p class="text-sm text-slate-500 mt-0.5">Give your package a clear, searchable title and pick the right category.</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Package Title <span class="text-red-500">*</span></label>
            <input v-model="form.title" type="text"
              placeholder="e.g. Big Data Architect Mentorship, Kafka Introduction..."
              class="input-field text-base" :class="{ 'border-red-400': errors.title }" />
            <p v-if="errors.title" class="text-red-500 text-xs mt-1">{{ errors.title }}</p>
            <p v-else class="text-xs text-slate-400 mt-1">Be specific — students search by title and keywords</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Category <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
              <button v-for="cat in categories" :key="cat.id" type="button"
                @click="form.category_id = cat.id"
                class="text-left px-3.5 py-2.5 rounded-xl border-2 text-sm transition-all"
                :class="form.category_id == cat.id
                  ? 'border-blue-500 bg-blue-50 text-blue-700 font-semibold'
                  : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                {{ cat.name }}
              </button>
            </div>
            <p v-if="errors.category_id" class="text-red-500 text-xs mt-2">{{ errors.category_id }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Package Type <span class="text-red-500">*</span></label>
            <div class="flex flex-wrap gap-2">
              <button v-for="pt in packageTypes" :key="pt.id" type="button"
                @click="form.package_type_id = pt.id"
                class="px-4 py-2 rounded-xl border-2 text-sm font-medium transition-all"
                :class="form.package_type_id == pt.id
                  ? 'border-blue-500 bg-blue-50 text-blue-700'
                  : 'border-slate-200 text-slate-600 hover:border-slate-300'">
                {{ pt.name }}
              </button>
            </div>
            <p v-if="errors.package_type_id" class="text-red-500 text-xs mt-2">{{ errors.package_type_id }}</p>
          </div>
        </div>
      </div>

      <!-- ── Step 2: Details ── -->
      <div v-show="step === 1">
        <div class="bg-white rounded-xl border border-slate-200 p-7 space-y-6">
          <div>
            <h2 class="text-lg font-bold text-slate-900">Package Details</h2>
            <p class="text-sm text-slate-500 mt-0.5">Help students understand what they'll learn and what they need upfront.</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description <span class="text-red-500">*</span></label>
            <textarea v-model="form.description" rows="5"
              placeholder="Describe what this package covers, who it's for, and what students will gain. Be detailed — this is your sales pitch!"
              class="input-field resize-none" :class="{ 'border-red-400': errors.description }"></textarea>
            <p v-if="errors.description" class="text-red-500 text-xs mt-1">{{ errors.description }}</p>
            <p v-else class="text-xs text-slate-400 mt-1">{{ form.description.length }} characters · aim for 150+</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prerequisites / Requirements
              <span class="text-xs font-normal text-slate-400 ml-1">(optional)</span>
            </label>
            <textarea v-model="form.requirements" rows="3"
              placeholder="e.g. Basic understanding of SQL, familiarity with Linux command line..."
              class="input-field resize-none"></textarea>
            <p class="text-xs text-slate-400 mt-1">What should students know or have before starting?</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Learning Outcomes
              <span class="text-xs font-normal text-slate-400 ml-1">(optional)</span>
            </label>
            <textarea v-model="form.outcomes" rows="3"
              placeholder="e.g. Design and implement a scalable data pipeline, understand Kafka architecture..."
              class="input-field resize-none"></textarea>
            <p class="text-xs text-slate-400 mt-1">What will students be able to do after completing this?</p>
          </div>
        </div>
      </div>

      <!-- ── Step 3: Pricing & Structure ── -->
      <div v-show="step === 2">
        <div class="bg-white rounded-xl border border-slate-200 p-7 space-y-6">
          <div>
            <h2 class="text-lg font-bold text-slate-900">Pricing & Structure</h2>
            <p class="text-sm text-slate-500 mt-0.5">Set your price and define how this package is delivered.</p>
          </div>

          <!-- Price -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Price <span class="text-red-500">*</span></label>
            <div class="flex gap-3">
              <select v-model="form.currency" class="input-field w-28 flex-shrink-0">
                <option value="USD">🇺🇸 USD</option>
                <option value="INR">🇮🇳 INR</option>
                <option value="EUR">🇪🇺 EUR</option>
                <option value="GBP">🇬🇧 GBP</option>
              </select>
              <input v-model="form.price" type="number" min="0" step="0.01" placeholder="0.00"
                class="input-field flex-1 text-lg font-semibold" :class="{ 'border-red-400': errors.price }" />
            </div>
            <p v-if="errors.price" class="text-red-500 text-xs mt-1">{{ errors.price }}</p>
          </div>

          <!-- Level -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Level</label>
            <div class="flex flex-wrap gap-2">
              <button v-for="lvl in levels" :key="lvl.value" type="button"
                @click="form.level = lvl.value"
                class="px-4 py-2 rounded-xl border-2 text-sm font-medium transition-all"
                :class="form.level === lvl.value
                  ? 'border-blue-500 bg-blue-50 text-blue-700'
                  : 'border-slate-200 text-slate-600 hover:border-slate-300'">
                {{ lvl.label }}
              </button>
            </div>
          </div>

          <!-- Sessions / Duration / Max students -->
          <div class="grid grid-cols-3 gap-4">
            <div class="bg-slate-50 rounded-xl p-4">
              <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Sessions</label>
              <input v-model="form.sessions" type="number" min="1"
                class="w-full text-2xl font-bold text-slate-900 bg-transparent border-none outline-none" />
              <p class="text-xs text-slate-400 mt-1">Total sessions</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
              <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Duration</label>
              <div class="flex items-baseline gap-1">
                <input v-model="form.duration" type="number" min="15" step="15"
                  class="w-full text-2xl font-bold text-slate-900 bg-transparent border-none outline-none" />
              </div>
              <p class="text-xs text-slate-400 mt-1">Minutes / session</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
              <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Max Students</label>
              <input v-model="form.max_students" type="number" min="1"
                class="w-full text-2xl font-bold text-slate-900 bg-transparent border-none outline-none" />
              <p class="text-xs text-slate-400 mt-1">Per cohort</p>
            </div>
          </div>

          <!-- Language -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Delivery Language</label>
            <select v-model="form.language" class="input-field w-56">
              <option value="en">English</option>
              <option value="hi">Hindi</option>
              <option value="es">Spanish</option>
              <option value="fr">French</option>
              <option value="de">German</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ── Step 4: Images ── -->
      <div v-show="step === 3">
        <div class="bg-white rounded-xl border border-slate-200 p-7 space-y-8">
          <div>
            <h2 class="text-lg font-bold text-slate-900">Package Images</h2>
            <p class="text-sm text-slate-500 mt-0.5">Upload two images — one for listings and one for the package detail banner.</p>
          </div>

          <!-- Thumbnail -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Thumbnail
              <span class="text-xs font-normal text-slate-400 ml-1">Shown on listing & search cards · 400×300 recommended</span>
            </label>
            <div @click="$refs.thumbnailInput.click()"
              class="relative cursor-pointer rounded-xl overflow-hidden border-2 border-dashed border-slate-200 hover:border-blue-300 transition-colors flex items-center justify-center bg-slate-50"
              style="height: 200px;">
              <img v-if="thumbnailPreview" :src="thumbnailPreview" class="w-full h-full object-cover absolute inset-0" />
              <div class="relative z-10 flex flex-col items-center text-slate-400 pointer-events-none"
                :class="thumbnailPreview ? 'opacity-0 hover:opacity-100' : ''">
                <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center mb-3">
                  <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">Click to upload thumbnail</span>
                <span class="text-xs text-slate-400 mt-1">JPG, PNG up to 4MB</span>
              </div>
              <div v-if="thumbnailPreview"
                class="absolute inset-0 bg-slate-900/40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                <span class="text-white text-sm font-semibold bg-slate-900/60 px-4 py-2 rounded-lg">Change Image</span>
              </div>
            </div>
            <input ref="thumbnailInput" type="file" accept="image/*" class="hidden" @change="onThumbnail" />
          </div>

          <!-- Banner -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Banner
              <span class="text-xs font-normal text-slate-400 ml-1">Full-width header on the package page · 1200×400 recommended</span>
            </label>
            <div @click="$refs.bannerInput.click()"
              class="relative cursor-pointer rounded-xl overflow-hidden border-2 border-dashed border-slate-200 hover:border-blue-300 transition-colors flex items-center justify-center bg-slate-50"
              style="height: 200px;">
              <img v-if="bannerPreview" :src="bannerPreview" class="w-full h-full object-cover absolute inset-0" />
              <div class="relative z-10 flex flex-col items-center text-slate-400 pointer-events-none"
                :class="bannerPreview ? 'opacity-0' : ''">
                <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center mb-3">
                  <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">Click to upload banner</span>
                <span class="text-xs text-slate-400 mt-1">JPG, PNG up to 8MB · wide landscape works best</span>
              </div>
              <div v-if="bannerPreview"
                class="absolute inset-0 bg-slate-900/40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                <span class="text-white text-sm font-semibold bg-slate-900/60 px-4 py-2 rounded-lg">Change Image</span>
              </div>
            </div>
            <input ref="bannerInput" type="file" accept="image/*" class="hidden" @change="onBanner" />
          </div>

          <!-- Summary before submit -->
          <div class="bg-slate-50 rounded-xl p-5 space-y-2 text-sm">
            <h3 class="font-semibold text-slate-700 mb-3">Review before creating</h3>
            <div class="flex gap-2"><span class="text-slate-500 w-24 flex-shrink-0">Title</span><span class="font-medium text-slate-900 truncate">{{ form.title || '—' }}</span></div>
            <div class="flex gap-2"><span class="text-slate-500 w-24 flex-shrink-0">Category</span><span class="text-slate-700">{{ selectedCategoryName || '—' }}</span></div>
            <div class="flex gap-2"><span class="text-slate-500 w-24 flex-shrink-0">Type</span><span class="text-slate-700">{{ selectedTypeName || '—' }}</span></div>
            <div class="flex gap-2"><span class="text-slate-500 w-24 flex-shrink-0">Price</span><span class="text-slate-700">{{ form.currency }} {{ form.price || '0' }}</span></div>
            <div class="flex gap-2"><span class="text-slate-500 w-24 flex-shrink-0">Structure</span><span class="text-slate-700">{{ form.sessions }} session{{ form.sessions != 1 ? 's' : '' }} · {{ form.duration }} min each · max {{ form.max_students }} student{{ form.max_students != 1 ? 's' : '' }}</span></div>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <div class="mt-6 flex items-center justify-between">
        <button v-if="step > 0" @click="step--" type="button" class="btn-secondary flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
          Back
        </button>
        <Link v-else href="/mentor/packages" class="btn-secondary">Cancel</Link>

        <div class="flex items-center gap-3">
          <!-- Step dots -->
          <div class="flex gap-1.5">
            <div v-for="i in steps.length" :key="i" class="w-1.5 h-1.5 rounded-full transition-all"
              :class="i - 1 === step ? 'bg-blue-500 w-4' : i - 1 < step ? 'bg-blue-300' : 'bg-slate-200'"></div>
          </div>

          <button v-if="step < steps.length - 1" @click="nextStep" type="button" class="btn-primary flex items-center gap-2">
            Next
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
          <button v-else @click="submit" type="button" class="btn-primary px-7" :disabled="submitting">
            <svg v-if="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            {{ submitting ? 'Creating...' : 'Create & Add Topics →' }}
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({ categories: Array, packageTypes: Array });

const steps = [
  { id: 'basics',  label: 'Basics' },
  { id: 'details', label: 'Details' },
  { id: 'pricing', label: 'Pricing' },
  { id: 'images',  label: 'Images' },
];

const levels = [
  { value: 'all',          label: 'All Levels' },
  { value: 'beginner',     label: 'Beginner' },
  { value: 'intermediate', label: 'Intermediate' },
  { value: 'advanced',     label: 'Advanced' },
];

const step = ref(0);

const form = reactive({
  title: '', description: '', requirements: '', outcomes: '',
  category_id: '', package_type_id: '',
  price: '', currency: 'INR',
  duration: 60, sessions: 1, max_students: 1,
  level: 'all', language: 'en',
});

const errors = ref({});
const submitting = ref(false);
const thumbnailPreview = ref(null);
const bannerPreview = ref(null);
const thumbnailFile = ref(null);
const bannerFile = ref(null);

const selectedCategoryName = computed(() =>
  props.categories?.find(c => c.id == form.category_id)?.name
);
const selectedTypeName = computed(() =>
  props.packageTypes?.find(t => t.id == form.package_type_id)?.name
);

function goToStep(i) {
  if (i < step.value) step.value = i;
}

function nextStep() {
  errors.value = {};
  // Basic validation before advancing
  if (step.value === 0) {
    if (!form.title.trim()) { errors.value = { title: 'Title is required' }; return; }
    if (!form.category_id)  { errors.value = { category_id: 'Pick a category' }; return; }
    if (!form.package_type_id) { errors.value = { package_type_id: 'Pick a type' }; return; }
  }
  if (step.value === 1) {
    if (!form.description.trim()) { errors.value = { description: 'Description is required' }; return; }
  }
  if (step.value === 2) {
    if (!form.price || form.price <= 0) { errors.value = { price: 'Enter a valid price' }; return; }
  }
  step.value++;
}

function onThumbnail(e) {
  const file = e.target.files[0];
  if (!file) return;
  thumbnailFile.value = file;
  thumbnailPreview.value = URL.createObjectURL(file);
}

function onBanner(e) {
  const file = e.target.files[0];
  if (!file) return;
  bannerFile.value = file;
  bannerPreview.value = URL.createObjectURL(file);
}

function submit() {
  submitting.value = true;
  errors.value = {};

  const data = new FormData();
  Object.entries(form).forEach(([k, v]) => data.append(k, v ?? ''));
  if (thumbnailFile.value) data.append('thumbnail', thumbnailFile.value);
  if (bannerFile.value) data.append('banner', bannerFile.value);

  router.post('/mentor/packages', data, {
    onError: (e) => { errors.value = e; submitting.value = false; },
    onFinish: () => { submitting.value = false; },
  });
}
</script>
