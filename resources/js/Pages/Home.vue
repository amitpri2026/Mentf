<template>
  <AppLayout>
    <Head title="Find Your Perfect Mentor" />

    <!-- Hero Section - clean light design -->
    <section class="bg-white border-b border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16 lg:pt-12 lg:pb-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

          <!-- Left: Copy -->
          <div>
            <!-- Animated category pill — bigger, two-tone -->
            <div class="inline-flex items-center rounded-2xl border border-slate-200 bg-white shadow-sm mb-7 overflow-hidden">
              <span class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest text-slate-400 whitespace-nowrap">
                ✦ Mentoring for
              </span>
              <span class="relative flex items-center bg-blue-600 text-white overflow-hidden" style="min-width:200px; height:42px;">
                <transition name="pill-swap">
                  <span
                    :key="currentCatIndex"
                    class="absolute inset-0 flex items-center gap-2.5 px-4 font-semibold text-sm whitespace-nowrap"
                  >
                    <span class="text-xl leading-none">{{ pillCategories[currentCatIndex].emoji }}</span>
                    <span>{{ pillCategories[currentCatIndex].label }}</span>
                  </span>
                </transition>
              </span>
            </div>

            <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight tracking-tight mb-5">
              Accelerate your growth with
              <span class="text-blue-600"> the right mentor</span>
            </h1>

            <p class="text-lg text-slate-500 leading-relaxed mb-8 max-w-lg">
              Connect with industry experts across {{ stats.categories }} categories. Get personalized 1-on-1 guidance, group programs, and career coaching tailored to your goals.
            </p>

            <!-- Search bar -->
            <div class="flex gap-2 mb-8 bg-white border-2 border-slate-200 rounded-xl p-1.5 focus-within:border-blue-400 transition-colors max-w-lg">
              <svg class="w-5 h-5 text-slate-400 self-center ml-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <input
                v-model="searchQuery"
                @keyup.enter="doSearch"
                type="text"
                placeholder="Search mentors, skills, topics..."
                class="flex-1 px-2 py-2 text-slate-900 bg-transparent border-0 shadow-none focus:outline-none focus:ring-0 text-sm"
              />
              <button @click="doSearch" class="btn-primary text-sm px-5 py-2 shrink-0">
                Search
              </button>
            </div>

            <!-- CTAs -->
            <div class="flex flex-wrap gap-3">
              <Link href="/mentors" class="btn-primary text-sm px-6 py-2.5">
                Find a Mentor
              </Link>
              <Link href="/register?role=mentor" class="btn-secondary text-sm px-6 py-2.5">
                Become a Mentor
              </Link>
            </div>

            <!-- Social proof -->
            <div class="flex items-center gap-4 mt-8 pt-8 border-t border-slate-100">
              <div class="flex -space-x-2">
                <div v-for="i in 4" :key="i" class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-300 to-slate-300 border-2 border-white flex items-center justify-center text-xs font-bold text-white">
                  {{ String.fromCharCode(65 + i) }}
                </div>
              </div>
              <div>
                <div class="flex items-center gap-0.5 mb-0.5">
                  <svg v-for="i in 5" :key="i" class="w-3.5 h-3.5 text-amber-400 fill-amber-400" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </div>
                <p class="text-xs text-slate-500">Trusted by <strong class="text-slate-700">{{ stats.students }}+</strong> learners</p>
              </div>
            </div>
          </div>

          <!-- Right: Stacked mentor profiles (changes with category, from real data) -->
          <div class="relative hidden lg:block">
            <!-- Background blob -->
            <div class="absolute -inset-6 bg-gradient-to-br from-blue-50 via-white to-slate-50 rounded-3xl"></div>

            <!-- Card stack wrapper -->
            <div class="relative" style="height: 340px;">
              <transition name="stack-swap" mode="out-in">
                <div :key="currentCatIndex" class="absolute inset-0">

                  <!-- Card 3 — bottom of stack -->
                  <div class="absolute bottom-0 left-4 right-4 bg-white rounded-2xl border border-slate-200 shadow-sm p-4 opacity-50"
                    style="transform: rotate(-2.5deg) translateY(8px);">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold text-white shrink-0"
                        :style="{ background: pillCategories[currentCatIndex].gradient }">
                        {{ pillCategories[currentCatIndex].profiles[2].initial }}
                      </div>
                      <div>
                        <p class="font-semibold text-slate-900 text-sm">{{ pillCategories[currentCatIndex].profiles[2].name }}</p>
                        <p class="text-xs text-slate-400">{{ pillCategories[currentCatIndex].profiles[2].title }}</p>
                      </div>
                    </div>
                  </div>

                  <!-- Card 2 — middle -->
                  <div class="absolute bottom-10 left-2 right-2 bg-white rounded-2xl border border-slate-200 shadow-md p-4 opacity-80"
                    style="transform: rotate(1.5deg) translateY(4px);">
                    <div class="flex items-center gap-3">
                      <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-bold text-white shrink-0"
                        :style="{ background: pillCategories[currentCatIndex].gradient }">
                        {{ pillCategories[currentCatIndex].profiles[1].initial }}
                      </div>
                      <div class="flex-1">
                        <p class="font-semibold text-slate-900 text-sm">{{ pillCategories[currentCatIndex].profiles[1].name }}</p>
                        <p class="text-xs text-slate-500">{{ pillCategories[currentCatIndex].profiles[1].title }}</p>
                      </div>
                      <span v-if="pillCategories[currentCatIndex].profiles[1].rate" class="text-sm font-bold text-slate-700">₹{{ pillCategories[currentCatIndex].profiles[1].rate }}<span class="text-xs font-normal text-slate-400">/hr</span></span>
                    </div>
                  </div>

                  <!-- Card 1 — top, full detail -->
                  <div class="absolute bottom-24 left-0 right-0 bg-white rounded-2xl border border-slate-200 shadow-xl p-5">
                    <!-- Category badge -->
                    <div class="flex items-center justify-between mb-4">
                      <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full"
                        :style="{ background: pillCategories[currentCatIndex].badgeBg, color: pillCategories[currentCatIndex].badgeColor }">
                        <span>{{ pillCategories[currentCatIndex].emoji }}</span>
                        {{ pillCategories[currentCatIndex].label }}
                      </span>
                      <div v-if="pillCategories[currentCatIndex].profiles[0].reviews > 0" class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-400" viewBox="0 0 20 20">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-xs font-bold text-slate-700">{{ pillCategories[currentCatIndex].profiles[0].rating }}</span>
                        <span class="text-xs text-slate-400">({{ pillCategories[currentCatIndex].profiles[0].reviews }})</span>
                      </div>
                    </div>
                    <!-- Mentor info -->
                    <div class="flex items-center gap-3 mb-4">
                      <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl font-bold text-white shrink-0"
                        :style="{ background: pillCategories[currentCatIndex].gradient }">
                        {{ pillCategories[currentCatIndex].profiles[0].initial }}
                      </div>
                      <div>
                        <h3 class="font-bold text-slate-900 text-base">{{ pillCategories[currentCatIndex].profiles[0].name }}</h3>
                        <p class="text-sm font-medium" :style="{ color: pillCategories[currentCatIndex].badgeColor }">{{ pillCategories[currentCatIndex].profiles[0].title }}</p>
                      </div>
                    </div>
                    <!-- Skills -->
                    <div v-if="pillCategories[currentCatIndex].profiles[0].skills?.length" class="flex flex-wrap gap-1.5 mb-4">
                      <span v-for="skill in pillCategories[currentCatIndex].profiles[0].skills" :key="skill"
                        class="text-xs bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-md font-medium">{{ skill }}</span>
                    </div>
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                      <div v-if="pillCategories[currentCatIndex].profiles[0].rate">
                        <span class="text-lg font-bold text-slate-900">₹{{ pillCategories[currentCatIndex].profiles[0].rate }}</span>
                        <span class="text-sm text-slate-400">/hr</span>
                      </div>
                      <div v-else></div>
                      <Link href="/mentors" class="btn-primary text-xs px-4 py-2">View Profile</Link>
                    </div>
                  </div>

                </div>
              </transition>
            </div>

            <!-- Mini stats strip -->
            <div class="relative grid grid-cols-3 gap-3 mt-4">
              <div v-for="s in heroStats" :key="s.label" class="bg-white rounded-xl border border-slate-200 p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-blue-600">{{ s.value }}</div>
                <div class="text-xs text-slate-500 mt-0.5">{{ s.label }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Company logos strip -->
    <section class="bg-slate-50 border-b border-slate-100 py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs font-semibold text-slate-400 uppercase tracking-wider mb-5">Mentors from leading companies</p>
        <div class="flex flex-wrap justify-center items-center gap-8 lg:gap-12">
          <span v-for="co in ['Google', 'Microsoft', 'Amazon', 'Meta', 'Apple', 'Netflix']" :key="co"
            class="text-slate-400 font-bold text-lg tracking-tight hover:text-slate-600 transition-colors cursor-default">
            {{ co }}
          </span>
        </div>
      </div>
    </section>

    <!-- Stats bar -->
    <section class="bg-white border-b border-slate-100 py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="stat in statCards" :key="stat.label" class="text-center">
            <div class="text-3xl font-bold text-slate-900 mb-1">{{ stat.value }}</div>
            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Dual CTA boxes -->
    <section class="bg-white py-14 border-b border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-5">
          <div class="rounded-2xl border border-blue-100 bg-blue-50 p-8">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl mb-5">🎓</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Looking for a Mentor?</h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-5">
              Get help from any industry expert. Take a one-hour consulting session or an entire month training program.
            </p>
            <Link href="/mentors" class="btn-primary text-sm px-6 py-2.5 inline-flex">Find a Mentor</Link>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8">
            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-2xl mb-5">💡</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Share Your Expertise</h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-5">
              Help others with your hard-earned skills through consulting, training, and ongoing mentorship programs.
            </p>
            <Link href="/register?role=mentor" class="btn-secondary text-sm px-6 py-2.5 inline-flex">Start Mentoring</Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="bg-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
          <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Browse by Category</h2>
            <p class="text-slate-500 mt-2">{{ categories.length }} areas of expertise</p>
          </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
          <Link
            v-for="cat in categories"
            :key="cat.id"
            :href="`/categories/${cat.slug}`"
            class="group flex items-center gap-4 p-5 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50 hover:shadow-md transition-all duration-150 bg-white"
          >
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl bg-slate-50 group-hover:bg-white shrink-0 transition-colors shadow-sm">
              {{ getCatEmoji(cat.slug) }}
            </div>
            <div>
              <span class="text-sm font-semibold text-slate-800 group-hover:text-blue-700 transition-colors leading-snug block">{{ cat.name }}</span>
              <span class="text-xs text-slate-400 mt-0.5 block">
                {{ cat.mentors_count }} mentor{{ cat.mentors_count !== 1 ? 's' : '' }}
              </span>
            </div>
          </Link>
        </div>
      </div>
    </section>

    <!-- Featured Mentors -->
    <section class="bg-slate-50 border-y border-slate-100 py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
          <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Featured Mentors</h2>
            <p class="text-slate-500 mt-2">Learn from industry leaders</p>
          </div>
          <Link href="/mentors" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
            View all
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </Link>
        </div>
        <div v-if="featuredMentors.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          <MentorCard v-for="mentor in featuredMentors" :key="mentor.id" :mentor="mentor" />
        </div>
        <div v-else class="text-center py-12 text-slate-400 text-sm">
          No featured mentors yet. Admins can mark mentors as featured.
        </div>
      </div>
    </section>

    <!-- Popular Packages -->
    <section class="bg-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
          <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Popular Packages</h2>
            <p class="text-slate-500 mt-2">Most enrolled learning programs</p>
          </div>
          <Link href="/packages" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
            Browse all
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </Link>
        </div>
        <div v-if="popularPackages.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          <PackageCard v-for="pkg in popularPackages" :key="pkg.id" :package="pkg" />
        </div>
        <div v-else class="text-center py-12 text-slate-400 text-sm">
          No featured packages yet. Admins can mark packages as popular.
        </div>
      </div>
    </section>

    <!-- How It Works -->
    <section class="bg-slate-50 border-y border-slate-100 py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
          <h2 class="text-3xl font-bold text-slate-900 tracking-tight">How MentF Works</h2>
          <p class="text-slate-500 mt-2">Start your mentoring journey in minutes</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(step, i) in steps" :key="i" class="flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-2xl mb-4">
              {{ step.emoji }}
            </div>
            <div class="w-7 h-7 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mb-3 shadow-sm">
              {{ i + 1 }}
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-2">{{ step.title }}</h3>
            <p class="text-sm text-slate-500 leading-relaxed">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Final CTA Banner -->
    <section class="bg-slate-900 py-16">
      <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-3 tracking-tight">Ready to accelerate your growth?</h2>
        <p class="text-slate-400 mb-8 text-base">Join thousands of professionals getting mentored by industry experts.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <Link href="/register" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3.5 rounded-xl font-semibold transition-colors text-sm">
            Get Started Free
          </Link>
          <Link href="/mentors" class="bg-white/10 hover:bg-white/15 text-white border border-white/20 px-8 py-3.5 rounded-xl font-semibold transition-colors text-sm">
            Browse Mentors
          </Link>
        </div>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MentorCard from '@/Components/MentorCard.vue';
import PackageCard from '@/Components/PackageCard.vue';

const props = defineProps({
  featuredMentors: Array,
  popularPackages: Array,
  categories: Array,
  heroCategoryMentors: Object,
  stats: Object,
});

const searchQuery = ref('');

// Per-category visual config (emoji, colours, gradient)
const categoryConfig = {
  'artificial-intelligence': { emoji: '🤖', label: 'Artificial Intelligence', gradient: 'linear-gradient(135deg,#3b82f6,#1d4ed8)', badgeBg: '#dbeafe', badgeColor: '#1e40af' },
  'photography-video':       { emoji: '📷', label: 'Photography & Video',     gradient: 'linear-gradient(135deg,#f59e0b,#d97706)', badgeBg: '#fef3c7', badgeColor: '#92400e' },
  'legal':                   { emoji: '⚖️', label: 'Legal',                   gradient: 'linear-gradient(135deg,#64748b,#334155)', badgeBg: '#f1f5f9', badgeColor: '#334155' },
  'music':                   { emoji: '🎵', label: 'Music',                   gradient: 'linear-gradient(135deg,#8b5cf6,#6d28d9)', badgeBg: '#ede9fe', badgeColor: '#5b21b6' },
  'finance':                 { emoji: '💰', label: 'Finance',                 gradient: 'linear-gradient(135deg,#10b981,#047857)', badgeBg: '#d1fae5', badgeColor: '#065f46' },
  'business':                { emoji: '💼', label: 'Business',                gradient: 'linear-gradient(135deg,#0ea5e9,#0284c7)', badgeBg: '#e0f2fe', badgeColor: '#0369a1' },
  'health-fitness':          { emoji: '💪', label: 'Health & Fitness',        gradient: 'linear-gradient(135deg,#ef4444,#b91c1c)', badgeBg: '#fee2e2', badgeColor: '#991b1b' },
  'design-architecture':     { emoji: '🎨', label: 'Design',                  gradient: 'linear-gradient(135deg,#ec4899,#be185d)', badgeBg: '#fce7f3', badgeColor: '#9d174d' },
  'project-management':      { emoji: '📋', label: 'Project Management',      gradient: 'linear-gradient(135deg,#f97316,#c2410c)', badgeBg: '#ffedd5', badgeColor: '#9a3412' },
  'marketing':               { emoji: '📢', label: 'Marketing',               gradient: 'linear-gradient(135deg,#14b8a6,#0f766e)', badgeBg: '#ccfbf1', badgeColor: '#134e4a' },
  'development':             { emoji: '💻', label: 'Development',             gradient: 'linear-gradient(135deg,#6366f1,#4338ca)', badgeBg: '#eef2ff', badgeColor: '#3730a3' },
  'infrastructure':          { emoji: '☁️', label: 'Infrastructure',          gradient: 'linear-gradient(135deg,#0891b2,#0e7490)', badgeBg: '#cffafe', badgeColor: '#164e63' },
  'hr':                      { emoji: '👥', label: 'HR',                      gradient: 'linear-gradient(135deg,#a78bfa,#7c3aed)', badgeBg: '#f5f3ff', badgeColor: '#5b21b6' },
  'competitive-exams':       { emoji: '📚', label: 'Competitive Exams',       gradient: 'linear-gradient(135deg,#f43f5e,#be123c)', badgeBg: '#fff1f2', badgeColor: '#9f1239' },
};

const fallbackProfile = (catLabel) => ({
  initial: catLabel.charAt(0).toUpperCase(),
  name: 'Be the first mentor',
  title: `Join as a ${catLabel} mentor`,
  rating: '0.0',
  reviews: 0,
  rate: 0,
  skills: [],
});

// Build pillCategories from real DB data + visual config
const pillCategories = computed(() => {
  return props.categories.map(cat => {
    const cfg = categoryConfig[cat.slug] || {
      emoji: '📌', label: cat.name,
      gradient: 'linear-gradient(135deg,#6366f1,#4338ca)',
      badgeBg: '#eef2ff', badgeColor: '#3730a3',
    };
    const real = props.heroCategoryMentors?.[cat.slug] || [];
    const profiles = [0, 1, 2].map(i => real[i] ?? fallbackProfile(cfg.label));
    return { ...cfg, profiles };
  });
});

const currentCatIndex = ref(0);
let pillTimer = null;
onMounted(() => {
  pillTimer = setInterval(() => {
    currentCatIndex.value = (currentCatIndex.value + 1) % pillCategories.value.length;
  }, 2200);
});
onUnmounted(() => clearInterval(pillTimer));

function doSearch() {
  if (searchQuery.value.trim()) {
    router.get('/search', { q: searchQuery.value });
  }
}

const heroStats = computed(() => [
  { value: props.stats.mentors + '+',  label: 'Mentors' },
  { value: props.stats.packages + '+', label: 'Packages' },
  { value: props.stats.categories,     label: 'Categories' },
]);

const statCards = computed(() => [
  { value: props.stats.mentors + '+',  label: 'Expert Mentors' },
  { value: props.stats.students + '+', label: 'Happy Students' },
  { value: props.stats.packages + '+', label: 'Learning Packages' },
  { value: props.stats.categories,     label: 'Categories' },
]);

const steps = [
  { emoji: '🔍', title: 'Discover',        description: 'Browse our curated list of expert mentors across 14 specializations.' },
  { emoji: '📦', title: 'Choose Package',  description: 'Select from 1-on-1 sessions, group programs, or intensive bootcamps.' },
  { emoji: '📅', title: 'Book a Session',  description: 'Schedule at your convenience and connect securely on the platform.' },
  { emoji: '🚀', title: 'Grow Fast',       description: 'Work with your mentor and accelerate your career with expert guidance.' },
];

function getCatEmoji(slug) {
  return categoryConfig[slug]?.emoji || '📌';
}
</script>

<style scoped>
/* Pill text swap */
.pill-swap-enter-active,
.pill-swap-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.pill-swap-enter-from { opacity: 0; transform: translateY(14px); }
.pill-swap-enter-to   { opacity: 1; transform: translateY(0); }
.pill-swap-leave-from { opacity: 1; transform: translateY(0); }
.pill-swap-leave-to   { opacity: 0; transform: translateY(-14px); }

/* Stacked profile cards swap */
.stack-swap-enter-active {
  transition: all 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.stack-swap-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.stack-swap-enter-from { opacity: 0; transform: scale(0.94) translateY(16px); }
.stack-swap-enter-to   { opacity: 1; transform: scale(1) translateY(0); }
.stack-swap-leave-from { opacity: 1; transform: scale(1); }
.stack-swap-leave-to   { opacity: 0; transform: scale(0.96) translateY(-10px); }
</style>
