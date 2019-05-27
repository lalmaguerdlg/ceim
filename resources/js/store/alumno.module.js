import { alumnoService } from '../services'

const state = {
	grupos: {
		loading: false,
		all: [],
		error: null,
		individual: null,
	},
}

const getters = {
	grupos(state) {
		return state.grupos.all;
	},
	grupoDetalle(state) {
		return state.grupos.individual;
	},
	isLoading(state) {
		return state.grupos.loading;
	}
}

const actions = {
	fetchGrupos({commit}) {
		commit('FETCH_ALL_GRUPOS');
		alumnoService.getGrupos()
			.then(
				grupos => commit('FETCH_ALL_GRUPOS_SUCCESS', grupos.data),
				error => commit('FETCH_ALL_GRUPOS_ERROR', error) 
			)
	},
	fetchGrupoDetails({commit}, id) {
		commit('FETCH_GRUPO_DETAILS');
		alumnoService.getGrupoById(id)
			.then(
				grupo => commit('FETCH_GRUPO_DETAILS_SUCCESS', grupo.data),
				error => commit('FETCH_GRUPO_DETAILS_ERROR', error)
			)
	}
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
	FETCH_GRUPO_DETAILS(state) { 
		state.grupos.loading = true;
	},
	FETCH_GRUPO_DETAILS_SUCCESS(state, grupo) { 
		state.grupos.loading = false;
		state.grupos.individual = grupo;
		state.grupos.error = null;
	},
	FETCH_GRUPO_DETAILS_ERROR(state, error) { 
		state.grupos.loading = false;
		state.grupos.individual = null;
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