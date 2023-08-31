<template>
    <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      width="1024"
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
                  label="Title*"
                  required
                  name="title"
                  :rules="titleRules"
                  :model-value="formData.title"
                  @input='$emit("addInputChange", $event)'
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Description*"
                  required
                  name="description"
                  :rules="descriptionRules"
                  :model-value="formData.description"
                  @input='$emit("addInputChange", $event)'
                ></v-text-field>
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

const { dialog, moduleName, formData } = defineProps({ dialog: Boolean,  moduleName: String, formData: Object })

const titleRules = ref([
      v => !!v || 'Title is required',
   ])
const descriptionRules = ref([
      v => !!v || 'Description is required',
   ])

</script>