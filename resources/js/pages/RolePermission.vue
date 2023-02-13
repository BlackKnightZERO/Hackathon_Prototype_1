<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }}</h2>
        <v-select
            :items="apiRolesData"
            label="Role"
            density="compact"
            style="width:30%; margin: 10px 0px;"
            v-model="roleRef"
        ></v-select>
        <v-table density="compact">
            <thead>
                <tr>
                    <th class="text-left">
                        Module
                    </th>
                    <th class="text-left">
                        Permissions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="data in apiModuleData" :key="data.id">
                    <td>{{ data.title }}</td>
                    <td>
                        <div v-for="_data in data.permissions" :key="_data.id">
                            <v-checkbox
                                v-model="ex4"
                                :label="_data.title"
                                color="orange"
                                value="orange"
                                hide-details
                                density="compact"
                            ></v-checkbox>
                        </div>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import modulePermission from '../helper/modulePermission.js'

    const moduleName = 'Role-permission'

    const apiRolesData = ref([])
    const apiModuleData = ref([])
    const ex4 = ref("ki jani")
    const roleRef = ref('')
    const canPerform = modulePermission(moduleName)

    const items = ['User']

    const fetchRoleData = async () => {
        await axios({
            method: 'GET',
            url: '/api/roles?compact',
            data: {}
        }).then(res => {
            console.log(res.data)
            apiRolesData.value = res.data
        }).catch(err => {
            console.log(err)
        })
    }

    const fetchModuleData = async () => {
        await axios({
            method: 'GET',
            url: '/api/modules',
            data: {}
        }).then(res => {
            console.log(res.data)
            apiModuleData.value = res.data.data
        }).catch(err => {
            console.log(err)
        })
    }

    onMounted(() => {
        if(canPerform.includes('INDEX')) {
            fetchRoleData()
            fetchModuleData()
        }
    })

</script>

<style scoped>
tbody tr:nth-of-type(odd) {
   background-color: rgba(0, 0, 0, .03);
 }
</style>