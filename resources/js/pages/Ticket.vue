<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }} 
            <span v-if="canPerform.includes('CREATE')">
                <v-btn type="submit" 
                    style="float:right;"
                    :loading="loading"
                    size="small" 
                    color="warning">
                    + Add
                </v-btn>
            </span>
        </h2>
        <div class="d-flex justify-space-between">
            <div class="d-flex justify-start">
                <div class="mr-1">
                    <v-text-field
                        density="compact"
                        variant="underlined"
                        label="Search.."
                        append-inner-icon="mdi-magnify"
                        single-line
                        hide-details
                        v-model="searchValue"
                        style="width:12rem; margin: 10px 0px;"
                    ></v-text-field>
                </div>
                <div class="mr-1">
                    <v-select
                        :items="apiStatusData"
                        label="Status"
                        density="compact"
                        style="min-width:5rem; margin: 10px 0px;"
                        v-model="statusRef"
                        @update:modelValue="fetchFilteredStatusTableData"
                    ></v-select>
                </div>
                <div class="mr-1">
                    <v-select
                        :items="apiApproveStatusData"
                        label="Approval"
                        density="compact"
                        style="min-width:5rem; margin: 10px 0px;"
                        v-model="approveStatusRef"
                        @update:modelValue="fetchFilteredStatusTableData"
                    ></v-select>
                </div>
            </div>
        </div>

        <EasyDataTable
            v-model:server-options="serverOptions"
            :server-items-length="serverItemsLength"
            :loading="loading"
            :headers="headers"
            :items="apiData"
            :rows-items="rowItems"
            show-index
        >
            <template #item-operation="item">
                <div class="operation-wrapper">
                    <v-btn
                        class="ma-2"
                        color="success"
                        size="x-small"
                        v-if="canPerform.includes('UPDATE')"
                    >
                        Edit
                        <v-icon
                        end
                        icon="mdi-pencil"
                        ></v-icon>
                    </v-btn>
                    <v-btn
                        class="ma-2"
                        color="error"
                        size="x-small"
                        v-if="canPerform.includes('DELETE')"
                    >
                        Delete
                        <v-icon
                        end
                        icon="mdi-delete"
                        ></v-icon>
                    </v-btn>
                </div>
            </template>
        </EasyDataTable>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import modulePermission from '../helper/modulePermission.js'

    const moduleName = 'Ticket'

    const apiData = ref([])
    const apiStatusData = ref([])
    const apiApproveStatusData = ref([])
    const canPerform = modulePermission(moduleName)
    const searchValue = ref('')
    const statusRef = ref('')
    const approveStatusRef = ref('')

    const loading = ref(false)
    const serverItemsLength = ref(0)
    const rowItems = [20]

    const serverOptions = ref({
        page: 1,
        rowsPerPage: 20,
        sortBy: 'ticket_id',
        sortType: 'desc',
    })

    const headers = [
        // { text: "Id", value: "id" },
        { text: "Ticket ID", value: "ticket_id" },
        { text: "Developer", value: "user.full_name" },
        { text: "Start Day", value: "start_day" },
        { text: "End Day", value: "end_day" },
        { text: "Status", value: "status" },
        { text: "Approval", value: "verify_status" },
        { text: "Operation", value: "operation" },
    ]

    const fetchStatus = async () => {
        loading.value = true
        await axios({
            method: 'GET',
            url: '/api/get-ticket-status',
            data: {}
        }).then(res => {
            apiStatusData.value = res.data.data
        }).catch(err => {
            console.log(err)
        })
        loading.value = false
    }

    const fetchApproveStatus = async () => {
        loading.value = true
        await axios({
            method: 'GET',
            url: '/api/get-approve-status',
            data: {}
        }).then(res => {
            apiApproveStatusData.value = res.data.data
        }).catch(err => {
            console.log(err)
        })
        loading.value = false
    }

    const fetchData = async () => {
        loading.value = true
        await axios({
            method: 'GET',
            url: '/api/tickets?page='+serverOptions.value.page+'&search='+searchValue.value+'&approveStatus='+approveStatusRef.value+'&status='+statusRef.value,
            data: {}
        }).then(res => {
            apiData.value = res.data.data
            serverItemsLength.value = res.data.meta.total;
        }).catch(err => {
            console.log(err)
        })
        loading.value = false
    }

    const fetchFilteredStatusTableData = async () => {
        
    }

    onMounted(() => {
        if(canPerform.includes('INDEX')) {
            fetchStatus()
            fetchApproveStatus()
            fetchData()
        }
    })

    watch([ serverOptions, () => searchValue, () => statusRef, () => approveStatusRef], 
        ([newServerOptions, newSearchValue, newStatusRef, newApproveStatusRef ]) => {
            if(canPerform.includes('INDEX')) {
                fetchData()
            }
    }, { deep : true })

</script>