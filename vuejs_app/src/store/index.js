import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    api_url: 'http://localhost:8000/api',
    auth : {
      token: localStorage.getItem('user-token'),
      user: {}
    }
    
  },
  getters : {
    isLoggedIn(state) {
      return !!state.auth.token
    }
  },
  mutations: {
    CONNECTED(state, {token, user}) {
      state.auth.token = token
      state.auth.user = user
    },
    DISCONNECTED(state) {
      state.auth.token = ''
      state.auth.user = {}
    }
  },
  actions: {
    decryptToken(context, token) {
			
      let base64Url = token.split('.')[1]; // get the payload part of the token
      let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
              return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));
      
      return JSON.parse(jsonPayload);
    },
    login(context, credentials) {
      return new Promise((resolve, reject) => {
        axios
          .post(
              `${context.state.api_url}/login_check`, 
              {"username":credentials.email,"password":credentials.password}
          )
          .then(response => {
            let token = response.data.token
            
            // store token in local storage and state
            localStorage.setItem('user-token', token)
            axios.defaults.headers.common['Authorization'] = token

            // store user in state
            context.dispatch('decryptToken', token)
              .then(response => {
                console.log(response.user)
                context.commit('CONNECTED', {token: token, user: response.user})
              })

            resolve(response)
          })
          .catch(error => {
            localStorage.removeItem('user-token')
            reject(error)
          })
      })
    },
    logout(context) {
      return new Promise((resolve) => {
        context.commit('DISCONNECTED')
        localStorage.removeItem('user-token')
        delete axios.defaults.headers.common['Authorization']
        resolve()
      })
    },
  },
  modules: {
  }
})
