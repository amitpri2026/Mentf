<template>
  <div class="min-h-screen bg-slate-50 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 fixed inset-y-0 left-0 z-50 flex flex-col">
      <!-- Logo -->
      <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-200">
        <Link href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
          <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
            <span class="text-white font-bold text-sm">M</span>
          </div>
          <div>
            <span class="text-base font-bold text-slate-900 tracking-tight">MentF</span>
            <span class="block text-xs text-slate-400 leading-none">Admin Portal</span>
          </div>
        </Link>
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

        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mt-4 mb-2">Content</p>

        <AdminNavLink href="/admin/cms" :active="isActive('/admin/cms')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </template>
          Pages
        </AdminNavLink>

        <AdminNavLink href="/admin/blog" :active="isActive('/admin/blog')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
          </template>
          Blog
        </AdminNavLink>

        <AdminNavLink href="/admin/contact-inquiries" :active="isActive('/admin/contact-inquiries')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
          </template>
          Contact Inquiries
        </AdminNavLink>

        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mt-4 mb-2">Communication</p>

        <AdminNavLink href="/admin/notifications" :active="isActive('/admin/notifications')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
          </template>
          Notifications
          <span v-if="$page.props.unread_notifications > 0" class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">{{ $page.props.unread_notifications }}</span>
        </AdminNavLink>

        <AdminNavLink href="/admin/chat" :active="isActive('/admin/chat')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
          </template>
          Chat Monitor
        </AdminNavLink>

        <AdminNavLink href="/admin/helpdesk" :active="isActive('/admin/helpdesk')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
          </template>
          Helpdesk
        </AdminNavLink>

        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mt-4 mb-2">Config</p>

        <AdminNavLink href="/admin/settings" :active="isActive('/admin/settings')">
          <template #icon>
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </template>
          Settings
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
          <Link href="/admin/notifications" class="relative text-slate-400 hover:text-slate-700 p-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span v-if="$page.props.unread_notifications > 0" class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $page.props.unread_notifications }}</span>
          </Link>
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
  if (path.startsWith('/admin/cms'))        return 'CMS Pages';
  if (path.startsWith('/admin/blog'))       return 'Blog';
  if (path.startsWith('/admin/settings'))            return 'Settings';
  if (path.startsWith('/admin/contact-inquiries'))   return 'Contact Inquiries';
  if (path.startsWith('/admin/notifications'))       return 'Notifications';
  if (path.startsWith('/admin/chat'))                return 'Chat Monitor';
  if (path.startsWith('/admin/helpdesk'))            return 'Helpdesk';
  if (path.includes('/packages'))                    return 'Mentor Packages';
  return 'Admin Panel';
});

function isActive(path, exact = false) {
  const current = window.location.pathname;
  if (exact) return current === path || current === path + '/';
  return current.startsWith(path);
}

function logout() { router.post('/logout'); }
</script>
