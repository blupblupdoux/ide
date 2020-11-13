<template>
	<v-container v-if="isLoggedIn">

		<v-btn color="primary" class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-btn>

		<v-navigation-drawer class="nav-drawer" v-model="drawer" :permanent="$vuetify.breakpoint.mdAndUp" :expand-on-hover="$vuetify.breakpoint.mdAndUp" width="auto" app left> 

			<div>
				<div class="nav-user pa-2 d-flex align-center" @click.stop="user_dropdown = !user_dropdown">
					<v-avatar size="36px" class="avatar">
						<v-icon color="primary">fa-user-md</v-icon>
					</v-avatar>
					<p class="mb-0 ml-3">{{ auth.user.firstname }}</p>
					<a class="pl-3 ml-auto">
						<i class="fa fa-chevron-down mr-1" aria-hidden="true"></i>
					</a>
				</div>

				<v-list v-if="user_dropdown">
					<NavbarItem @click.native="logout" name="Déconnexion" icon="fa-sign-out" />
				</v-list>
			</div>

			<v-divider></v-divider>

			<v-list class="pa-0">
				<router-link v-for="nav_item in nav_items.user" :key="nav_item.label" :to="nav_item.path">
					<NavbarItem :name="nav_item.label" :icon="nav_item.icon" />
				</router-link>
			</v-list>

			<v-list class="pa-0" v-if="auth.user.roles.includes('ROLE_ADMIN')">
				<router-link v-for="nav_item in nav_items.admin" :key="nav_item.label" :to="nav_item.path">
					<NavbarItem :name="nav_item.label" />
				</router-link>
			</v-list>

		</v-navigation-drawer>

	</v-container>
</template>

<script>
import { mapGetters, mapState } from 'vuex'

import NavbarItem from './navbarItem'

export default {
	name: 'Navbar',
	components: {
		NavbarItem
	},
	data: () => ({
		drawer: false,
		user_dropdown: false,
		group: null,
		nav_items: {
			user: [
				{path: '/dashboard', label:'Dashboard', icon:'fa-home'},
			],
			admin: [
				{path: '/test', label:'Test'},
			]
		},
	}),
	computed: {
		...mapState(['auth']),
		...mapGetters(['isLoggedIn'])
	},
	methods: {
		logout() {
			this.$store.dispatch('logout')
			.then(() => {
			this.$router.push('/connexion')
			})
		},
	},
	watch: {
		group () {
		this.drawer = false
		},
	},
}
</script>

<style lang="scss">

.container {

	.nav-drawer {

		.nav-user {
			cursor: pointer;
		}

		a {
			text-decoration: none;
		}

		.avatar {
			border: 1px solid #0000001f;
		}
	}
}


</style>