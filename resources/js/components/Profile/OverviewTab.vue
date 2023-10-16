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
                <v-card-title> {{ apiData?.first_name }} {{ apiData?.last_name }} </v-card-title>
                <v-card-subtitle>{{ apiData?.email }}</v-card-subtitle>
                <v-card-text>
                    <table width="100%">
                        <tr>
                            <td width="40%"><b>Username</b></td>
                            <td width="60%">{{ apiData?.username }}</td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Role</b></td>
                            <td width="60%">{{ apiData?.role?.title }}</td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Phone</b></td>
                            <td width="60%">{{ apiData?.user_detail?.phone_1 }}</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Academic Email</b></td>
                            <td width="60%">{{ apiData?.user_detail?.academic_email }}</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Personal Email</b></td>
                            <td width="60%">{{ apiData?.user_detail?.personal_email }}</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Institution</b></td>
                            <td width="60%">{{ apiData?.user_detail?.institution }}</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Program</b></td>
                            <td width="60%">{{ apiData?.user_detail?.program }}</td>
                        </tr>
                    </table>
                </v-card-text>
            </v-card>
        </div>
        <div class="ma-1 pa-1" v-if="renderElement">
            <v-card min-width="350">
                <v-card-title class="font-weight-bold">Tickets Overview</v-card-title>
                <!-- <v-card-subtitle>email</v-card-subtitle> -->
                <v-card-text>
                    <table class="status-table" width="100%">
                        <tr v-for="(value, key) of apiData?.ticketCaseCounts" :key="key">
                            <td width="80%">{{ key }}</td>
                            <td>
                                <v-badge
                                    :color="makeBadgeColor(key)"
                                    :content="value"
                                    inline
                                ></v-badge>
                            </td>
                        </tr>
                    </table>
                </v-card-text>
            </v-card>
        </div>
        <div class="ma-1 pa-1" v-if="renderElement">
            <v-card min-width="350">
                <v-card-title class="font-weight-bold">COOP Info</v-card-title>
                <v-card-subtitle>Total {{ getFormatedStringFromDays(apiData?.coopDurationInDays) }}</v-card-subtitle>
                <v-card-text>
                    <v-timeline density="compact" side="end">
                        <v-timeline-item
                        v-for="item in apiData?.coop_terms"
                        :key="item.id"
                        dot-color="orange-lighten-1"
                        size="small"
                        >
                        <div>{{ item?.position }}</div>
                        <div>{{ item?.ministry?.title }}</div>
                        <div>{{ formatDateV1(item?.term_start) }} - {{ formatDateV1(item?.term_end).toLocaleDateString() }}</div>
                        </v-timeline-item>
                    </v-timeline>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { getFormatedStringFromDays, formatDateV1 } from '@/utils/index.js'

    const { renderElement, apiData } = defineProps({  renderElement: Boolean, apiData: Object })

    const items = ref([
        {
          id: 1,
          color: 'orange-lighten-1',
          icon: 'mdi-information',
        },
        {
          id: 2,
          color: 'orange-lighten-1',
          icon: 'mdi-alert-circle',
        },
      ]);

    const makeBadgeColor = (status) => {
        if(status === 'Pending') {
            return 'red-darken-1'
        } else if (status === 'In Progress') {
            return 'info'
        } else if (status === 'Completed') {
            return 'green-darken-1'
        } else if (status === 'QA Passed') {
            return 'green-darken-2'
        } else if (status === 'Production Ready') {
            return 'green-darken-3'
        } else if (status === 'In Production') {
            return 'green-darken-4'
        }
    }

</script>

<style scoped>
    table {
        border-collapse: collapse;
    }
    th, td {
        text-align: left;
        padding: 4px;
    }
    .status-table tr:nth-child(odd) {background-color: #f2f2f2;}
</style>
