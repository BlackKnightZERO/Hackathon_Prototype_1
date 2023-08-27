<template>
    <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      width="1024"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5">Add {{ moduleName }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Title*"
                  required
                  name="title"
                  @input='$emit("addInputChange", $event)'
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Description*"
                  required
                  name="description"
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
            @click="$emit('toggleModal', false)"
          >
            Close
          </v-btn>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="$emit('submitAddForm')"
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

const { dialog, moduleName } = defineProps({ dialog: Boolean,  moduleName: String })

</script>