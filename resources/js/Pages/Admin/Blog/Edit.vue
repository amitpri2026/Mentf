<template>
  <AdminLayout>
    <Head :title="`Edit: ${post.title}`" />

    <div class="max-w-3xl space-y-6">

      <!-- Post editor -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-6">Edit Blog Post</h2>

        <form @submit.prevent="submit" class="space-y-5">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Title *</label>
            <input v-model="form.title" type="text" class="input-field text-sm"
              placeholder="Post title" required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
              Excerpt
              <span class="text-xs text-gray-400 font-normal ml-1">(short summary shown in listing)</span>
            </label>
            <textarea v-model="form.excerpt" rows="2" class="input-field text-sm"
              placeholder="A one-sentence summary of the post…"></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
              Content *
              <span class="text-xs text-gray-400 font-normal ml-1">(HTML supported)</span>
            </label>
            <textarea v-model="form.content" rows="16" class="input-field text-sm font-mono"
              placeholder="<p>Start writing...</p>" required></textarea>
          </div>

          <div class="flex items-center gap-3">
            <input id="published" v-model="form.is_published" type="checkbox"
              class="w-4 h-4 rounded border-gray-300 text-blue-600" />
            <label for="published" class="text-sm font-medium text-gray-700">Published</label>
          </div>

          <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <Link href="/admin/blog" class="text-sm text-gray-500 hover:text-gray-700">Cancel</Link>
            <button type="submit" class="btn-primary" :disabled="saving">
              {{ saving ? 'Saving…' : 'Save Changes' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Comments moderation -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-base font-bold text-gray-900 mb-4">
          Comments
          <span class="ml-2 text-xs font-semibold bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ comments.length }}</span>
        </h2>

        <div v-if="comments.length" class="space-y-3">
          <div v-for="c in comments" :key="c.id"
            class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center shrink-0">
              {{ c.author_name.charAt(0).toUpperCase() }}
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-1">
                <p class="text-sm font-semibold text-gray-900">{{ c.author_name }}</p>
                <p v-if="c.author_email" class="text-xs text-gray-400">{{ c.author_email }}</p>
                <p class="text-xs text-gray-400 ml-auto">{{ formatDate(c.created_at) }}</p>
              </div>
              <p class="text-sm text-gray-700 whitespace-pre-line">{{ c.content }}</p>
            </div>
            <button @click="deleteComment(c)"
              class="text-gray-300 hover:text-red-500 transition-colors p-1 shrink-0" title="Delete comment">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>

        <p v-else class="text-sm text-gray-400 italic">No comments yet on this post.</p>
      </div>

    </div>
  </AdminLayout>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ post: Object, comments: Array });

const form = reactive({
  title:        props.post.title,
  excerpt:      props.post.excerpt || '',
  content:      props.post.content,
  is_published: props.post.is_published,
});

const saving = ref(false);

function submit() {
  saving.value = true;
  router.put(`/admin/blog/${props.post.id}`, { ...form }, {
    onFinish: () => { saving.value = false; },
  });
}

function deleteComment(c) {
  if (confirm(`Delete comment by "${c.author_name}"?`)) {
    router.delete(`/admin/blog-comments/${c.id}`, { preserveScroll: true });
  }
}

function formatDate(d) {
  return new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
}
</script>
