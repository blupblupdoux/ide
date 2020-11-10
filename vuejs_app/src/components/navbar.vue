<template>
	<div>

		<v-btn color="primary" class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-btn>

		<v-navigation-drawer app left class="blue lighten-5 px-3 py-3" v-model="drawer" :permanent="$vuetify.breakpoint.mdAndUp">

			<div>
				<h3>Sandrine</h3>
				<p>admin</p>
			</div>

			<v-divider></v-divider>

			<v-list dense nav>
				<v-list-item link>
					<v-list-item-content>
						<v-list-item-title>coucou</v-list-item-title>
					</v-list-item-content>
				</v-list-item>

				<v-list-item link>
					<v-list-item-content>
						<v-list-item-title>salut</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
			</v-list>
	</v-navigation-drawer>
		
	</div>
</template>

<script>
export default {
	name: 'Navbar',
	data: () => ({
			drawer: false,
			group: null
    }),

    watch: {
      group () {
        this.drawer = false
      },
    },
}
</script>

<style>

</style>