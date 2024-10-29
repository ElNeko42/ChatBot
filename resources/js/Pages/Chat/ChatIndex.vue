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
                        <input type="text" class="w-full bg-slate-700 text-white rounded-lg" placeholder="Envía un mensaje al ChatBot ... ">
                    </div>
                </div>
            </section>
        </template>

    </ChatLayaout>
</template>
<script setup>
import ChatLayaout from '@/Layouts/ChatLayaout.vue';
</script>
