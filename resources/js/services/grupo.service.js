import config from '../helpers/config'
import axios from 'axios'
import { unauthorizedHandler, getDataHandler, unprocessableEntityHandler } from './handlers';


export const grupoService = {
	createGrupo(grupo) {
		return axios.post(`/api/curso/1/grupo/`, grupo, config.jsonRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
			.catch(unprocessableEntityHandler)
	},
	getGrupoById(id) {
		return axios.get(`/api/alumno/grupo/${id}`, config.jsonRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
			.catch(unprocessableEntityHandler)
	},
	getComentarios(grupo_id) {
		return axios.get(`/api/alumno/grupo/${grupo_id}/comentario`, config.jsonRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
			.catch(unprocessableEntityHandler)
	},
	postComentario(grupo_id, comentario_data) {
		return axios.post(`/api/alumno/grupo/${grupo_id}/comentario`, comentario_data, config.fileRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
			.catch(unprocessableEntityHandler)
	},
	updateComentario(grupo_id, id, data) {
		return axios.put(`/api/alumno/grupo/${grupo_id}/comentario/${id}`, data, config.jsonRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
			.catch(unprocessableEntityHandler)
	}
};