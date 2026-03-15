<template>
  <AppLayout>
    <Head title="Edit Profile" />

    <!-- Header -->
    <div class="bg-white border-b border-slate-200">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
        <div>
          <h1 class="text-xl font-bold text-slate-900">My Profile</h1>
          <p class="text-sm text-slate-500 mt-0.5">Keep your profile up to date so students can find and trust you</p>
        </div>
        <a :href="`/mentors/${mentor.slug}`" target="_blank"
          class="text-sm text-blue-600 hover:underline flex items-center gap-1">
          View public profile
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
        </a>
      </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border-b border-slate-100 sticky top-16 z-30">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 overflow-x-auto">
        <div class="flex gap-0 min-w-max">
          <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
            class="flex items-center gap-2 px-4 py-3.5 text-sm font-medium border-b-2 transition-colors whitespace-nowrap"
            :class="activeTab === tab.id
              ? 'border-blue-500 text-blue-600'
              : 'border-transparent text-slate-500 hover:text-slate-700'">
            <span>{{ tab.icon }}</span>
            {{ tab.label }}
          </button>
        </div>
      </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

      <!-- ─── Tab: Summary ─── -->
      <div v-show="activeTab === 'summary'">
        <form @submit.prevent="saveSummary" class="space-y-6">
          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-5">
            <h2 class="font-semibold text-slate-900">Basic Info</h2>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Professional Title</label>
                <input v-model="summary.title" type="text"
                  placeholder="e.g. Senior Data Architect · 12 yrs exp"
                  class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Years of Experience</label>
                <input v-model="summary.years_experience" type="number" min="0" max="60" class="input-field" />
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Location</label>
                <input v-model="summary.location" type="text" placeholder="e.g. Bangalore, India" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Country</label>
                <input v-model="summary.country" type="text" placeholder="India" class="input-field" />
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Hourly Rate</label>
                <div class="flex gap-2">
                  <select v-model="summary.currency" class="input-field w-24 flex-shrink-0">
                    <option value="USD">USD</option>
                    <option value="INR">INR</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                  </select>
                  <input v-model="summary.hourly_rate" type="number" min="0" placeholder="0" class="input-field flex-1" />
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Timezone</label>
                <input v-model="summary.timezone" type="text" placeholder="Asia/Kolkata" class="input-field" />
              </div>
            </div>
          </div>

          <!-- About Me -->
          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">About Me</h2>
            <textarea v-model="summary.bio" rows="6" class="input-field resize-none"
              placeholder="Write a compelling bio that tells students who you are, what you've done, and why they should learn from you..."></textarea>
            <p class="text-xs text-slate-400">{{ summary.bio?.length || 0 }} / 3000 characters</p>
          </div>

          <!-- Categories -->
          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">Mentorship Categories</h2>
            <p class="text-sm text-slate-500">Select all categories you mentor in</p>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
              <button v-for="cat in categories" :key="cat.id" type="button"
                @click="toggleCategory(cat.id)"
                class="text-left px-3.5 py-2.5 rounded-xl border-2 text-sm transition-all"
                :class="summary.category_ids.includes(cat.id)
                  ? 'border-blue-500 bg-blue-50 text-blue-700 font-semibold'
                  : 'border-slate-200 text-slate-600 hover:border-slate-300'">
                {{ cat.name }}
              </button>
            </div>
          </div>

          <!-- Skills -->
          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">Skills</h2>
            <!-- Tag display -->
            <div class="flex flex-wrap gap-2 min-h-[36px]">
              <span v-for="skill in summary.skills" :key="skill"
                class="flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 text-sm rounded-full font-medium border border-blue-200">
                {{ skill }}
                <button type="button" @click="removeSkill(skill)"
                  class="text-blue-400 hover:text-blue-700 leading-none">×</button>
              </span>
              <span v-if="summary.skills.length === 0" class="text-sm text-slate-400 py-1">No skills added yet</span>
            </div>
            <!-- Skill input -->
            <div class="flex gap-2">
              <input v-model="newSkill" type="text" placeholder="Type a skill and press Enter (e.g. Apache Kafka)"
                class="input-field flex-1"
                @keydown.enter.prevent="addSkill"
                @keydown.comma.prevent="addSkill" />
              <button type="button" @click="addSkill" class="btn-secondary px-4 flex-shrink-0">Add</button>
            </div>
            <p class="text-xs text-slate-400">Press Enter or comma to add a skill</p>
          </div>

          <!-- Social Links -->
          <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">Links</h2>
            <div class="space-y-3">
              <div class="flex items-center gap-3">
                <span class="w-24 text-sm text-slate-500 flex-shrink-0">LinkedIn</span>
                <input v-model="summary.linkedin" type="text" placeholder="https://linkedin.com/in/yourprofile"
                  class="input-field flex-1" />
              </div>
              <div class="flex items-center gap-3">
                <span class="w-24 text-sm text-slate-500 flex-shrink-0">Twitter</span>
                <input v-model="summary.twitter" type="text" placeholder="https://twitter.com/yourhandle"
                  class="input-field flex-1" />
              </div>
              <div class="flex items-center gap-3">
                <span class="w-24 text-sm text-slate-500 flex-shrink-0">Website</span>
                <input v-model="summary.website" type="text" placeholder="https://yourwebsite.com"
                  class="input-field flex-1" />
              </div>
            </div>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="btn-primary px-8" :disabled="savingSummary">
              <svg v-if="savingSummary" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
              </svg>
              {{ savingSummary ? 'Saving...' : 'Save Summary' }}
            </button>
          </div>
        </form>
      </div>

      <!-- ─── Tab: Profile Picture ─── -->
      <div v-show="activeTab === 'photo'">
        <div class="bg-white rounded-xl border border-slate-200 p-8 max-w-md mx-auto text-center space-y-6">
          <h2 class="font-semibold text-slate-900 text-left">Profile Photo</h2>

          <!-- Current photo -->
          <div class="flex flex-col items-center gap-4">
            <div class="relative">
              <img :src="photoPreview || mentor.profile_photo_url" :alt="mentor.name"
                class="w-36 h-36 rounded-full object-cover ring-4 ring-slate-200" />
              <button @click="$refs.photoInput.click()"
                class="absolute bottom-0 right-0 w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </button>
            </div>
            <div class="text-left w-full">
              <p class="text-sm font-semibold text-slate-700">{{ mentor.name }}</p>
              <p class="text-xs text-slate-500">{{ mentor.title || 'No title set' }}</p>
            </div>
          </div>

          <input ref="photoInput" type="file" accept="image/*" class="hidden" @change="onPhotoSelect" />

          <div @click="$refs.photoInput.click()"
            class="border-2 border-dashed border-slate-200 hover:border-blue-300 rounded-xl p-6 cursor-pointer transition-colors text-center">
            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm text-slate-500">Click to upload a new photo</p>
            <p class="text-xs text-slate-400 mt-1">JPG or PNG · max 4MB · square works best</p>
          </div>

          <button v-if="photoFile" @click="savePhoto" class="btn-primary w-full" :disabled="savingPhoto">
            {{ savingPhoto ? 'Uploading...' : 'Upload Photo' }}
          </button>
        </div>
      </div>

      <!-- ─── Tab: Education ─── -->
      <div v-show="activeTab === 'education'">
        <SectionEditor
          title="Education"
          :items="educationList"
          @save="saveEducation"
          @delete="deleteEducation"
        >
          <template #form="{ form, isEdit }">
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Institution <span class="text-red-500">*</span></label>
                <input v-model="form.institution" type="text" placeholder="University / College / School" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Degree <span class="text-red-500">*</span></label>
                <input v-model="form.degree" type="text" placeholder="e.g. Bachelor of Technology" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Field of Study</label>
                <input v-model="form.field_of_study" type="text" placeholder="e.g. Computer Science" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Start Year <span class="text-red-500">*</span></label>
                <input v-model="form.start_year" type="number" min="1950" max="2030" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">End Year</label>
                <input v-model="form.end_year" type="number" min="1950" max="2030" :disabled="form.is_current" class="input-field disabled:opacity-50" />
                <label class="flex items-center gap-2 mt-1.5 cursor-pointer">
                  <input type="checkbox" v-model="form.is_current" class="rounded" />
                  <span class="text-xs text-slate-500">Currently enrolled</span>
                </label>
              </div>
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                <textarea v-model="form.description" rows="2" class="input-field resize-none"
                  placeholder="Activities, achievements, thesis topic... (optional)"></textarea>
              </div>
            </div>
          </template>
          <template #item="{ item }">
            <div class="font-medium text-slate-900">{{ item.degree }} · {{ item.institution }}</div>
            <div class="text-sm text-slate-500">{{ item.field_of_study }} · {{ item.start_year }} – {{ item.is_current ? 'Present' : item.end_year }}</div>
          </template>
        </SectionEditor>
      </div>

      <!-- ─── Tab: Professional ─── -->
      <div v-show="activeTab === 'professional'">
        <SectionEditor
          title="Work Experience"
          :items="professionalList"
          @save="saveProfessional"
          @delete="deleteProfessional"
        >
          <template #form="{ form }">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Company <span class="text-red-500">*</span></label>
                <input v-model="form.company" type="text" placeholder="Company name" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Position <span class="text-red-500">*</span></label>
                <input v-model="form.position" type="text" placeholder="Your role / title" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Location</label>
                <input v-model="form.location" type="text" placeholder="City, Country" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Start Date <span class="text-red-500">*</span></label>
                <input v-model="form.start_date" type="month" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">End Date</label>
                <input v-model="form.end_date" type="month" :disabled="form.is_current" class="input-field disabled:opacity-50" />
                <label class="flex items-center gap-2 mt-1.5 cursor-pointer">
                  <input type="checkbox" v-model="form.is_current" class="rounded" />
                  <span class="text-xs text-slate-500">Currently working here</span>
                </label>
              </div>
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                <textarea v-model="form.description" rows="2" class="input-field resize-none"
                  placeholder="Key responsibilities and achievements..."></textarea>
              </div>
            </div>
          </template>
          <template #item="{ item }">
            <div class="font-medium text-slate-900">{{ item.position }} · {{ item.company }}</div>
            <div class="text-sm text-slate-500">{{ item.location }} · {{ formatDate(item.start_date) }} – {{ item.is_current ? 'Present' : formatDate(item.end_date) }}</div>
          </template>
        </SectionEditor>
      </div>

      <!-- ─── Tab: Achievements ─── -->
      <div v-show="activeTab === 'achievements'">
        <SectionEditor
          title="Achievements"
          :items="achievementList"
          @save="saveAchievement"
          @delete="deleteAchievement"
        >
          <template #form="{ form }">
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input v-model="form.title" type="text" placeholder="e.g. Speaker at KafkaSummit 2023" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Issuer / Organisation</label>
                <input v-model="form.issuer" type="text" placeholder="e.g. Apache Foundation" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Date</label>
                <input v-model="form.date" type="date" class="input-field" />
              </div>
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                <textarea v-model="form.description" rows="2" class="input-field resize-none"
                  placeholder="Brief description of this achievement..."></textarea>
              </div>
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">URL</label>
                <input v-model="form.url" type="text" placeholder="Link to achievement (optional)" class="input-field" />
              </div>
            </div>
          </template>
          <template #item="{ item }">
            <div class="font-medium text-slate-900">{{ item.title }}</div>
            <div class="text-sm text-slate-500">{{ item.issuer }} {{ item.date ? '· ' + item.date : '' }}</div>
          </template>
        </SectionEditor>
      </div>

      <!-- ─── Tab: Certifications ─── -->
      <div v-show="activeTab === 'certifications'">
        <SectionEditor
          title="Certifications"
          :items="certificationList"
          @save="saveCertification"
          @delete="deleteCertification"
        >
          <template #form="{ form }">
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Certification Name <span class="text-red-500">*</span></label>
                <input v-model="form.name" type="text" placeholder="e.g. AWS Certified Solutions Architect" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Issuing Organisation <span class="text-red-500">*</span></label>
                <input v-model="form.issuing_org" type="text" placeholder="e.g. Amazon Web Services" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Credential ID</label>
                <input v-model="form.credential_id" type="text" placeholder="Certificate ID / number" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Issue Date</label>
                <input v-model="form.issue_date" type="date" class="input-field" />
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Expiry Date</label>
                <input v-model="form.expiry_date" type="date" :disabled="form.no_expiry" class="input-field disabled:opacity-50" />
                <label class="flex items-center gap-2 mt-1.5 cursor-pointer">
                  <input type="checkbox" v-model="form.no_expiry" class="rounded" />
                  <span class="text-xs text-slate-500">No expiry</span>
                </label>
              </div>
              <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Credential URL</label>
                <input v-model="form.credential_url" type="text" placeholder="https://verify.cert.com/..." class="input-field" />
              </div>
            </div>
          </template>
          <template #item="{ item }">
            <div class="font-medium text-slate-900">{{ item.name }}</div>
            <div class="text-sm text-slate-500">{{ item.issuing_org }} {{ item.issue_date ? '· ' + item.issue_date : '' }} {{ item.no_expiry ? '· No expiry' : (item.expiry_date ? '· Expires ' + item.expiry_date : '') }}</div>
          </template>
        </SectionEditor>
      </div>

    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionEditor from '@/Components/Mentor/SectionEditor.vue';

