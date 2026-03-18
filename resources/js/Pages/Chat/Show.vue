<template>
  <div class="min-h-screen bg-slate-50 flex flex-col">
    <!-- Header -->
    <div class="bg-white border-b border-slate-200 px-6 py-3 flex items-center gap-4 sticky top-0 z-10">
      <Link href="/chat" class="text-slate-400 hover:text-slate-700 transition">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </Link>
      <img :src="conversation.other_user.profile_photo_url" class="w-9 h-9 rounded-full object-cover" />
      <div>
        <p class="font-semibold text-slate-900 text-sm">{{ conversation.other_user.name }}</p>
        <p v-if="conversation.package" class="text-xs text-blue-600">{{ conversation.package.title }}</p>
      </div>
    </div>

    <!-- Messages -->
    <div ref="msgContainer" class="flex-1 px-6 py-4 space-y-3 overflow-y-auto" style="max-height: calc(100vh - 130px)">
      <div v-if="allMessages.length === 0" class="text-center text-slate-400 text-sm py-12">
        Start the conversation by sending a message below.
      </div>
      <div v-for="msg in allMessages" :key="msg.id" :class="['flex', msg.is_mine ? 'justify-end' : 'justify-start']">
        <div class="flex items-end gap-2 max-w-[75%]">
          <img v-if="!msg.is_mine" :src="msg.sender.profile_photo_url" class="w-7 h-7 rounded-full object-cover shrink-0" />
          <div :class="['px-4 py-2.5 rounded-2xl text-sm', msg.is_mine ? 'bg-blue-600 text-white rounded-br-sm' : 'bg-white border border-slate-200 text-slate-800 rounded-bl-sm']">
            <p>{{ msg.message }}</p>
            <p :class="['text-xs mt-1', msg.is_mine ? 'text-blue-200' : 'text-slate-400']">{{ formatTime(msg.created_at) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Input -->
    <div class="bg-white border-t border-slate-200 px-6 py-3">
      <form @submit.prevent="sendMessage" class="flex items-center gap-3">
        <input v-model="newMessage" type="text" placeholder="Type a message..."
          class="flex-1 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <button type="submit" :disabled="!newMessage.trim() || sending"
          class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-blue-700 transition disabled:opacity-50 text-sm">
          Send
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({ conversation: Object, messages: Array });
const allMessages = ref([...props.messages]);
const newMessage = ref('');
const sending = ref(false);
const msgContainer = ref(null);
let pollInterval = null;
let lastId = ref(props.messages.length > 0 ? props.messages[props.messages.length - 1].id : 0);

function formatTime(d) {
  return new Date(d).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function scrollToBottom() {
  nextTick(() => {
    if (msgContainer.value) msgContainer.value.scrollTop = msgContainer.value.scrollHeight;
  });
}

async function sendMessage() {
  if (!newMessage.value.trim() || sending.value) return;
  sending.value = true;
  const msg = newMessage.value;
  newMessage.value = '';
  try {
    await axios.post(`/chat/${props.conversation.id}/send`, { message: msg });
    await pollMessages();
  } catch (e) {
    newMessage.value = msg;
  }
  sending.value = false;
}

async function pollMessages() {
  try {
    const res = await axios.get(`/chat/${props.conversation.id}/poll?since=${lastId.value}`);
    if (res.data.length > 0) {
      allMessages.value.push(...res.data);
      lastId.value = res.data[res.data.length - 1].id;
      scrollToBottom();
    }
  } catch (e) {}
}

onMounted(() => {
  scrollToBottom();
  pollInterval = setInterval(pollMessages, 3000);
});

onUnmounted(() => clearInterval(pollInterval));
</script>
