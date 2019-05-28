import Vue from 'vue';
import Vuex from 'vuex';

import { user } from './user.module'
import { profile } from './profile.module'
import { alumno } from './alumno.module'
import { grupo } from './grupo.module'

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		user,
		profile,
		alumno,
		grupo
	}
});