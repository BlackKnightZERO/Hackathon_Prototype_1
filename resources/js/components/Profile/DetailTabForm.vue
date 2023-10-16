<template>
    <v-form v-model="valid">
    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="formData.user.first_name"
            :rules="first_nameRules"
            label="First name"
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="formData.user.last_name"
            :rules="last_nameRules"
            label="Last name"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="formData.user.email"
            :rules="emailRules"
            label="Email"
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="formData.user.username"
            :rules="usernameRules"
            label="Username"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="formData.user.password"
            :rules="passwordRules"
            label="Password"
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="formData.user.password_confirmation"
            :rules="password_confirmationRules"
            label="Confirm Password"
            required
          ></v-text-field>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script setup>
import { ref } from "vue";
    
    const { renderElement, apiData } = defineProps({  renderElement: Boolean, apiData: Object })
    const valid =  ref(false)

    const first_nameRules = ref([
      v => !!v || 'Field is required',
   ])
    const last_nameRules = ref([
      v => !!v || 'Field is required',
   ])
    const emailRules = ref([
      v => !!v || 'Email is required',
      v => /.+@.+/.test(v) || 'E-mail must be valid'
   ])
    const usernameRules = ref([
      v => !!v || 'Field is required',
   ])
    const passwordRules = ref([
      v => !!v || 'Password is required',
      v => (v && v.length >= 6) || 'Name must be at least 6 charachters',
   ])
    const password_confirmationRules = ref([
      v => !!v || 'Password is required',
      v => (v && v.length >= 6) || 'Name must be at least 6 charachters',
   ])
</script>