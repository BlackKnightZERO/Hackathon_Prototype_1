<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }}</h2>
        <v-container fluid>
            <v-row>
                <v-col
                cols="12"
                sm="6"
                md="6"
                >
                <p class="text-subtitle-1">
                Black text.
                </p>
                <v-checkbox
                    v-model="ex4"
                    label="orange"
                    color="orange"
                    value="orange"
                    hide-details
                ></v-checkbox>
                <v-checkbox
                    v-model="ex4"
                    label="orange"
                    color="orange"
                    value="orange"
                    hide-details
                ></v-checkbox>
                <v-checkbox
                    v-model="ex4"
                    label="orange"
                    color="orange"
                    value="orange"
                    hide-details
                ></v-checkbox>
                <v-checkbox
                    v-model="ex4"
                    label="orange"
                    color="orange"
                    value="orange"
                    hide-details
                ></v-checkbox>
                <v-checkbox
                    v-model="ex4"
                    label="orange"
                    color="orange"
                    value="orange"
                    hide-details
                ></v-checkbox>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import modulePermission from '../helper/modulePermission.js'

    const moduleName = 'Role-permission'

    const apiData = ref([])
    const ex4 = ref("ki jani")
    const canPerform = modulePermission(moduleName)

    const fetchData = async () => {
        await axios({
            method: 'GET',
            url: '/api/role-permissions',
            data: {}
        }).then(res => {
            apiData.value = res.data
        }).catch(err => {
            console.log(err)
        })
    }

    onMounted(() => {
        if(canPerform.includes('INDEX')) {
            fetchData()
        }
    })

</script>