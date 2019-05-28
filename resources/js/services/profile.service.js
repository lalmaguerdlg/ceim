import config from '../helpers/config'
import axios from 'axios'

import { unprocessableEntityHandler, unauthorizedHandler, getDataHandler } from './handlers';


export const profileService = {
	getProfile(id) {
		return axios.get(`/api/usuario/${id}`, config.jsonRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
	},
	updateProfile(profile_data) {
		if(profile_data.get('_method') !== 'PUT') {
			profile_data.append('_method', 'PUT')
		}
		return axios.post('/api/cuenta', profile_data, config.fileRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
			.catch(unprocessableEntityHandler);
	}
};