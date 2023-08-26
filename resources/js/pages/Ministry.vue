<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }}
            <span v-if="canPerform.includes('CREATE')">
                <v-btn type="submit"
                    style="float:right;"
                    :loading="loading"
                    size="small" 
                    color="warning"
                    @click="toggleModal(true)">
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
        <MinistryFormModel :dialog="dialog" :moduleName="moduleName" @toggleModal="toggleModal" />
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import modulePermission from '../helper/modulePermission.js'
import MinistryFormModel from '../components/Ministry/MinistryFormModal.vue'

    const moduleName = 'Ministry'

    const apiData = ref([])
    const canPerform = modulePermission(moduleName)
    const searchValue = ref('')
    const dialog = ref(false)

    const loading = ref(false)
    const serverItemsLength = ref(0)
    const rowItems = [20]

    const serverOptions = ref({
        page: 1,
        rowsPerPage: 20,
        sortBy: 'title',
        sortType: 'desc',
    })

    const emit = defineEmits(['toggleModal'])
    const toggleModal = (status) => {
        dialog.value = status
    }

    const headers = [
        { text: "Id", value: "id" },
        { text: "Title", value: "title" },
        { text: "Abbr", value: "short_title" },
        { text: "Description", value: "description" },
        { text: "Operation", value: "operation" },
    ]

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