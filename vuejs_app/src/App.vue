<template>
  <v-app>

    <v-navigation-drawer mini-variant.sync="true" app permanent>
			<v-list>
				<router-link v-for="nav_item in nav_items" :key="nav_item.label" :to="nav_item.path">
					<v-list-item link>
						<v-list-item-content>
								<v-list-item-title>{{ nav_item.label }}</v-list-item-title>
							</v-list-item-content>
					</v-list-item>
				</router-link>

				<v-list-item v-if="$store.getters.isLoggedIn" @click="logout" link> 
					<v-list-item-content>
							<v-list-item-title>Deconnexion</v-list-item-title>
						</v-list-item-content>
				</v-list-item>
      </v-list>
    </v-navigation-drawer>
		
    <v-main>
      <router-view />
    </v-main>

  </v-app>
</template>

<script>

export default {
	name: 'App',
	data: () => ({
		nav_items: [
			{path: '/', label:'Home'},
			{path: '/test', label:'Test'},
			{path: '/connexion', label:'Connexion'},
		],
	}),
	methods: {
		logout() {
			this.$store.dispatch('logout')
			.then(() => {
				this.$router.push('/connexion')
			})
		}
	},
	created: function () {
    this.$http.interceptors.response.use(undefined, function (err) {
      return new Promise(function () {
        if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
          this.$store.dispatch('logout')
        }
        throw err;
      });
    });
  },
}

</script>
