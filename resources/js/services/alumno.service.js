import config from '../helpers/config'
import axios from 'axios'
import { unauthorizedHandler, getDataHandler } from './handlers';

export const alumnoService = {
	getGrupos() {
		return axios.get('/api/alumno/grupo', config.jsonRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
	}
};