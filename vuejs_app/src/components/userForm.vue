<template>
  <v-dialog v-model="dialog" :max-width="$vuetify.breakpoint.smAndUp ? '75%' : '95%'" @click:outside="closeDialog">
    <v-card class="px-6 py-2">

      <v-card-title v-if="!modifUser && !addUser">{{user.lastname }} {{ user.firstname }}</v-card-title>
      <v-card-title v-else-if="modifUser">Modifier l'utilisateur</v-card-title>
      <v-card-title v-else-if="addUser">Ajouter un utilisateur</v-card-title>

      <v-form @submit.prevent="submitUser" ref="form">
        <v-row class="card-content">
          <v-col cols="12" md="6" class="user-contact">

            <v-row>
              <v-col v-if="!addUser" class="mb-3" >
                <v-img 
                  max-height="120"
                  max-width="120"
                  src="https://www.semencesdefrance.com/wp-content/uploads/2020/01/placeholder.png">
                </v-img>
              </v-col>
              <v-col class="py-0">
                <v-checkbox
                  label="Admin" 
                  v-model="user.admin"
                  :readonly="!modifUser && !addUser"
                  class="mt-0"
                ></v-checkbox>
              </v-col>
            </v-row>

            <v-text-field 
              v-if="addUser || modifUser" 
              label="Nom *"  
              v-model="user.lastname" 
              :rules="[rules.required, rules.maxLength(user.lastname)]"
              :readonly="!modifUser && !addUser" 
              dense
              outlined>
            </v-text-field>

            <v-text-field 
              v-if="addUser || modifUser" 
              label="Prénom *"  
              v-model="user.firstname" 
              :rules="[rules.required, rules.maxLength(user.firstname)]"
              :readonly="!modifUser && !addUser" 
              dense
              outlined>
            </v-text-field>

            <v-text-field 
              label="Email *"  
              v-model="user.email" 
              :rules="[rules.required, rules.email]"
              :readonly="!modifUser && !addUser" 
              dense
              outlined>
            </v-text-field>

            <v-text-field 
              v-if="addUser"
              type="password"
              label="Mot de passe *"  
              v-model="user.password" 
              :rules="[rules.required, rules.password]"
              :readonly="!modifUser && !addUser" 
              dense
              outlined>
            </v-text-field>

            <v-text-field 
              label="Téléphone"  
              v-model="user.phone" 
              :rules="[rules.maxLength(user.phone)]"
              :readonly="!modifUser && !addUser" 
              dense
              outlined>
            </v-text-field>

          </v-col>

          <v-col cols="12" md="6" class="user-infos">
            <div class="user-address">

              <v-text-field 
                label="Adresse"  
                v-model="user.address" 
                :rules="[rules.maxLength(user.address)]"
                :readonly="!modifUser && !addUser" 
                dense
                outlined>
              </v-text-field>

              <v-row>
                <v-col cols="12" sm="6">
                  <v-text-field 
                    label="Code Postal"  
                    v-model="user.postcode" 
                    :rules="[rules.maxLength(user.postcode)]"
                    :readonly="!modifUser && !addUser" 
                    dense
                    outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field 
                    label="Ville"  
                    v-model="user.city" 
                    :rules="[rules.maxLength(user.city)]"
                    :readonly="!modifUser && !addUser" 
                    dense
                    outlined>
                  </v-text-field>
                </v-col>
              </v-row>
            </div>

            <v-menu
              v-model="birthdayPicker"
              :close-on-content-click="false"
              :nudge-right="40"
              min-width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="user.birthday"
                  label="Date de naissance"
                  prepend-icon="mdi-calendar"
                  readonly
                  outlined
                  dense
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="user.birthday"
                @input="birthdayPicker = false"
              ></v-date-picker>
            </v-menu>

            <v-textarea
              v-model="user.description"
              label="Description" 
              :rules="[rules.maxLength(user.description, 1000)]"
              :readonly="!modifUser && !addUser" 
              height="130px" 
              outlined>
            </v-textarea>

          </v-col>
        </v-row>

        <v-card-actions class="d-flex justify-center">
          <v-btn v-show="!modifUser && !addUser" @click="modifUser = true" color="warning">Activer la modification</v-btn>
          <v-btn v-show="modifUser" type="submit" color="primary">Enregistrer les modifications</v-btn>
          <v-btn v-show="addUser" type="submit" color="primary">Valider</v-btn>
          <v-btn v-show="!addUser" @click="deleteUser" color="error">Supprimer l'utilisateur</v-btn>
        </v-card-actions>

      </v-form>

    </v-card>
  </v-dialog>
</template>

<script>

import { mapState } from 'vuex'
import { formMixin } from '../mixins/form'

export default {
  name: 'UserForm',
  mixins: [formMixin],
  data: () => ({
    addUser: false,
    modifUser: false,
    dialog: false,
    birthdayPicker: false,
    user: {},
  }),
  computed: {
    ...mapState(['api_url']),
  },
  methods: {
    openDialog(user) {
      this.dialog = true
      if(!this.addUser) {
        this.user = user
        if(user.birthday) {
          this.user.birthday = user.birthday.substr(0, 10)
        }
        if(user.roles.includes('ROLE_ADMIN')){
          this.user.admin = true
        } else {
          this.user.admin = false
        }
      }
    },
    closeDialog() {
      this.dialog = false
      this.addUser = false
      this.modifUser = false
      this.user = {}
      this.$emit('refreshUsers');
    },
    allowAddUser() {
      this.addUser = true
      this.modifUser = false
    },
    isValid () {
			return this.$refs.form.validate()
		},
    submitUser() {

      let user_JSON = JSON.stringify(this.user)

      if(this.isValid()) {
        if(this.user.id) {
          this.$axios
            .post(`${this.api_url}/user/edit`, user_JSON)
            .then(response => {
              this.modifUser = false
              this.openDialog(response.data)
            })

        } else {
          this.$axios
            .post(`${this.api_url}/user/add`, user_JSON)
            .then(() => this.closeDialog())
        }
      }
    },
    deleteUser() {
      if(this.user.id) {
        this.$axios
          .post(`${this.api_url}/user/delete/${this.user.id}`)
          .then(() => this.closeDialog())
      }
    }
  },
  created() {
    this.$root.$refs.userForm = this
  }
}
</script>

<style lang="scss">

</style>