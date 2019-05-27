import config from '../helpers/config'
import axios from 'axios'
import { contentHeaders, authHeader } from '../helpers/request-headers';
import { unprocessableEntityHandler, unauthorizedHandler } from './handlers';


export const userService = {
	login(email, password) {

		const request_config = {
			baseURL: config.apiUrl,
			headers: { ...contentHeaders() }
		};
	
		const request_data = {
			email,
			password
		}
	
		return axios.post('/api/login', request_data , request_config)
			.then(res => {
				if(res.data.access_token) {
					localStorage.setItem('user', JSON.stringify(res.data));
				}
				return res.data;
			})
			.catch(unprocessableEntityHandler);
	},
	logout() {
		const request_config = {
			baseURL: config.apiUrl,
			headers: { ...contentHeaders(), ...authHeader() }
		};
		return axios.post('/api/logout', {}, request_config)
			.then(res => {
				if(localStorage.getItem('user')) {
					localStorage.removeItem('user');
				}
				location.reload();
			})
			.catch(unauthorizedHandler);
	}
};