<template>
  <v-app>

    <Navbar v-if="$route.name != 'Login' && $route.name != 'Home'" />
		
    <v-main>
      <router-view />
    </v-main>

  </v-app>
</template>

<script>

import Navbar from './components/navbar'

export default {
	name: 'App',
	components: {
		Navbar
	},
	created: function () {

    let that = this

    this.$axios.interceptors.response.use(undefined, function (error) {
      return new Promise(function () {
        if (error.response.status === 401) {
        
          that.$store.dispatch('logout')
          .then(() => {
            that.$router.push('/connexion')
          })
        }
        throw error;
      });
    });
  },
}

</script>
