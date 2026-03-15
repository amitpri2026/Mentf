<template>
  <div class="space-y-4">
    <!-- Add form -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
      <button @click="showAdd = !showAdd"
        class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors">
        <span class="font-semibold text-slate-900">{{ title }}</span>
        <span class="flex items-center gap-2 text-sm text-blue-600 font-medium">
          <svg class="w-4 h-4 transition-transform" :class="showAdd ? 'rotate-45' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          Add New
        </span>
      </button>

      <div v-show="showAdd" class="border-t border-slate-100 p-6 bg-slate-50 space-y-4">
        <slot name="form" :form="addForm" :is-edit="false" />
        <div class="flex justify-end gap-3 pt-2">
          <button @click="showAdd = false; resetAdd()" type="button" class="btn-secondary text-sm py-2">Cancel</button>
          <button @click="submitAdd" type="button" class="btn-primary text-sm py-2" :disabled="saving">
            <svg v-if="saving" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            {{ saving ? 'Saving...' : 'Save' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Existing items -->
    <div v-if="items.length > 0" class="space-y-3">
      <div v-for="item in items" :key="item.id" class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <!-- View row -->
        <div v-if="editingId !== item.id" class="flex items-start gap-4 px-6 py-4">
          <div class="flex-1 min-w-0">
            <slot name="item" :item="item" />
          </div>
          <div class="flex gap-1.5 flex-shrink-0">
            <button @click="startEdit(item)"
              class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            <button @click="doDelete(item)"
              class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Edit row -->
        <div v-else class="p-6 bg-blue-50 space-y-4">
          <slot name="form" :form="editForm" :is-edit="true" />
          <div class="flex justify-end gap-3 pt-2">
            <button @click="editingId = null" type="button" class="btn-secondary text-sm py-2">Cancel</button>
            <button @click="submitEdit(item)" type="button" class="btn-primary text-sm py-2" :disabled="saving">
              {{ saving ? 'Saving...' : 'Update' }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="bg-white rounded-xl border border-dashed border-slate-200 py-10 text-center text-slate-400">
      <p class="text-sm">No {{ title.toLowerCase() }} added yet. Click "Add New" above to get started.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

const props = defineProps({
  title: String,
  items: Array,
});

const emit = defineEmits(['save', 'delete']);

const showAdd    = ref(false);
const editingId  = ref(null);
const saving     = ref(false);

const addForm  = reactive({});
const editForm = reactive({});

function resetAdd() {
  Object.keys(addForm).forEach(k => delete addForm[k]);
}

function startEdit(item) {
  editingId.value = item.id;
  Object.keys(editForm).forEach(k => delete editForm[k]);
  Object.assign(editForm, { ...item });
}

function submitAdd() {
  saving.value = true;
  emit('save', {
    form: { ...addForm },
    item: null,
    done: () => {
      saving.value = false;
      showAdd.value = false;
      resetAdd();
    },
  });
}

function submitEdit(item) {
  saving.value = true;
  emit('save', {
    form: { ...editForm },
    item,
    done: () => {
      saving.value = false;
      editingId.value = null;
    },
  });
}

function doDelete(item) {
  if (!confirm('Remove this entry?')) return;
  emit('delete', { item, done: () => {} });
}
</script>
