<template>
    <div class="d-flex align-center flex-column">
    <v-form>
         <v-card width="400">
            <v-card-title class="text-center">Login</v-card-title>
            <v-card-text>
               <v-text-field label="Username"/>
               <v-text-field label="Password" type="password" />
            </v-card-text>
            <v-card-actions class="d-flex align-center flex-column">
               <v-btn type="submit" border color="#FF9100">
                  Login
               </v-btn>
            </v-card-actions>
         </v-card>
      </v-form>
    </div>
</template>