<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    users:{
        type:Array,
    },
});
</script>

<template>    
        <p v-for="user in $page.props.users" :key="user.id">{{ user.name }}</p>
</template>
