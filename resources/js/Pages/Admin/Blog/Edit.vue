<template>
  <AdminLayout>
    <Head :title="`Edit: ${post.title}`" />

    <div class="max-w-3xl">
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
    </div>
  </AdminLayout>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ post: Object });

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
</script>
