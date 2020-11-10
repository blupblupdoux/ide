<template>
	<div>

		<v-btn color="primary" class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-btn>

		<v-navigation-drawer v-model="drawer" :permanent="$vuetify.breakpoint.mdAndUp" app left>

			<v-list-item class="px-2">
        <v-list-item-avatar>
          <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
        </v-list-item-avatar>

        <v-list-item-title>Robert</v-list-item-title>
				<i class="fa fa-chevron-down" aria-hidden="true"></i>
      </v-list-item>

			<v-divider></v-divider>

			<v-list v-if="$store.getters.isLoggedIn">
				<router-link v-for="nav_item in nav_items.user" :key="nav_item.label" :to="nav_item.path">
					<v-list-item link>
						<v-list-item-content>
								<v-list-item-title>{{ nav_item.label }}</v-list-item-title>
							</v-list-item-content>
					</v-list-item>
				</router-link>

				<v-list-item @click="logout" link> 
					<v-list-item-content>
							<v-list-item-title>Deconnexion</v-list-item-title>
						</v-list-item-content>
				</v-list-item>
			</v-list>

			<!-- <v-list v-if="$store.state.auth.user.roles.includes('ROLE_ADMIN')">
				<router-link v-for="nav_item in nav_items.admin" :key="nav_item.label" :to="nav_item.path">
					<v-list-item link>
						<v-list-item-content>
								<v-list-item-title>{{ nav_item.label }}</v-list-item-title>
							</v-list-item-content>
					</v-list-item>
				</router-link>
			</v-list> -->

	</v-navigation-drawer>
		
	</div>
</template>

<script>
export default {
	name: 'Navbar',
	data: () => ({
			drawer: false,
			group: null,
			nav_items: {
				user: [
					{path: '/dashboard', label:'Dashboard'},
				],
				admin: [
					{path: '/test', label:'Test'},
				]
			},
    }),
	methods: {
		logout() {
			this.$store.dispatch('logout')
			.then(() => {
				this.$router.push('/connexion')
			})
		}
	},
	watch: {
		group () {
			this.drawer = false
		},
	},
}
</script>

<style>

</style>