<template>
    <div class="d-flex flex-wrap flex-row align-start justify-start">
        <div class="ma-1 pa-1">
            <v-card min-width="350">
                <v-img
                    aspect-ratio="16/9"
                    cover
                    rounded
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                ></v-img>
                <v-card-title>
                    Name
                </v-card-title>
                <v-card-text>
                    Info
                </v-card-text>
            </v-card>
        </div>
        <div class="ma-1 pa-1">
            <v-card
                min-width="350"
                title="This is a title"
                subtitle="This is a subtitle"
                text="This is content"
            ></v-card>
        </div>
        <div class="ma-1 pa-1">
            <v-card
                min-width="350"
                title="This is a title"
                subtitle="This is a subtitle"
                text="This is content"
            ></v-card>
        </div>
    </div>
</template>

<script setup>

</script>