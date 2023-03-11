<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }}</h2>
        <v-select
            :items="apiRolesData"
            label="Role"
            density="compact"
            style="width:30%; margin: 10px 0px;"
            v-model="roleRef"
            @update:modelValue="fetchRolePermissionModuleData"
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
                        <div v-if="roleRef!=''" v-for="_data in data.permissions" :key="_data.id">
                            <v-checkbox
                                v-model="_data.value"
                                :label="_data.title"
                                color="orange"
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
    const apiRolePermissionModuleData = ref([])
    const formData = ref({})
    const roleRef = ref('')
    const canPerform = modulePermission(moduleName)

    const items = ['User']

    const fetchRoleData = async () => {
        await axios({
            method: 'GET',
            url: '/api/roles?compact',
            data: {}
        }).then(res => {
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
            apiModuleData.value = res.data.data
        }).catch(err => {
            console.log(err)
        })
    }

    const fetchRolePermissionModuleData = async () => {
        if(roleRef.value !== '') {
            const role = apiRolesData.value.find( f => f.title === roleRef.value)
            await axios({
                method: 'GET',
                url: '/api/role-permissions?id='+role.id,
                data: {}
            }).then(res => {
                apiRolePermissionModuleData.value = res.data.permissions
                const updatedData = apiModuleData.value.map(m => {
                    let moddedPermissions = m.permissions.map( n => {
                        return checkPermission(m, n, res.data.permissions) ? {...n, value:true} : {...n, value:false}
                    })
                    return {...m, permissions: moddedPermissions}
                })
                apiModuleData.value = updatedData
            }).catch(err => {
                console.log(err)
            })
        }
    }

    const checkPermission = (module, modulePermission, rolePermissionModule) => {
        for (const [key, value] of Object.entries( rolePermissionModule )) {
            if(parseInt(key) == parseInt(module.id) && value.includes(parseInt(modulePermission.id))) {
                return true
            }
        }
        return false
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