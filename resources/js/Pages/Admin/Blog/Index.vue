<template>
  <AdminLayout>
    <Head title="Blog Posts" />

    <div class="max-w-4xl">

      <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">{{ posts.length }} post{{ posts.length !== 1 ? 's' : '' }}</p>
        <Link href="/admin/blog/create" class="btn-primary text-sm">+ New Post</Link>
      </div>

      <!-- Flash -->
      <div v-if="$page.props.flash?.success"
        class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">
        {{ $page.props.flash.success }}
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-gray-100 bg-gray-50">
              <th class="text-left px-5 py-3 font-semibold text-gray-600">Title</th>
              <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
              <th class="text-left px-5 py-3 font-semibold text-gray-600">Published</th>
              <th class="px-5 py-3"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts" :key="post.id"
              class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
              <td class="px-5 py-3">
                <div class="font-medium text-gray-900">{{ post.title }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ post.slug }}</div>
              </td>
              <td class="px-5 py-3">
                <span :class="post.is_published
                  ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                  : 'bg-gray-100 text-gray-500 border-gray-200'"
                  class="text-xs px-2 py-0.5 rounded-full border font-medium">
                  {{ post.is_published ? 'Published' : 'Draft' }}
                </span>
              </td>
              <td class="px-5 py-3 text-gray-500 text-xs">
                {{ post.published_at ? formatDate(post.published_at) : '—' }}
              </td>
              <td class="px-5 py-3">
                <div class="flex items-center gap-2 justify-end">
                  <Link :href="`/blog/${post.slug}`" target="_blank"
                    class="text-xs text-blue-600 hover:text-blue-800">View</Link>
                  <Link :href="`/admin/blog/${post.id}/edit`"
                    class="text-xs text-gray-600 hover:text-gray-900">Edit</Link>
                  <button @click="deletePost(post)"
                    class="text-xs text-red-500 hover:text-red-700">Delete</button>
                </div>
              </td>
            </tr>
            <tr v-if="posts.length === 0">
              <td colspan="4" class="px-5 py-10 text-center text-gray-400 text-sm">
                No posts yet. <Link href="/admin/blog/create" class="text-blue-600 hover:underline">Create your first post.</Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link, Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ posts: Array });

function formatDate(d) {
  return new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
}

function deletePost(post) {
  if (confirm(`Delete "${post.title}"?`)) {
    router.delete(`/admin/blog/${post.id}`);
  }
}
</script>
