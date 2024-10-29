<template>
    <ChatLayaout>
        <template #aside>

        </template>
            <div class="w-full flex text-white">

            </div>
        <template #form>
            <section class="px-6 top-0">
                <div class="w-full">
                    <div class="relative flex-1 flex items-center">
                        <input
                            type="text"
                            class="w-full bg-slate-700 text-white rounded-lg"
                            placeholder="Envía un mensaje al ChatBot ... "
                            v-model="form.promt"
                            @keyup.enter="submit"
                        />
                        <div class="absolute inset-y-0 right-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 -ml-8 text-slate-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                              </svg>
                        </div>
                    </div>
                </div>
            </section>
        </template>

    </ChatLayaout>
</template>
<script setup>
import ChatLayaout from '@/Layouts/ChatLayaout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    messages: Array,
    chat: null | Object,
});
const form = useForm({
    promt: "",
});
const submit = () => {
    form.post("/chat");
    };
</script>
