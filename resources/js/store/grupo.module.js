import { grupoService } from '../services'

const state = {
	loading: false,
	grupo: null,
	comentarios: {
		loading: false,
		uploading: false,
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
	comentario_uploading(state) {
		return state.comentarios.uploading;
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
		commit('POST_COMENTARIO')
		try {
			let comentario = await grupoService.postComentario(grupo_id, comentario_data);
			commit('POST_COMENTARIO_SUCCESS', comentario.data);
		}
		catch(error) {
			commit('POST_COMENTARIO_ERROR', error);
			return Promise.reject(error);
		}
	},
	async updateComentario({commit}, {grupo_id, id, comentario_data}) {
		commit('UPDATE_COMENTARIO')
		try {
			let comentario = await grupoService.updateComentario(grupo_id, id, comentario_data);
			commit('UPDATE_COMENTARIO_SUCCESS', comentario.data);
		}
		catch(error) {
			commit('UPDATE_COMENTARIO_ERROR', error);
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
	POST_COMENTARIO(state) {
		state.comentarios.uploading = true;
	},
	POST_COMENTARIO_SUCCESS(state, comentario) {
		state.comentarios.uploading = false;
		state.comentarios.all.unshift(comentario);
		state.error = null;
	},
	POST_COMENTARIO_ERROR(state, error) {
		state.comentarios.uploading = false;
		state.error = error;
	},
	UPDATE_COMENTARIO(state) {
		state.comentarios.uploading = true;
	},
	UPDATE_COMENTARIO_SUCCESS(state, comentario) {
		let foundIndex = state.comentarios.all.findIndex(c => c.id == comentario.id);
		state.comentarios.all[foundIndex] = comentario;
		state.error = null;
		state.comentarios.uploading = false;
	},
	UPDATE_COMENTARIO_ERROR(state, error) {
		state.comentarios.uploading = false;
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