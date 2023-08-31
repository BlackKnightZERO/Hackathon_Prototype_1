<template>
    <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      width="1280"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5" v-if="formData.id">Edit {{ moduleName }}</span>
          <span class="text-h5" v-else>Add {{ moduleName }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <input type="hidden" name="id" :value="formData.id" >
                <v-text-field
                  label="Ticket Id*"
                  required
                  name="ticket_id"
                  :model-value="formData.ticket_id"
                  @input='$emit("inputChange", $event)'
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Link*"
                  required
                  name="link"
                  :model-value="formData.link"
                  @input='$emit("inputChange", $event)'
                ></v-text-field>
              </v-col>
              <v-col cols="12" v-if="role=='Admin'">
                <v-select
                    :items="apiUserNameData"
                    label="Developer"
                    density="compact"
                    style="min-width:5rem; margin: 10px 0px;"
                    name="user_id"
                    required
                    :model-value="userRef"
                    @update:modelValue='$emit("selectChange", "user_id", true, $event)'
                ></v-select>
              </v-col>
              <v-col cols="4">
                <label for="">Start Day</label><br><br>
                <input 
                    type="date" 
                    name="start_day"
                    required
                    :value="formData.start_day"
                    @input='$emit("inputChange", $event)'>
              </v-col>
              <v-col cols="4">
                <label for="">End Day</label><br><br>
                <input 
                    type="date" 
                    name="end_day"
                    required
                    :value="formData.end_day"
                    @input='$emit("inputChange", $event)'>
              </v-col>
              <v-col cols="4">
                <v-text-field
                  label="Proposed Days*"
                  required
                  name="proposed_completion_day"
                  :model-value="formData.proposed_completion_day"
                  @input='$emit("inputChange", $event)'
                ></v-text-field>
              </v-col>
              <v-col cols="4">
                <v-select
                    :items="apiStatusData"
                    label="Status"
                    density="compact"
                    style="min-width:5rem; margin: 10px 0px;"
                    name="status"
                    required
                    :model-value="formData.status"
                    @update:modelValue='$emit("selectChange", "status", false, $event)'
                ></v-select>
              </v-col>
              <v-col cols="4">
                    <v-select
                        :items="apiApproveStatusData"
                        label="Approval"
                        density="compact"
                        style="min-width:5rem; margin: 10px 0px;"
                        name="verify_status"
                        required
                        :model-value="formData.verify_status"
                        @update:modelValue='$emit("selectChange", "verify_status", false, $event)'
                    ></v-select>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="$emit('closeModal')"
          >
            Close
          </v-btn>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="$emit('submitForm')"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script setup>
import { ref } from "vue"

const { role, moduleName, userRef, dialog, formData, apiStatusData, apiApproveStatusData, apiUserNameData } = defineProps({ 
        role: String, 
        moduleName: String,  
        userRef: String,  
        dialog: Boolean,  
        formData: Object,
        apiStatusData: Object,
        apiApproveStatusData: Object,
        apiUserNameData: Object,
    })

</script>