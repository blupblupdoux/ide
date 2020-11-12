import 'font-awesome/css/font-awesome.min.css'
import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
	theme: {
		themes: {
			light: {
				primary: '#7986CB',
				secondary: '#9FA8DA',
				// accent: '#82B1FF',
				error: '#F4511E',
				// info: '#2196F3',
				success: '#43A047',
				warning: '#FBC02D',
			},
		},
	},
	icons: {
    iconfont: 'fa4',
  },
});
