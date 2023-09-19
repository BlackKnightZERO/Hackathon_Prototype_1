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
                <v-card-title> first_name last_name </v-card-title>
                <v-card-subtitle>email</v-card-subtitle>
                <v-card-text>
                    <table width="100%">
                        <tr>
                            <td width="40%"><b>Username</b></td>
                            <td width="60%">username</td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Role</b></td>
                            <td width="60%">Role</td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Phone</b></td>
                            <td width="60%">phone_1</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Academic Email</b></td>
                            <td width="60%">academic_email</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Personal Email</b></td>
                            <td width="60%">personal_email</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Institution</b></td>
                            <td width="60%">institution</td>
                        </tr>
                        <tr v-if="renderElement">
                            <td width="40%"><b>Program</b></td>
                            <td width="60%">program</td>
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
                        <tr>
                            <td width="80%">Pending</td>
                            <td>
                                <v-badge
                                    color="red-darken-1"
                                    content="6"
                                    inline
                                ></v-badge>
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">In Progress</td>
                            <td>
                                <v-badge
                                    color="info"
                                    content="6"
                                    inline
                                ></v-badge>
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">Completed</td>
                            <td>
                                <v-badge
                                    color="green-darken-1"
                                    content="6"
                                    inline
                                ></v-badge>
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">QA Passed</td>
                            <td>
                                <v-badge
                                    color="green-darken-2"
                                    content="6"
                                    inline
                                ></v-badge>
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">Production Ready</td>
                            <td>
                                <v-badge
                                    color="green-darken-3"
                                    content="6"
                                    inline
                                ></v-badge>
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">In Production</td>
                            <td>
                                <v-badge
                                    color="green-darken-4"
                                    content="6"
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
                <v-card-subtitle>Total *8* Months</v-card-subtitle>
                <v-card-text>
                    <v-timeline density="compact" side="end">
                        <v-timeline-item
                        v-for="item in items"
                        :key="item.id"
                        :dot-color="item.color"
                        size="small"
                        >
                        <div>Position</div>
                        <div>Ministry</div>
                        <div>Start Date End Date</div>
                        </v-timeline-item>
                    </v-timeline>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script setup>
import { ref} from "vue";

const { renderElement } = defineProps({  renderElement: Boolean })
console.log(renderElement)

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
