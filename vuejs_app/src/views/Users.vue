<template>
  <v-container class="mx-auto">

    <v-row class="mt-4 mb-8">
      <h1 class="mx-auto primary--text">Utilisateurs</h1>
    </v-row>
   
    <v-row class="d-block">
      <v-data-table
        :headers="headers"
        :items="users" 
        hide-default-footer 
        @click:row="userDetails"
        class="elevation-1 mx-2"
      >

        <template v-slot:item.roles="{ item }">
          <v-icon v-if="item.roles.includes('ROLE_ADMIN')">fa-check</v-icon>
          <v-icon v-else>fa-times</v-icon>
        </template>

        <template v-slot:item.actions>
          <a href=""><v-icon class="mr-2 mt-1" color="warning">fa-pencil-square-o</v-icon></a>
          <a href=""><v-icon color="error">fa-trash-o</v-icon></a>
        </template>

      </v-data-table>

      <UserForm :user="userClicked" />

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
    // modalUserDetails: false,
    // table data :
    headers: [
      {text: 'Nom', value: 'lastname'},
      {text: 'Prénom', value: 'firstname'},
      {text: 'Mail', value: 'email', sortable: false},
      {text: 'Téléphone', value: 'phone', sortable: false},
      {text: 'Admin', value: 'roles', sortable: false},
      {text: 'Actions', value: 'actions', sortable: false},
    ],
    users: [],
    userClicked: {}
  }),
  computed: {
    ...mapState(['api_url']),
  },
  methods: {
    userDetails(event) {

      this.$axios
        .get(`${this.api_url}/user/${event.id}`)
        .then(response => { 
          this.userClicked = response.data
          this.$root.$refs.userForm.openDialog()
        })
    },
  },
  mounted() {
    this.$axios
      .get(`${this.api_url}/user/`)
      .then(response => { this.users = response.data })
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