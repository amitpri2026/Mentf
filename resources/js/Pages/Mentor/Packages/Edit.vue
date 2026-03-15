<template>
  <AppLayout>
    <Head :title="`Edit: ${package.title}`" />

    <div class="bg-white border-b border-slate-200">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-1">
          <Link href="/mentor/packages" class="hover:text-blue-600 transition-colors">My Packages</Link>
          <span>/</span>
          <span class="text-slate-900 font-medium truncate">{{ package.title }}</span>
        </nav>
        <div class="flex items-center justify-between">
          <h1 class="text-xl font-bold text-slate-900">Edit Package</h1>
          <a :href="`/packages/${package.slug}`" target="_blank"
            class="text-sm text-blue-600 hover:underline flex items-center gap-1">
            View public page
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border-b border-slate-200 sticky top-16 z-30">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-1">
          <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
            class="px-4 py-3 text-sm font-medium border-b-2 transition-colors"
            :class="activeTab === tab.id
              ? 'border-blue-500 text-blue-600'
              : 'border-transparent text-slate-500 hover:text-slate-700'">
            {{ tab.label }}
            <span v-if="tab.id === 'topics'" class="ml-1.5 text-xs bg-slate-100 text-slate-600 rounded-full px-1.5 py-0.5">
              {{ package.topics?.length || 0 }}
            </span>
          </button>
        </div>
      </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

      <!-- ── Tab: Package Details ── -->
      <div v-show="activeTab === 'details'">
        <form @submit.prevent="submit" class="space-y-8">

          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-5">
            <div class="flex items-center justify-between">
              <h2 class="font-semibold text-slate-900">Package Details</h2>
              <label class="flex items-center gap-2 cursor-pointer">
                <span class="text-sm text-slate-600">Active</span>
                <div @click="form.is_active = !form.is_active"
                  class="relative w-10 h-5 rounded-full transition-colors cursor-pointer"
                  :class="form.is_active ? 'bg-blue-500' : 'bg-slate-300'">
                  <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"
                    :class="form.is_active ? 'translate-x-5' : ''"></div>
                </div>
              </label>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Title <span class="text-red-500">*</span></label>
              <input v-model="form.title" type="text" class="input-field"
                :class="{ 'border-red-400': errors.title }" />
              <p v-if="errors.title" class="text-red-500 text-xs mt-1">{{ errors.title }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Category</label>
                <select v-model="form.category_id" class="input-field">
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Type</label>
                <select v-model="form.package_type_id" class="input-field">
                  <option v-for="pt in packageTypes" :key="pt.id" :value="pt.id">{{ pt.name }}</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Description <span class="text-red-500">*</span></label>
              <textarea v-model="form.description" rows="4" class="input-field resize-none"></textarea>
              <p v-if="errors.description" class="text-red-500 text-xs mt-1">{{ errors.description }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Requirements</label>
              <textarea v-model="form.requirements" rows="2" class="input-field resize-none"
                placeholder="Prerequisites for students (optional)"></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Learning Outcomes</label>
              <textarea v-model="form.outcomes" rows="2" class="input-field resize-none"
                placeholder="What students will achieve (optional)"></textarea>
            </div>
          </div>

          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-5">
            <h2 class="font-semibold text-slate-900">Pricing & Structure</h2>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Price</label>
                <div class="flex gap-2">
                  <select v-model="form.currency" class="input-field w-24 flex-shrink-0">
                    <option value="USD">USD</option>
                    <option value="INR">INR</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                  </select>
                  <input v-model="form.price" type="number" min="0" step="0.01" class="input-field flex-1" />
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Level</label>
                <select v-model="form.level" class="input-field">
                  <option value="all">All Levels</option>
                  <option value="beginner">Beginner</option>
                  <option value="intermediate">Intermediate</option>
                  <option value="advanced">Advanced</option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Sessions</label>
                <input v-model="form.sessions" type="number" min="1" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Duration (min)</label>
                <input v-model="form.duration" type="number" min="15" step="15" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Max Students</label>
                <input v-model="form.max_students" type="number" min="1" class="input-field" />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Language</label>
              <select v-model="form.language" class="input-field w-48">
                <option value="en">English</option>
                <option value="hi">Hindi</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
                <option value="de">German</option>
              </select>
            </div>
          </div>

          <!-- Images -->
          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-5">
            <h2 class="font-semibold text-slate-900">Images</h2>

            <div class="grid grid-cols-2 gap-6">
              <!-- Thumbnail -->
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Thumbnail
                  <span class="text-xs text-slate-400 font-normal ml-1">(listing cards)</span>
                </label>
                <div @click="$refs.thumbnailInput.click()"
                  class="relative cursor-pointer border-2 border-dashed border-slate-200 rounded-xl overflow-hidden hover:border-blue-300 transition-colors"
                  style="height: 160px;">
                  <img v-if="thumbnailPreview || package.thumbnail_url"
                    :src="thumbnailPreview || package.thumbnail_url"
                    class="w-full h-full object-cover" />
                  <div v-else class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                    <svg class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs">Click to upload (400×300)</span>
                  </div>
                  <div v-if="thumbnailPreview || package.thumbnail_url"
                    class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="text-white text-sm font-medium">Change Image</span>
                  </div>
                </div>
                <input ref="thumbnailInput" type="file" accept="image/*" class="hidden" @change="onThumbnail" />
              </div>

              <!-- Banner -->
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Banner
                  <span class="text-xs text-slate-400 font-normal ml-1">(package detail page)</span>
                </label>
                <div @click="$refs.bannerInput.click()"
                  class="relative cursor-pointer border-2 border-dashed border-slate-200 rounded-xl overflow-hidden hover:border-blue-300 transition-colors"
                  style="height: 160px;">
                  <img v-if="bannerPreview || package.banner_url"
                    :src="bannerPreview || package.banner_url"
                    class="w-full h-full object-cover" />
                  <div v-else class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                    <svg class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs">Click to upload (1200×400)</span>
                  </div>
                  <div v-if="bannerPreview || package.banner_url"
                    class="absolute inset-0 bg-slate-900/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="text-white text-sm font-medium">Change Image</span>
                  </div>
                </div>
                <input ref="bannerInput" type="file" accept="image/*" class="hidden" @change="onBanner" />
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <Link href="/mentor/packages" class="btn-secondary">← Back</Link>
            <button type="submit" class="btn-primary px-8" :disabled="submitting">
              <svg v-if="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
              </svg>
              {{ submitting ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>
        </form>
      </div>

      <!-- ── Tab: Topics ── -->
      <div v-show="activeTab === 'topics'" class="space-y-6">

        <!-- Add topic form -->
        <div class="bg-white rounded-xl border border-slate-200 p-6">
          <h2 class="font-semibold text-slate-900 mb-4">Add Topic</h2>
          <form @submit.prevent="addTopic" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Topic Title <span class="text-red-500">*</span></label>
              <input v-model="topicForm.title" type="text" placeholder="e.g. Introduction to Data Warehouse"
                class="input-field" />
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
              <textarea v-model="topicForm.description" rows="2" class="input-field resize-none"
                placeholder="What will be covered in this topic? (optional)"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Session #</label>
                <input v-model="topicForm.session_number" type="number" min="1" placeholder="1"
                  class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Duration (min)</label>
                <input v-model="topicForm.duration" type="number" min="1" placeholder="60"
                  class="input-field" />
              </div>
            </div>
            <div class="flex justify-end">
              <button type="submit" class="btn-primary" :disabled="!topicForm.title.trim() || addingTopic">
                <svg v-if="addingTopic" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Add Topic
              </button>
            </div>
          </form>
        </div>

        <!-- Topics list -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-slate-900">Curriculum</h2>
            <span class="text-sm text-slate-500">{{ topics.length }} topic{{ topics.length !== 1 ? 's' : '' }}</span>
          </div>

          <div v-if="topics.length === 0" class="py-12 text-center text-slate-500">
            <div class="text-4xl mb-3">📋</div>
            <p class="text-sm">No topics yet. Add your first topic above.</p>
          </div>

          <div v-else class="divide-y divide-slate-100">
            <div v-for="(topic, idx) in topics" :key="topic.id" class="px-6 py-4">
              <!-- View mode -->
              <div v-if="editingTopicId !== topic.id" class="flex items-start gap-4">
                <div class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                  {{ idx + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                  <h4 class="font-medium text-slate-900 text-sm">{{ topic.title }}</h4>
                  <p v-if="topic.description" class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ topic.description }}</p>
                  <div class="flex items-center gap-3 mt-1.5 text-xs text-slate-400">
                    <span v-if="topic.session_number">Session {{ topic.session_number }}</span>
                    <span v-if="topic.duration">{{ topic.duration }} min</span>
                  </div>
                </div>
                <div class="flex items-center gap-1 flex-shrink-0">
                  <button @click="startEditTopic(topic)"
                    class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button @click="deleteTopic(topic)"
                    class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Edit mode -->
              <div v-else class="bg-blue-50 rounded-xl p-4 space-y-3">
                <input v-model="editTopicForm.title" type="text" class="input-field text-sm"
                  placeholder="Topic title" />
                <textarea v-model="editTopicForm.description" rows="2" class="input-field text-sm resize-none"
                  placeholder="Description (optional)"></textarea>
                <div class="grid grid-cols-2 gap-3">
                  <input v-model="editTopicForm.session_number" type="number" min="1" class="input-field text-sm"
                    placeholder="Session #" />
                  <input v-model="editTopicForm.duration" type="number" min="1" class="input-field text-sm"
                    placeholder="Duration (min)" />
                </div>
                <div class="flex gap-2 justify-end">
                  <button @click="editingTopicId = null" class="btn-secondary text-sm py-1.5 px-4">Cancel</button>
                  <button @click="saveTopicEdit(topic)" class="btn-primary text-sm py-1.5 px-4">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  package: Object,
  categories: Array,
  packageTypes: Array,
});

const tabs = [
  { id: 'details', label: 'Package Details' },
  { id: 'topics',  label: 'Topics & Curriculum' },
];
const activeTab = ref('details');

// ── Package form ──
const form = reactive({
  title:           props.package.title,
  description:     props.package.description,
  requirements:    props.package.requirements || '',
  outcomes:        props.package.outcomes || '',
  category_id:     props.package.category_id,
  package_type_id: props.package.package_type_id,
  price:           props.package.price,
  currency:        props.package.currency,
  duration:        props.package.duration,
  sessions:        props.package.sessions,
  max_students:    props.package.max_students,
  level:           props.package.level,
  language:        props.package.language,
  is_active:       props.package.is_active,
});

const errors = ref({});
const submitting = ref(false);
const thumbnailPreview = ref(null);
const bannerPreview = ref(null);
const thumbnailFile = ref(null);
const bannerFile = ref(null);

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
  data.append('_method', 'POST');
  if (thumbnailFile.value) data.append('thumbnail', thumbnailFile.value);
  if (bannerFile.value) data.append('banner', bannerFile.value);

  router.post(`/mentor/packages/${props.package.id}`, data, {
    onError: (e) => { errors.value = e; },
    onFinish: () => { submitting.value = false; },
  });
}

// ── Topics ──
const topics = ref([...(props.package.topics || [])]);

const topicForm = reactive({ title: '', description: '', session_number: '', duration: '' });
const addingTopic = ref(false);
const editingTopicId = ref(null);
const editTopicForm = reactive({ title: '', description: '', session_number: '', duration: '' });

function addTopic() {
  if (!topicForm.title.trim()) return;
  addingTopic.value = true;
  router.post(`/mentor/packages/${props.package.id}/topics`, { ...topicForm }, {
    onSuccess: () => {
      Object.keys(topicForm).forEach(k => topicForm[k] = '');
    },
    onFinish: () => { addingTopic.value = false; },
    preserveScroll: true,
  });
}

function startEditTopic(topic) {
  editingTopicId.value = topic.id;
  editTopicForm.title          = topic.title;
  editTopicForm.description    = topic.description || '';
  editTopicForm.session_number = topic.session_number || '';
  editTopicForm.duration       = topic.duration || '';
}

function saveTopicEdit(topic) {
  router.put(`/mentor/packages/${props.package.id}/topics/${topic.id}`, { ...editTopicForm }, {
    onSuccess: () => { editingTopicId.value = null; },
    preserveScroll: true,
  });
}

function deleteTopic(topic) {
  if (!confirm(`Delete topic "${topic.title}"?`)) return;
  router.delete(`/mentor/packages/${props.package.id}/topics/${topic.id}`, { preserveScroll: true });
}
</script>
