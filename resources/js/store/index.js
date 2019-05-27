import Vue from 'vue';
import Vuex from 'vuex';

import { alumno } from './alumno.module'
import { grupo } from './grupo.module'

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		alumno,
		grupo
	}
});