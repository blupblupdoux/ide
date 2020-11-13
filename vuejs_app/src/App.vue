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
