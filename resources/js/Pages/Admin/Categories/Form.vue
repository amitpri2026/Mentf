<template>
  <AdminLayout>
    <Head :title="category ? 'Edit Category' : 'Create Category'" />

    <div class="max-w-xl">
      <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ category ? 'Edit Category' : 'Create Category' }}</h2>

        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
            <input v-model="form.name" type="text" required class="input-field" />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea v-model="form.description" rows="2" class="input-field"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (emoji or name)</label>
              <input v-model="form.icon" type="text" class="input-field" placeholder="e.g. 💻" />
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Color</label>
              <input v-model="form.color" type="color" class="h-11 w-full rounded-xl border border-gray-300 cursor-pointer" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order</label>
              <input v-model="form.sort_order" type="number" min="0" class="input-field" />
            </div>
            <div class="flex items-end pb-1">
              <label class="flex items-center gap-2 text-sm text-gray-700">
                <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600" />
                Active
              </label>
            </div>
          </div>

          <div class="flex gap-3 pt-2">
            <button type="submit" :disabled="processing" class="btn-primary text-sm px-6 py-2.5">
              {{ processing ? 'Saving...' : (category ? 'Update' : 'Create') }}
            </button>
            <Link href="/admin/categories" class="btn-secondary text-sm px-6 py-2.5">Cancel</Link>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ category: Object });
const processing = ref(false);
const form = reactive({
  name: props.category?.name || '',
  description: props.category?.description || '',
  icon: props.category?.icon || '',
  color: props.category?.color || '#6366F1',
  sort_order: props.category?.sort_order || 0,
  is_active: props.category?.is_active ?? true,
});

function submit() {
  processing.value = true;
  const url = props.category ? `/admin/categories/${props.category.id}` : '/admin/categories';
  const method = props.category ? 'put' : 'post';
  router[method](url, form, {
    onError: () => { processing.value = false; },
    onFinish: () => { processing.value = false; },
  });
}
</script>