const props = defineProps({
  mentor: Object,
  categories: Array,
});

const tabs = [
  { id: 'summary',        label: 'Summary',        icon: '👤' },
  { id: 'photo',          label: 'Profile Photo',   icon: '📷' },
  { id: 'education',      label: 'Education',       icon: '🎓' },
  { id: 'professional',   label: 'Experience',      icon: '💼' },
  { id: 'achievements',   label: 'Achievements',    icon: '🏆' },
  { id: 'certifications', label: 'Certifications',  icon: '📜' },
];

const activeTab = ref('summary');

// ── Summary ──
const summary = reactive({
  title:            props.mentor.title || '',
  bio:              props.mentor.bio || '',
  location:         props.mentor.location || '',
  country:          props.mentor.country || '',
  timezone:         props.mentor.timezone || '',
  hourly_rate:      props.mentor.hourly_rate || '',
  currency:         props.mentor.currency || 'USD',
  years_experience: props.mentor.years_experience || '',
  linkedin:         props.mentor.linkedin || '',
  twitter:          props.mentor.twitter || '',
  website:          props.mentor.website || '',
  category_ids:     (props.mentor.categories || []).map(c => c.id),
  skills:           (props.mentor.skills || []).map(s => s.name),
});

const newSkill = ref('');
const savingSummary = ref(false);

