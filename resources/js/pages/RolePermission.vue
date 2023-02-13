<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }}</h2>
        <v-select
            :items="items"
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
                        Index
                    </th>
                    <th class="text-left">
                        View
                    </th>
                    <th class="text-left">
                        Create
                    </th>
                    <th class="text-left">
                        Update
                    </th>
                    <th class="text-left">
                        Delete
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>
                        <v-checkbox
                            v-model="ex4"
                            label=""
                            color="orange"
                            value="orange"
                            hide-details
                        ></v-checkbox>
                    </td>
                    <td>
                        <v-checkbox
                            v-model="ex4"
                            label=""
                            color="orange"
                            value="orange"
                            hide-details
                        ></v-checkbox>
                    </td>
                    <td>
                        <v-checkbox
                            v-model="ex4"
                            label=""
                            color="orange"
                            value="orange"
                            hide-details
                        ></v-checkbox>
                    </td>
                    <td>
                        <v-checkbox
                            v-model="ex4"
                            label=""
                            color="orange"
                            value="orange"
                            hide-details
                        ></v-checkbox>
                    </td>
                    <td>
                        <v-checkbox
                            v-model="ex4"
                            label=""
                            color="orange"
                            value="orange"
                            hide-details
                        ></v-checkbox>
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

    const apiData = ref([])
    const ex4 = ref("ki jani")
    const roleRef = ref('')
    const canPerform = modulePermission(moduleName)

    const items = ['User']

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