<template>
  <div class="min-h-screen bg-white">

    <!-- Top announcement bar -->
    <div class="bg-blue-500 text-white text-xs py-2 hidden md:block">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <span class="font-medium">{{ $page.props.heroTagline || '🌟 Connect with world-class mentors across 14 categories' }}</span>
        <div class="flex items-center gap-5 text-blue-100">
          <a href="tel:+919008017896" class="hover:text-white transition-colors">+91 9008017896</a>
          <a href="mailto:support@mentf.com" class="hover:text-white transition-colors">support@mentf.com</a>
        </div>
      </div>
    </div>

    <!-- Main Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

          <!-- Logo -->
          <div class="flex items-center gap-8">
            <Link href="/" class="flex items-center gap-2.5">
              <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">M</span>
              </div>
              <span class="text-xl font-bold text-slate-900 tracking-tight">Ment<span class="text-blue-500">F</span></span>
            </Link>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-0.5">
              <Link href="/mentors"  class="nav-link" :class="{ 'nav-link-active': isActive('/mentors') }">Mentors</Link>
              <Link href="/packages" class="nav-link" :class="{ 'nav-link-active': isActive('/packages') }">Packages</Link>

              <!-- Categories dropdown -->
              <div class="relative" ref="catsRef">
                <button @click="showCats = !showCats" class="nav-link flex items-center gap-1" :class="{ 'nav-link-active': showCats }">
                  Categories
                  <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="showCats ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <div v-show="showCats" class="absolute top-full left-0 w-60 bg-white rounded-xl shadow-xl border border-slate-200 py-1.5 z-50">
                  <Link
                    v-for="cat in $page.props.categories"
                    :key="cat.id"
                    :href="`/categories/${cat.slug}`"
                    class="flex items-center gap-3 px-3.5 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                    @click="showCats = false"
                  >
                    <span class="w-5 text-center">{{ getCatEmoji(cat.slug) }}</span>
                    {{ cat.name }}
                  </Link>
                </div>
              </div>
            </div>
          </div>

          <!-- Right side -->
          <div class="flex items-center gap-2">
            <button @click="showSearch = true" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>

            <template v-if="!$page.props.auth.user">
              <Link href="/login" class="hidden sm:block text-sm font-medium text-slate-600 hover:text-slate-900 px-3 py-2 rounded-lg hover:bg-slate-50 transition-colors">Login</Link>
              <Link href="/register" class="hidden sm:block btn-primary text-sm">Get Started</Link>
            </template>

            <template v-else>
              <Link
                :href="$page.props.auth.user.role === 'mentor' ? '/dashboard/mentor' : ($page.props.auth.user.role === 'admin' ? '/admin' : '/dashboard')"
                class="hidden sm:flex items-center gap-1.5 text-sm font-semibold px-3.5 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
              </Link>

              <!-- Avatar dropdown -->
              <div class="hidden sm:block relative" ref="userMenuRef">
                <button @click="showUserMenu = !showUserMenu" class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-lg hover:bg-slate-100 transition-colors">
                  <img :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name"
                    class="w-8 h-8 rounded-full object-cover ring-2 ring-slate-200" />
                  <span class="text-sm font-medium text-slate-700">{{ $page.props.auth.user.name }}</span>
                  <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <div v-show="showUserMenu" class="absolute top-full right-0 w-48 bg-white rounded-xl shadow-xl border border-slate-200 py-1.5 z-50">
                  <div class="px-3.5 py-2 border-b border-slate-100 mb-1">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">{{ $page.props.auth.user.role }}</p>
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $page.props.auth.user.name }}</p>
                  </div>
                  <button @click="logout" class="w-full text-left px-3.5 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors">Logout</button>
                </div>
              </div>
            </template>

            <!-- Hamburger (mobile only) -->
            <button @click="showMobileMenu = !showMobileMenu" class="md:hidden p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
              <svg v-if="!showMobileMenu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div v-show="showMobileMenu" class="md:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-1">
          <Link href="/mentors"  class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" @click="showMobileMenu = false" :class="{ 'bg-blue-50 text-blue-600': isActive('/mentors') }">
            <span>👨‍💼</span> Mentors
          </Link>
          <Link href="/packages" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors" @click="showMobileMenu = false" :class="{ 'bg-blue-50 text-blue-600': isActive('/packages') }">
            <span>📦</span> Packages
          </Link>

          <!-- Mobile categories -->
          <div>
            <button @click="showMobileCats = !showMobileCats" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
              <span class="flex items-center gap-3"><span>🗂️</span> Categories</span>
              <svg class="w-4 h-4 text-slate-400 transition-transform" :class="showMobileCats ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="showMobileCats" class="ml-4 mt-1 space-y-0.5 border-l-2 border-slate-100 pl-3">
              <Link
                v-for="cat in $page.props.categories"
                :key="cat.id"
                :href="`/categories/${cat.slug}`"
                class="flex items-center gap-2 px-2 py-2 rounded-lg text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                @click="showMobileMenu = false"
              >
                <span>{{ getCatEmoji(cat.slug) }}</span>
                {{ cat.name }}
              </Link>
            </div>
          </div>
        </div>

        <!-- Mobile auth -->
        <div class="border-t border-slate-100 px-4 py-3">
          <template v-if="!$page.props.auth.user">
            <div class="flex gap-2">
              <Link href="/login" class="flex-1 text-center py-2.5 text-sm font-medium text-slate-700 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors" @click="showMobileMenu = false">Login</Link>
              <Link href="/register" class="flex-1 text-center py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors" @click="showMobileMenu = false">Get Started</Link>
            </div>
          </template>
          <template v-else>
            <div class="flex items-center gap-3 mb-3">
              <img :src="$page.props.auth.user.profile_photo_url" class="w-9 h-9 rounded-full object-cover ring-2 ring-slate-200" />
              <div>
                <p class="text-sm font-semibold text-slate-900">{{ $page.props.auth.user.name }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ $page.props.auth.user.role }}</p>
              </div>
            </div>
            <div class="flex gap-2">
              <Link
                :href="$page.props.auth.user.role === 'mentor' ? '/dashboard/mentor' : ($page.props.auth.user.role === 'admin' ? '/admin' : '/dashboard')"
                class="flex-1 text-center py-2.5 text-sm font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors"
                @click="showMobileMenu = false"
              >Dashboard</Link>
              <button @click="logout" class="flex-1 py-2.5 text-sm font-medium text-red-500 border border-red-100 rounded-xl hover:bg-red-50 transition-colors">Logout</button>
            </div>
          </template>
        </div>
      </div>
    </nav>

    <!-- Search modal -->
    <div v-if="showSearch" class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm z-50 flex items-start justify-center pt-24 px-4" @click.self="showSearch = false">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl border border-slate-200">
        <div class="flex items-center gap-3 px-4 py-3">
          <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <form @submit.prevent="doSearch" class="flex gap-2.5 flex-1">
            <input v-model="searchQuery" autofocus type="text" placeholder="Search mentors, skills, or topics..."
              class="flex-1 text-slate-900 bg-transparent focus:outline-none text-base placeholder-slate-400 py-1.5" />
            <button type="submit" class="btn-primary px-5 py-2 text-sm">Search</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Flash Messages -->
    <div v-if="$page.props.flash?.success" class="fixed top-20 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
      {{ $page.props.flash.success }}
    </div>
    <div v-if="$page.props.flash?.error" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
      {{ $page.props.flash.error }}
    </div>

    <!-- Main content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-10 mb-12">
          <!-- Brand -->
          <div class="md:col-span-2">
            <div class="flex items-center gap-2.5 mb-4">
              <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">M</span>
              </div>
              <span class="text-xl font-bold text-white tracking-tight">MentF</span>
            </div>
            <p class="text-sm leading-relaxed text-slate-400 max-w-xs mb-5">
              The professional mentoring marketplace connecting ambitious learners with world-class industry experts.
            </p>
            <div class="flex items-center gap-2">
              <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
              </a>
              <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
              </a>
            </div>
          </div>

          <div>
            <h4 class="text-xs font-semibold text-slate-300 uppercase tracking-wider mb-4">Platform</h4>
            <ul class="space-y-2.5 text-sm">
              <li><Link href="/mentors"  class="hover:text-white transition-colors">Find Mentors</Link></li>
              <li><Link href="/packages" class="hover:text-white transition-colors">Browse Packages</Link></li>
              <li><Link href="/register" class="hover:text-white transition-colors">Become a Mentor</Link></li>
            </ul>
          </div>

          <div>
            <h4 class="text-xs font-semibold text-slate-300 uppercase tracking-wider mb-4">Categories</h4>
            <ul class="space-y-2.5 text-sm">
              <li v-for="cat in ($page.props.categories || []).slice(0, 5)" :key="cat.id">
                <Link :href="`/categories/${cat.slug}`" class="hover:text-white transition-colors">{{ cat.name }}</Link>
              </li>
            </ul>
          </div>

          <div>
            <h4 class="text-xs font-semibold text-slate-300 uppercase tracking-wider mb-4">Company</h4>
            <ul class="space-y-2.5 text-sm">
              <li><Link href="/about" class="hover:text-white transition-colors">About Us</Link></li>
              <li><Link href="/blog"  class="hover:text-white transition-colors">Blog</Link></li>
              <li><Link href="/contact" class="hover:text-white transition-colors">Contact</Link></li>
              <li><Link href="/privacy" class="hover:text-white transition-colors">Privacy Policy</Link></li>
            </ul>
          </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row justify-between items-center gap-3 text-sm">
          <p>© {{ new Date().getFullYear() }} MentF. All rights reserved.</p>
          <p class="text-slate-600 text-xs">Empowering learners worldwide</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const showCats        = ref(false);
