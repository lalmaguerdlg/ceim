import { alumnoService } from '../services'

const state = {
	grupos: {
		loading: false,
		all: [],
		error: null,
	},
}

const getters = {
	grupos(state) {
		return state.grupos.all;
	},
	grupos_loading(state) {
		return state.grupos.loading;
	}
}

const actions = {
	async fetchGrupos({commit}) {
		commit('FETCH_ALL_GRUPOS');
		try {
			let grupos = await alumnoService.getGrupos();
			commit('FETCH_ALL_GRUPOS_SUCCESS', grupos.data)
		}
		catch(error) {
			error => commit('FETCH_ALL_GRUPOS_ERROR', error) 
		}
	},
}

const mutations = {
	FETCH_ALL_GRUPOS(state) { 
		state.grupos.loading = true;
	},
	FETCH_ALL_GRUPOS_SUCCESS(state, grupos) { 
		state.grupos.loading = false;
		state.grupos.all = grupos;
		state.grupos.error = null;
	},
	FETCH_ALL_GRUPOS_ERROR(state, error) { 
		state.grupos.loading = false;
		state.grupos.all = [];
		state.grupos.error = error;
	},
}

export const alumno = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}