function toggleCategory(id) {
  const idx = summary.category_ids.indexOf(id);
  if (idx === -1) summary.category_ids.push(id);
  else summary.category_ids.splice(idx, 1);
}

function addSkill() {
  const s = newSkill.value.replace(',', '').trim();
  if (s && !summary.skills.includes(s)) summary.skills.push(s);
  newSkill.value = '';
}

function removeSkill(skill) {
  summary.skills = summary.skills.filter(s => s !== skill);
}

function saveSummary() {
  savingSummary.value = true;
  router.post('/mentor/profile', { ...summary }, {
    preserveScroll: true,
    onFinish: () => { savingSummary.value = false; },
  });
}

// ── Photo ──
const photoPreview = ref(null);
const photoFile    = ref(null);
const savingPhoto  = ref(false);

function onPhotoSelect(e) {
  const file = e.target.files[0];
  if (!file) return;
  photoFile.value    = file;
  photoPreview.value = URL.createObjectURL(file);
}

function savePhoto() {
  if (!photoFile.value) return;
  savingPhoto.value = true;
  const data = new FormData();
  data.append('photo', photoFile.value);
  router.post('/mentor/profile/photo', data, {
    preserveScroll: true,
    onSuccess: () => { photoFile.value = null; },
    onFinish: () => { savingPhoto.value = false; },
  });
}

