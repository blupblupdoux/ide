<template>
  <v-container>

    <h1>Connexion</h1>

    <v-form ref="form">
			<v-text-field 
				type="email"
				label="Email" 
				placeholder="prenom.nom@gmail.com"
				v-model="credentials.email" 
				:rules="[rules.required, rules.email]" 
				required 
				outlined>
			</v-text-field>

			<v-text-field 
				type="password"
				label="Mot de passe" 
				placeholder="exemple33!"
				v-model="credentials.password"  
				:rules="[rules.required]" 
				required 
				outlined>
			</v-text-field>

			<v-btn @click="checkCredentials">Se connecter</v-btn>
    </v-form>

  </v-container>
</template>

<script>

import { mapState } from 'vuex'
import axios from 'axios'

export default {

	name: 'Login',
	data: () => ({
		credentials: {
			email: '',
			password: ''
		},
		rules: {
			required: value => !!value || 'Requis',
			email: value => {
				const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
				return regex.test(value) || 'Le mail n\'est pas valide'
			},
		},
	}),
	computed: {
		...mapState(['api_url']),
	},
	methods: {
      isValid () {
        return this.$refs.form.validate()
			},
			checkCredentials () {
				if(this.isValid()) {
					// console.log(this.api_url);

					axios.get('http://localhost:8000/test').then(response => (console.log(response)))
				}
			},
  },
}
</script>
