<template>
  <AppLayout>
    <Head :title="post.title" />

    <div class="max-w-3xl mx-auto px-4 py-12 sm:py-16">

      <!-- Back -->
      <Link href="/blog" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-8 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Blog
      </Link>

      <!-- Article -->
      <article class="bg-white rounded-2xl border border-gray-100 p-8 sm:p-10">
        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-3">
          {{ formatDate(post.published_at) }}
        </p>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
          {{ post.title }}
        </h1>
        <p v-if="post.excerpt" class="text-gray-500 text-base border-l-4 border-blue-200 pl-4 mb-8 italic">
          {{ post.excerpt }}
        </p>
        <div class="prose-content" v-html="post.content"></div>
      </article>

      <!-- CTA -->
      <div class="mt-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-7 text-white text-center">
        <h3 class="text-lg font-bold mb-2">Ready to find your mentor?</h3>
        <p class="text-blue-100 text-sm mb-5">Connect with an expert who can help you reach your goals faster.</p>
        <Link href="/mentors"
          class="inline-block bg-white text-blue-700 text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-50 transition-colors">
          Browse Mentors
        </Link>
      </div>

      <!-- ─── Comments ─── -->
      <div class="mt-10">
        <h2 class="text-lg font-bold text-gray-900 mb-6">
          {{ comments.length }} Comment{{ comments.length !== 1 ? 's' : '' }}
        </h2>

        <!-- Success flash -->
        <div v-if="comment_success"
          class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
          <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          {{ comment_success }}
        </div>

        <!-- Existing comments -->
        <div v-if="comments.length" class="space-y-4 mb-8">
          <div v-for="c in comments" :key="c.id"
            class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-center gap-3 mb-3">
              <!-- Avatar initials -->
              <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold text-sm flex items-center justify-center shrink-0">
                {{ c.author_name.charAt(0).toUpperCase() }}
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-900">{{ c.author_name }}</p>
                <p class="text-xs text-gray-400">{{ formatDate(c.created_at) }}</p>
              </div>
            </div>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ c.content }}</p>
          </div>
        </div>

        <div v-else class="mb-8 text-sm text-gray-400 italic">
          No comments yet. Be the first to share your thoughts!
        </div>

        <!-- Comment form -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
          <h3 class="text-base font-bold text-gray-900 mb-4">Leave a Comment</h3>

          <form @submit.prevent="submitComment" class="space-y-4">
            <!-- Name + email (only for guests) -->
            <template v-if="!$page.props.auth.user">
              <div class="grid sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Name *</label>
                  <input v-model="form.author_name" type="text" placeholder="Your name"
                    class="input-field text-sm" required />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-gray-400 font-normal">(optional)</span></label>
                  <input v-model="form.author_email" type="email" placeholder="your@email.com"
                    class="input-field text-sm" />
                </div>
              </div>
            </template>

            <!-- Logged-in user info -->
            <div v-else class="flex items-center gap-3 bg-blue-50 rounded-xl px-4 py-3">
              <div class="w-8 h-8 rounded-full bg-blue-200 text-blue-800 font-bold text-sm flex items-center justify-center shrink-0">
                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
              </div>
              <p class="text-sm text-blue-800 font-medium">
                Commenting as <strong>{{ $page.props.auth.user.name }}</strong>
              </p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Comment *</label>
              <textarea v-model="form.content" rows="4" placeholder="Share your thoughts, questions, or experience…"
                class="input-field text-sm" required></textarea>
              <p class="text-xs text-gray-400 mt-1">{{ form.content.length }} / 2000 characters</p>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
              <p v-if="!$page.props.auth.user" class="text-xs text-gray-400">
                Or <Link href="/login" class="text-blue-600 hover:underline">sign in</Link> to comment with your account
              </p>
              <div v-else></div>
              <button type="submit" class="btn-primary" :disabled="submitting">
                {{ submitting ? 'Posting…' : 'Post Comment' }}
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- ─── End Comments ─── -->

    </div>
  </AppLayout>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  post:            Object,
  comments:        Array,
  comment_success: String,
});

const page = usePage();

const form = reactive({
  author_name:  '',
  author_email: '',
  content:      '',
});

const submitting = ref(false);

function submitComment() {
  submitting.value = true;
  router.post(`/blog/${props.post.slug}/comments`, { ...form }, {
    preserveScroll: true,
    onSuccess: () => {
      form.author_name  = '';
      form.author_email = '';
      form.content      = '';
    },
    onFinish: () => { submitting.value = false; },
  });
}

function formatDate(d) {
  return new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' });
}
</script>

<style scoped>
.prose-content :deep(h2) {
  font-size: 1.375rem;
  font-weight: 700;
  color: #111827;
  margin-top: 2rem;
  margin-bottom: 0.75rem;
}
.prose-content :deep(h3) {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin-top: 1.75rem;
  margin-bottom: 0.5rem;
}
.prose-content :deep(p) {
  color: #4b5563;
  line-height: 1.8;
  margin-bottom: 1rem;
}
.prose-content :deep(ul) {
  list-style: disc;
  padding-left: 1.5rem;
  color: #4b5563;
  margin-bottom: 1rem;
  line-height: 1.75;
}
.prose-content :deep(ol) {
  list-style: decimal;
  padding-left: 1.5rem;
  color: #4b5563;
  margin-bottom: 1rem;
  line-height: 1.75;
}
.prose-content :deep(li) { margin-bottom: 0.35rem; }
.prose-content :deep(a) { color: #2563eb; text-decoration: underline; }
.prose-content :deep(strong) { font-weight: 600; color: #1f2937; }
.prose-content :deep(blockquote) {
  border-left: 4px solid #dbeafe;
  padding-left: 1rem;
  color: #6b7280;
  font-style: italic;
  margin: 1.5rem 0;
}
</style>
