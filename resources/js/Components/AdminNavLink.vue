<template>
  <Link
    :href="href"
    class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150"
    :class="active
      ? 'bg-blue-50 text-blue-700 font-semibold'
      : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700'"
  >
    <span :class="active ? 'text-blue-600' : 'text-slate-400'">
      <slot name="icon" />
    </span>
    <slot />
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  href:   String,
  active: Boolean,
});
</script>