const showUserMenu    = ref(false);
const showSearch      = ref(false);
const showMobileMenu  = ref(false);
const showMobileCats  = ref(false);
const searchQuery     = ref('');
const catsRef         = ref(null);
const userMenuRef     = ref(null);

function handleClickOutside(e) {
  if (catsRef.value && !catsRef.value.contains(e.target))         showCats.value = false;
  if (userMenuRef.value && !userMenuRef.value.contains(e.target)) showUserMenu.value = false;
}
onMounted(()  => document.addEventListener('click', handleClickOutside));
onUnmounted(() => document.removeEventListener('click', handleClickOutside));

function isActive(path) { return window.location.pathname.startsWith(path); }

function doSearch() {
  if (searchQuery.value.trim()) {
    router.get('/search', { q: searchQuery.value });
    showSearch.value = false;
  }
}

function logout() { router.post('/logout'); }

function getCatEmoji(slug) {
  const map = {
    'artificial-intelligence': '🤖', 'business': '💼', 'competitive-exams': '📚',
    'design-architecture': '🎨',     'development': '💻', 'finance': '💰',
    'health-fitness': '💪',          'hr': '👥',           'infrastructure': '☁️',
    'legal': '⚖️',                   'marketing': '📢',    'music': '🎵',
    'photography-video': '📷',       'project-management': '📋',
  };
  return map[slug] || '📌';
}
</script>
