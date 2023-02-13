<template>
    <div v-for="data in permissions" :key="data.id">
        <v-checkbox
            v-model="ex4"
            :label="data.title"
            color="orange"
            value="orange"
            hide-details
            density="compact"
        ></v-checkbox>
    </div>
</template>

<script setup>
    const props = defineProps(['permissions'])
    const ex4 = ref("ki jani")
</script>
