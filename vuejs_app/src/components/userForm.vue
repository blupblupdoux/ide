<template>
  <v-dialog v-model="dialog" max-width="65%" @click:outside="disableModification">
    <v-card>
      <v-card-title>{{user.lastname }} {{ user.firstname }}</v-card-title>
      <v-form>
        <v-row class="card-content">
          <v-col cols="6" class="user-contact">
            <v-text-field 
              label="Email" 
              :value="user.email" 
              dense 
              :readonly="!modification" 
              outlined>
            </v-text-field>

            <v-text-field 
              label="Téléphone" 
              :value="user.phone" 
              dense 
              :readonly="!modification"  
              outlined>
            </v-text-field>

            <div class="user-address">
              <v-card-text>Adresse</v-card-text>
              <v-text-field 
                label="Adresse" 
                :value="user.address" 
                dense 
                :readonly="!modification"  
                outlined>
              </v-text-field>

              <v-text-field 
                label="Code Postal" 
                :value="user.postcode" 
                dense 
                :readonly="!modification"  
                outlined>
              </v-text-field>

              <v-text-field 
                label="Ville" 
                :value="user.city" 
                dense 
                :readonly="!modification"  
                outlined>
              </v-text-field>
            </div>
          </v-col>
          <v-col cols="6" class="user-infos">
            <v-img 
            max-height="120"
            max-width="120"
            src="https://www.semencesdefrance.com/wp-content/uploads/2020/01/placeholder.png">
            </v-img>
            <v-checkbox
              label="Admin" 
              :readonly="!modification" 
            ></v-checkbox>
            <v-text-field 
              label="Date de naissance" 
              :value="user.birthday" 
              dense 
              :readonly="!modification"  
              outlined>
            </v-text-field>

            <v-textarea
              label="Description" 
              :value="user.description" 
              :readonly="!modification"  
              outlined>
            </v-textarea>
          </v-col>
        </v-row>
      </v-form>
      <v-card-actions>
        <v-btn @click.stop="modification = true">Modif</v-btn>
        <v-btn>Suppr</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'UserForm',
  props: ['user'],
  data: () => ({
    modification: false,
    dialog: false
  }),
  methods: {
    openDialog() {
      this.dialog = true
    },
    disableModification() {
      this.modification = false
    }
  },
  created() {
    this.$root.$refs.userForm = this
  }
}
</script>

<style>

</style>