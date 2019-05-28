import config from '../helpers/config'
import axios from 'axios'

import { unprocessableEntityHandler, unauthorizedHandler, getDataHandler } from './handlers';


export const userService = {
	register(email, password, name) {
		const request_data = {
			email,
			password,
			name
		}
		return axios.post('/api/register', request_data, config.jsonRequestConfig())
			.then(res => {
				if(res.data.access_token) {
					localStorage.setItem('user', JSON.stringify(res.data));
				}
				return res.data;
			})
			.catch(unprocessableEntityHandler);
	},
	login(email, password) {
		const request_data = {
			email,
			password
		}
		return axios.post('/api/login', request_data , config.jsonRequestConfig())
			.then(res => {
				if(res.data.access_token) {
					localStorage.setItem('user', JSON.stringify(res.data));
				}
				return res.data;
			})
			.catch(unprocessableEntityHandler);
	},
	logout() {
		return axios.post('/api/logout', {}, config.jsonRequestConfig())
			.then(res => {
				if(localStorage.getItem('user')) {
					localStorage.removeItem('user');
				}
				location.reload();
			})
			.catch(unauthorizedHandler);
	},
	getUser(id) {
		return axios.get('/api/cuenta', config.jsonRequestConfig())
			.then(getDataHandler)
			.catch(unauthorizedHandler)
	},
};