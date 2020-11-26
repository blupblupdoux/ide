<template>
  <v-container class="mx-auto">

    <v-row class="mt-4 mb-8">
      <h1 class="mx-auto primary--text">Utilisateurs</h1>
    </v-row>
   
    <v-row class="d-block">
      <v-btn @click="addUser">Ajouter un utilisateur</v-btn>
      <v-data-table
        :headers="headers"
        :items="users" 
        hide-default-footer 
        @click:row="userDetails"
        class="elevation-1 mx-2"
        disable-pagination
      >

        <template v-slot:item.roles="{ item }">
          <v-icon v-if="item.roles.includes('ROLE_ADMIN')" color="success">fa-check</v-icon>
          <v-icon v-else>fa-times</v-icon>
        </template>

      </v-data-table>

      <UserForm @refreshUsers="userList"  />

    </v-row>
  </v-container>
</template>

<script>
import { mapState } from 'vuex'
import UserForm from '../components/userForm'

export default {
  name: 'Users',
  components: {
    UserForm
  },
  data: () => ({
    // table data :
    headers: [
      {text: 'Nom', value: 'lastname'},
      {text: 'Prénom', value: 'firstname'},
      {text: 'Mail', value: 'email', sortable: false},
      {text: 'Téléphone', value: 'phone', sortable: false},
      {text: 'Admin', value: 'roles', sortable: false},
    ],
    users: [],
    userClicked: {}
  }),
  computed: {
    ...mapState(['api_url']),
  },
  methods: {
    userList() {
      this.$axios
        .get(`${this.api_url}/user/`)
        .then(response => { this.users = response.data })
    },
    userDetails(event) {

      this.$axios
        .get(`${this.api_url}/user/${event.id}`)
        .then(response => { 
          this.userClicked = response.data
          this.$root.$refs.userForm.openDialog(this.userClicked)
        })
    },
    addUser() {
      this.$root.$refs.userForm.allowAddUser()
      this.$root.$refs.userForm.openDialog(this.userClicked)
    },
  },
  mounted() {
    this.userList()
  }
}
</script>

<style lang="scss">

.container {

	.v-data-table {

		a {
			text-decoration: none;
		}

    .v-data-table-header{
      background-color: #eeeeee;
    }
	}
}

</style>