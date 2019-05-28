import { alumnoService } from '../services'
import { grupoService } from '../services'

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
	async createGrupo({commit}, grupo) {
		try {
			let nuevo_grupo = await grupoService.createGrupo(grupo);
			commit('CREATE_GRUPO_SUCCESS', nuevo_grupo.data);
		}
		catch(error){
			return Promise.reject(error);
		}
	},
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
	CREATE_GRUPO_SUCCESS(state, grupo) {
		console.log(grupo);
		state.grupos.all.push(grupo);
	},
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