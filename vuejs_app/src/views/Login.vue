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

			<v-btn @click="manageLogin">Se connecter</v-btn>
    </v-form>

  </v-container>
</template>

<script>

import { mapActions, mapState } from 'vuex'

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
		...mapActions(['login']),
		isValid () {
			return this.$refs.form.validate()
		},
		manageLogin () {
			if(this.isValid()) {
				this.login(this.credentials)
				.then(() => this.$router.push('/'))
			}
		},
  },
}
</script>