// ── Education ──
const educationList = ref([...(props.mentor.education || [])]);

function saveEducation({ form, item, done }) {
  const url  = item ? `/mentor/education/${item.id}` : '/mentor/education';
  const method = item ? 'put' : 'post';
  router[method](url, form, { preserveScroll: true, onSuccess: done });
}
function deleteEducation({ item, done }) {
  router.delete(`/mentor/education/${item.id}`, { preserveScroll: true, onSuccess: done });
}

// ── Professional ──
const professionalList = ref([...(props.mentor.professionals || [])]);

function saveProfessional({ form, item, done }) {
  const url = item ? `/mentor/professional/${item.id}` : '/mentor/professional';
  const method = item ? 'put' : 'post';
  router[method](url, form, { preserveScroll: true, onSuccess: done });
}
function deleteProfessional({ item, done }) {
  router.delete(`/mentor/professional/${item.id}`, { preserveScroll: true, onSuccess: done });
}

// ── Achievement ──
const achievementList = ref([...(props.mentor.achievements || [])]);

function saveAchievement({ form, item, done }) {
  const url = item ? `/mentor/achievement/${item.id}` : '/mentor/achievement';
  const method = item ? 'put' : 'post';
  router[method](url, form, { preserveScroll: true, onSuccess: done });
}
function deleteAchievement({ item, done }) {
  router.delete(`/mentor/achievement/${item.id}`, { preserveScroll: true, onSuccess: done });
}

// ── Certificate ──
const certificationList = ref([...(props.mentor.certificates || [])]);

function saveCertification({ form, item, done }) {
  const url = item ? `/mentor/certificate/${item.id}` : '/mentor/certificate';
  const method = item ? 'put' : 'post';
  router[method](url, form, { preserveScroll: true, onSuccess: done });
}
function deleteCertification({ item, done }) {
  router.delete(`/mentor/certificate/${item.id}`, { preserveScroll: true, onSuccess: done });
}

function formatDate(d) {
  if (!d) return '';
  return d.toString().slice(0, 7);
}
</script>

