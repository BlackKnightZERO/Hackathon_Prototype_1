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
        <v-form @submit.prevent="submitForm" ref="permissionForm">
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
            <v-card-actions class="d-flex align-start flex-column">
                <v-btn v-if="roleRef!='' && canPerform.includes('UPDATE')" 
                    type="submit" 
                    :loading="loading" 
                    border 
                    color="warning">
                    Update
                </v-btn>
            </v-card-actions>
        </v-form>
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
    const loading = ref(false)
    const permissionForm = ref(null)
    const canPerform = modulePermission(moduleName)

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
                apiRolePermissionModuleData.value = res.data[0].permissions
                const updatedData = apiModuleData.value.map(m => {
                    let moddedPermissions = m.permissions.map( n => {
                        return checkPermission(m, n, res.data[0].permissions) ? {...n, value:true} : {...n, value:false}
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
            if(parseInt(key) === parseInt(module.id) && value.includes(parseInt(modulePermission.id))) {
                return true
            }
        }
        return false
    }

    const submitForm = async () => {
        const role = apiRolesData.value.find( f => f.title === roleRef.value)
        await axios({
            method: 'PUT',
            url: '/api/role-permissions/'+role.id,
            data: {
                syncData: apiModuleData.value,
            }
        }).then(res => {
            console.log(res)
            // store.dispatch('UPDATE_ALERT', {
            //    value: true,
            //    type: 'success',
            //    text: 'Login Successful',
            // })
        }).catch(err => {
            // const alertMsg = err?.response?.data?.message ? err?.response?.data?.message : 'Login Failed'
            // store.dispatch('UPDATE_ALERT', {
            //    value: true,
            //    type: 'error',
            //    text: alertMsg,
            // })
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