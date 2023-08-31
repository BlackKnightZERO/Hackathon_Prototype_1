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
            <div>
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
                <MinistryFormModel 
                    :dialog="dialog" 
                    :moduleName="moduleName" 
                    :formData="formData"
                    @addInputChange="addInputChange"
                    @openModal="openModal" 
                    @closeModal="closeModal" 
                    @submitForm="submitForm" />
            </v-form>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import modulePermission from '../helper/modulePermission.js'
import MinistryFormModel from '../components/Ministry/MinistryFormModal.vue'
import store from '../store/index.js'

    const emit = defineEmits(['openModal', 'closeModal', 'submitForm', 'addInputChange'])

    const moduleName = 'Ministry'

    const apiData = ref([])
    const canPerform = modulePermission(moduleName)
    const searchValue = ref('')

    const loading = ref(false)
    const serverItemsLength = ref(0)
    const rowItems = [20]

    const dialog = ref(false)
    const formData = ref({title:'', description: ''})
    const formRef = ref(null)

    const headers = [
        // { text: "Id", value: "id" },
        { text: "Title", value: "title" },
        { text: "Abbr", value: "short_title" },
        { text: "Description", value: "description" },
        { text: "Operation", value: "operation" },
    ]

    const serverOptions = ref({
        page: 1,
        rowsPerPage: 20,
        sortBy: 'title',
        sortType: 'desc',
    })

    const fetchData = async () => {
        loading.value = true
        await axios({
            method: 'GET',
            url: '/api/ministries?page='+serverOptions.value.page+'&search='+searchValue.value,
            data: {}
        }).then(res => {
            apiData.value = res.data.data
            serverItemsLength.value = res.data.meta.total;
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
    }

    const addInputChange = (event) => {
        formData.value = { ...formData.value, [event.target.name]: event.target.value }
    }

    const submitForm = async () => {

        const { valid } = await formRef.value.validate()
        if( valid ) {
            loading.value = true
            if( formData.value?.id ) {
                await axios({
                    method: 'PUT',
                    url: '/api/ministries/'+formData.value.id,
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
                    url: '/api/ministries',
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
        openModal()
    }

    const deleteData = async (id) => {
        if(confirm('are you sure?')){
            await axios({
                method: 'DELETE',
                url: '/api/ministries/'+id,
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
        formData.value = {title:'', description: ''}
    }

    onMounted(() => {
        if(canPerform.includes('INDEX')) {
            fetchData()
        }
    })

    watch([serverOptions, () => searchValue], ([newServerOptions, newSearchValue]) => {
        if(canPerform.includes('INDEX')) {
            fetchData()
        }
    }, { deep : true })

</script>