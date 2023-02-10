<template>
    <div v-if="!canPerform.includes('INDEX')">
        <Page403 />
    </div>
    <div v-else>
        <h2>{{ moduleName }}</h2>
        <v-text-field
            density="compact"
            variant="underlined"
            label="Search.."
            append-inner-icon="mdi-magnify"
            single-line
            hide-details
            v-model="searchValue"
            style="width:30%; margin: 10px 0px;"
        ></v-text-field>

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
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import modulePermission from '../helper/modulePermission.js'
import Page403 from './Page403.vue'

    const moduleName = 'Ministry'

    const apiData = ref([])
    const canPerform = modulePermission(moduleName)
    const searchValue = ref('')

    const loading = ref(false)
    const serverItemsLength = ref(0)
    const rowItems = [20]

    const serverOptions = ref({
        page: 1,
        rowsPerPage: 20,
        sortBy: 'title',
        sortType: 'desc',
    })

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