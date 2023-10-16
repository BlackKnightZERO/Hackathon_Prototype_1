<template>
    <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }}</h2>

        <v-card class="mt-2">
            <v-tabs v-model="tab" bg-color="orange-lighten-1" centered stacked>
                <v-tab value="one">
                    <v-icon>mdi-ticket</v-icon>
                    Overview
                </v-tab>
                <v-tab value="two">
                    <v-icon>mdi-account</v-icon>
                    Detail
                </v-tab>
                <v-tab value="three">
                    <v-icon>mdi-pencil</v-icon>
                    Edit
                </v-tab>
            </v-tabs>

            <v-card-text>
                <v-window v-model="tab">
                    <v-window-item value="one">
                        <OverviewTab 
                          :renderElement="!($store.state.role === 'Admin' && routerParam === '')"
                          :apiData="apiData"
                        />
                    </v-window-item>

                    <v-window-item value="two">
                        <!-- <v-form @submit.prevent="submitForm" ref="formRef"> -->
                            <DetailTab 
                            :renderElement="!($store.state.role === 'Admin' && routerParam === '')"
                            :apiData="apiData"
                            />
                        <!-- </v-form> -->
                    </v-window-item>

                    <v-window-item value="three"> Three </v-window-item>
                </v-window>
            </v-card-text>
        </v-card>
    </div>
</template>

<script setup>
import { ref, onBeforeMount, watch } from "vue";
import { useRoute } from "vue-router";
import store from '../store/index.js'

import OverviewTab from "../components/Profile/OverviewTab.vue";
import DetailTab from "../components/Profile/DetailTab.vue";
import modulePermission from "../helper/modulePermission.js";

    const route = useRoute();
    const routerParam = ref("");
    const tab = ref(null);
    const moduleName = "Profile";
    const apiData = ref([]);
    const loginForm = ref(null)
    const formData = ref({
        user: {
            id: '',
            first_name: '',
            last_name: '',
            email: '',
            username: '',
            password: '',
            password_confirmation: '',
        },
        user_detail: {
            id: '',
            academic_email: '',
            personal_email: '',
            institution: '',
            program: '',
            program_start: '',
            program_end: '',
            phone_1: '',
            phone_2: '',
            image_path: '',
            resume_path: '',
        },
        role: {
            id: ''
        },
        coop_term: {
            id: '',
            ministry_id: '',
            term: '',
            term_start: '',
            term_end: '',
            position: '',
        }
    });
    const canPerform = modulePermission(moduleName);
    const loading = ref(false);

    const fetchData = async (id) => {
        loading.value = true
        await axios({
            method: 'GET',
            url: '/api/show-with-coop-ticket/'+id,
            data: {}
        }).then(res => {
            apiData.value = res.data.data[0]
            formData.value = res.data.data[0]
            // console.log(apiData.value)
        }).catch(err => {
            console.log(err)
        })
        loading.value = false
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

    onBeforeMount(() => {
        routerParam.value = route.params.id ? route.params.id : "";
        if(store.state.role === 'Admin' && routerParam.value !== "") {
          fetchData(routerParam.value)
        } else {
            fetchData(store.state.user.id)
        }
    });

</script>