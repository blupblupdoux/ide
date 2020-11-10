<template>
  <v-container>

		<ErrorAlert v-if="errorLogin"  message="Email ou mot de passe incorrect" />

		<v-row class="justify-center mt-10 mb-12">
			<h1 class="login-title primary--text">Connexion</h1>
		</v-row>
    
		<v-row class="justify-center">
			<v-col cols="6">
				<v-form @submit.prevent="manageLogin" ref="form" >
					<v-text-field 
						type="email"
						label="Email" 
						placeholder="prenom.nom@gmail.com"
						v-model="credentials.email" 
						:rules="[rules.required, rules.email]"
						color="primary"
						required 
						outlined>
					</v-text-field>

					<v-text-field 
						type="password"
						label="Mot de passe" 
						placeholder="exemple33!"
						v-model="credentials.password"  
						:rules="[rules.required]" 
						color="primary"
						required
						outlined>
					</v-text-field>

					<v-btn type="submit" color="primary" class="d-block mx-auto" >Se connecter</v-btn>
				</v-form>
			</v-col>
		</v-row>

		

  </v-container>
</template>

<script>

import { mapActions, mapState } from 'vuex'
import ErrorAlert from '../components/errorAlert'

export default {

	name: 'Login',
	components: {
		ErrorAlert
	},
	data: () => ({
		errorLogin: false,
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
				.then(() => {
					this.$router.push('/dashboard')
				})
				.catch(() => {
						this.errorLogin = true
        })
			}
		},
  },
}
</script>
