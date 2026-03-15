<template>
  <div class="min-h-screen bg-slate-50 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 fixed inset-y-0 left-0 z-50 flex flex-col">
      <!-- Logo -->
      <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-200">
        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
          <span class="text-white font-bold text-sm">M</span>
        </div>
        <div>
          <span class="text-base font-bold text-slate-900 tracking-tight">MentF</span>
          <span class="block text-xs text-slate-400 leading-none">Admin Portal</span>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 py-4 px-3 space-y-0.5 overflow-y-auto">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">Main</p>

        <AdminNavLink href="/admin" :active="isActive('/admin', true)">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
          </template>
          Dashboard
        </AdminNavLink>

        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mt-4 mb-2">Management</p>

        <AdminNavLink href="/admin/users" :active="isActive('/admin/users')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </template>
          Users
        </AdminNavLink>

        <AdminNavLink href="/admin/categories" :active="isActive('/admin/categories')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
          </template>
          Categories
        </AdminNavLink>

        <AdminNavLink href="/admin/packages" :active="isActive('/admin/packages')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
          </template>
          Packages
        </AdminNavLink>

        <AdminNavLink href="/admin/enrollments" :active="isActive('/admin/enrollments')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </template>
          Enrollments
        </AdminNavLink>
      </nav>

      <!-- User info -->
      <div class="p-4 border-t border-slate-200">
        <div class="flex items-center gap-3">
          <img :src="$page.props.auth.user?.profile_photo_url" class="w-8 h-8 rounded-full object-cover ring-2 ring-slate-200" alt="Admin" />
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-900 truncate">{{ $page.props.auth.user?.name }}</p>
            <p class="text-xs text-slate-400">Administrator</p>
          </div>
          <button @click="logout" class="text-slate-400 hover:text-slate-700 transition-colors p-1" title="Logout">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 ml-64 flex flex-col">
      <!-- Top bar -->
      <header class="bg-white h-16 border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-40">
        <div class="flex items-center gap-3">
          <h1 class="text-base font-semibold text-slate-900">{{ pageTitle }}</h1>
        </div>
        <div class="flex items-center gap-3">
          <Link href="/" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1.5 font-medium">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            View Site
          </Link>
        </div>
      </header>

      <!-- Page content -->
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminNavLink from '@/Components/AdminNavLink.vue';

const pageTitle = computed(() => {
  const path = window.location.pathname;
  if (path === '/admin' || path === '/admin/') return 'Dashboard';
  if (path.startsWith('/admin/users'))       return 'Users';
  if (path.startsWith('/admin/categories'))  return 'Categories';
  if (path.startsWith('/admin/packages'))    return 'Packages';
  if (path.startsWith('/admin/enrollments')) return 'Enrollments';
  return 'Admin Panel';
});

function isActive(path, exact = false) {
  const current = window.location.pathname;
  if (exact) return current === path || current === path + '/';
  return current.startsWith(path);
}

function logout() { router.post('/logout'); }
</script>
