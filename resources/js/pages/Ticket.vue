<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }} 
            <span v-if="canPerform.includes('CREATE')">
                <v-btn type="submit" 
                    style="float:right;"
                    :loading="loading"
                    size="small" 
                    color="warning"
                    @click="openModal()">
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
                        @update:modelValue="fetchData"
                    ></v-select>
                </div>
                <div class="mr-1">
                    <v-select
                        :items="apiApproveStatusData"
                        label="Approval"
                        density="compact"
                        style="min-width:5rem; margin: 10px 0px;"
                        v-model="approveStatusRef"
                        @update:modelValue="fetchData"
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
                        color="indigo-darken-3"
                        size="x-small"
                        v-if="canPerform.includes('DELETE')"
                        @click="viewProfile(item.id)"
                    >
                        Profile
                        <v-icon
                        end
                        icon="mdi-account"
                        ></v-icon>
                    </v-btn>
                    <v-btn
                        class="ma-2"
                        color="success"
                        size="x-small"
                        v-if="canPerform.includes('UPDATE')"
                        @click="editData(item.id, item.index)"
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
                        @click="deleteData(item.id, item.index)"
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
        <v-form @submit.prevent="submitForm" ref="formRef">
                <TikcetFormModal 
                    :dialog="dialog" 
                    :moduleName="moduleName" 
                    :formData="formData"
                    :apiStatusData="apiStatusData"
                    :apiApproveStatusData="apiApproveStatusData"
                    :role="store.state.role"
                    :apiUserNameData="apiUserNameData"
                    :userRef="userRef"
                    @inputChange="inputChange"
                    @selectChange="selectChange"
                    @openModal="openModal" 
                    @closeModal="closeModal" 
                    @submitForm="submitForm" />
            </v-form>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import modulePermission from '../helper/modulePermission.js'
import TikcetFormModal from '../components/Ticket/TicketFormModal.vue'
import store from '../store/index.js'
import { useRouter } from 'vue-router'

    const emit = defineEmits(['openModal', 'closeModal', 'submitForm', 'inputChange', 'selectChange'])
    const router = useRouter()

    const moduleName = 'Ticket'

    const apiData = ref([])
    const apiUserData = ref([])
    const apiUserNameData = ref([])
    const apiStatusData = ref([])
    const apiApproveStatusData = ref([])
    const canPerform = modulePermission(moduleName)
    const searchValue = ref('')
    const statusRef = ref('')
    const approveStatusRef = ref('')
    const userRef = ref('')

    const loading = ref(false)
    const serverItemsLength = ref(0)
    const rowItems = [20]

    const dialog = ref(false)
    const formData = ref({
        ticket_id: '',
        link: '',
        start_day: '',
        end_day: '',
        proposed_completion_day: '',
        status: 'Pending',
        user_id: '',
        approver_id: '',
        verify_status: 'Not Approved',
    })
    
    const formRef = ref(null)

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
        { text: "Proposed Day", value: "proposed_completion_day" },
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

    const fetchUserData = async () => {
        loading.value = true
        await axios({
            method: 'GET',
            url: '/api/users?compact',
            data: {}
        }).then(res => {
            apiUserData.value = res.data.data
            apiUserNameData.value = apiUserData.value.map(m => m.full_name)
        }).catch(err => {
            console.log(err)
        })
        loading.value = false
    }

    const openModal = () => {
        dialog.value = true
    }

    const closeModal = () => {
        clearForm()
        dialog.value = false
        userRef.value = ''
    }

    const inputChange = (event) => {
        formData.value = { ...formData.value, [event.target.name]: event.target.value }
    }

    const selectChange = (name, filterable = false, value) => {
        if(filterable) {
            const selected_user = apiUserData.value.find( f => f.full_name == value)
            formData.value = { ...formData.value, [name]: selected_user.id }
            userRef.value = value
        } else {
            formData.value = { ...formData.value, [name]: value }
        }
    }

    const submitForm = async () => {
        
        const { valid } = await formRef.value.validate()

        if( valid ) {

            loading.value = true
            
            if( store.state.role === 'Admin' ) {
                formData.value = { ...formData.value, approver_id: store.state.user.id }
            } else {
                formData.value = { ...formData.value, user_id: store.state.user.id, approver_id: 1 }
            }

            if( formData.value?.id ) {
                await axios({
                    method: 'PUT',
                    url: '/api/tickets/'+formData.value.id,
                    data: formData.value
                }).then(res => {
                    let newData = apiData.value.map(item => item.id == formData.value.id ? res.data.data : item);
                    apiData.value = newData
                    store.dispatch('UPDATE_ALERT', {
                    value: true,
                    type: 'success',
                    text: res?.data?.message ? res?.data?.message : 'Operation Successful',
                    })
                }).catch(err => {
                    const alertMsg = err?.response?.data?.message ? err?.response?.data?.message : 'Operation Failed'
                    store.dispatch('UPDATE_ALERT', {
                    value: true,
                    type: 'error',
                    text: alertMsg,
                    })
                    console.log(err)
                })
            } else {
                await axios({
                    method: 'POST',
                    url: '/api/tickets',
                    data: formData.value
                }).then(res => {
                    apiData.value = [ res.data.data, ...apiData.value ]
                    store.dispatch('UPDATE_ALERT', {
                    value: true,
                    type: 'success',
                    text: res?.data?.message ? res?.data?.message : 'Operation Successful',
                    })
                }).catch(err => {
                    const alertMsg = err?.response?.data?.message ? err?.response?.data?.message : 'Operation Failed'
                    store.dispatch('UPDATE_ALERT', {
                    value: true,
                    type: 'error',
                    text: alertMsg,
                    })
                    console.log(err)
                })
            }
            loading.value = false
            closeModal()
            clearForm()

        }
    }

    const editData = (id) => {
        const filteredData = apiData.value.filter(f => f.id === id)
        formData.value = filteredData[0]
        userRef.value = filteredData[0].user.full_name
        openModal()
    }

    const deleteData = async (id) => {
        if(confirm('are you sure?')){
            await axios({
                method: 'DELETE',
                url: '/api/tickets/'+id,
                data: {}
            }).then(res => {
                let newData = apiData.value.filter(item => item.id != id);
                apiData.value = newData
                store.dispatch('UPDATE_ALERT', {
                   value: true,
                   type: 'success',
                   text: res?.data?.message ? res?.data?.message : 'Operation Successful',
                })
            }).catch(err => {
                const alertMsg = err?.response?.data?.message ? err?.response?.data?.message : 'Operation Failed'
                store.dispatch('UPDATE_ALERT', {
                   value: true,
                   type: 'error',
                   text: alertMsg,
                })
                console.log(err)
            })
        }
    }

    const clearForm = () => {
        formData.value = {
            ticket_id: '',
            link: '',
            start_day: '',
            end_day: '',
            proposed_completion_day: '',
            status: 'Pending',
            user_id: '',
            approver_id: '',
            verify_status: 'Not Approved',
        }
    }

    const viewProfile = (id) => {
        router.push('/profile/')
    }

    onMounted(() => {
        if(canPerform.includes('INDEX')) {
            fetchStatus()
            fetchApproveStatus()
            fetchData()
            fetchUserData()
        }
    })

    watch([ serverOptions, () => searchValue, () => statusRef, () => approveStatusRef], 
        ([newServerOptions, newSearchValue, newStatusRef, newApproveStatusRef ]) => {
            if(canPerform.includes('INDEX')) {
                fetchData()
            }
    }, { deep : true })

</script>