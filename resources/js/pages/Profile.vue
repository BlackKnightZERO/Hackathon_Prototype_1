<template>
  <div v-if="canPerform.includes('INDEX')">
        <h2>{{ moduleName }}</h2>

        <v-card class="mt-2">
          <v-tabs
            v-model="tab"
            bg-color="orange-lighten-1"
            centered
            stacked
          >
            <v-tab value="one">
              <v-icon>mdi-ticket</v-icon>
              Overview
            </v-tab>
            <v-tab value="two">
              <v-icon>mdi-account</v-icon>
              Details
            </v-tab>
            <v-tab value="three">
              <v-icon>mdi-pencil</v-icon>
              Edit
            </v-tab>
          </v-tabs>

          <v-card-text>
            <v-window v-model="tab">

              <v-window-item value="one">
                <OverviewTab />
              </v-window-item>

              <v-window-item value="two">
                Two
              </v-window-item>

              <v-window-item value="three">
                Three
              </v-window-item>

            </v-window>
          </v-card-text>
        </v-card>

  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import { useRoute } from 'vue-router'
import OverviewTab from "../components/Profile/OverviewTab.vue"
import modulePermission from '../helper/modulePermission.js'

  const route = useRoute()
  const routerParam = ref('')

  const tab = ref(null)
  const text = ref('Lorem ipsum dolor sit amet')

  const moduleName = 'Profile'
  const apiData = ref([])
  const canPerform = modulePermission(moduleName)
  const loading = ref(false)

onMounted(() => {
    routerParam.value = route.params.id ? route.params.id : '' 
})

</script>