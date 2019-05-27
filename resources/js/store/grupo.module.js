import { grupoService } from '../services'

const state = {
	loading: false,
	grupo: null,
	comentarios: {
		loading: false,
		all: []
	},
	error: null
}

const getters = {
	grupo(state) {
		return state.grupo;
	},
	comentarios(state) {
		return state.comentarios.all;
	},
	grupo_loading(state) {
		return state.loading;
	},
	comentarios_loading(state) {
		return state.comentarios.loading;
	},
	error(state) {
		return state.error;
	}
}

const actions = {
	async fetchGrupo({commit, dispatch}, id) {
		commit('FETCH_GRUPO_DETAILS');
		try {
			let grupo = await grupoService.getGrupoById(id);
			commit('FETCH_GRUPO_DETAILS_SUCCESS', grupo.data)
		}
		catch(error) {
			commit('FETCH_GRUPO_DETAILS_ERROR', error)
		}
		dispatch('fetchComentarios', id);
	},
	async fetchComentarios({commit}, grupo_id) {
		commit('FETCH_GRUPO_COMMENTS');
		try {
			let comentarios = await grupoService.getComentarios(grupo_id);
			commit('FETCH_GRUPO_COMMENTS_SUCCESS', comentarios.data)
		}
		catch(error) {
			commit('FETCH_GRUPO_COMMENTS_ERROR', error)
		}
	},
	async postComentario({commit}, {grupo_id, comentario_data}) {
		try {
			let comentario = await grupoService.postComentario(grupo_id, comentario_data);
			commit('POST_COMENTARIO', comentario.data);
		}
		catch(error) {
			return Promise.reject(error);
		}
	}
}

const mutations = {
	FETCH_GRUPO_DETAILS(state) { 
		state.loading = true;
	},
	FETCH_GRUPO_DETAILS_SUCCESS(state, grupo) { 
		state.loading = false;
		state.grupo = grupo;
		state.error = null;
	},
	FETCH_GRUPO_DETAILS_ERROR(state, error) { 
		state.loading = false;
		state.grupo = null;
		state.error = error;
	},
	FETCH_GRUPO_COMMENTS(state) { 
		state.comentarios.loading = true;
	},
	FETCH_GRUPO_COMMENTS_SUCCESS(state, comentarios) { 
		state.comentarios.loading = false;
		state.comentarios.all = comentarios;
		state.error = null;
	},
	FETCH_GRUPO_COMMENTS_ERROR(state, error) { 
		state.comentarios.loading = false;
		state.comentarios.all = [];
		state.error = error;
	},
	POST_COMENTARIO(state, comentario) {
		state.comentarios.all.unshift(comentario);
	},
	POST_COMENTARIO_ERROR(state, error) {
		state.error = error;
	}
}

export const grupo = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}