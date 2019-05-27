import { apiContentHeaders, authHeader, fileUploadHeaders } from '../helpers/request-headers';

const API_URL = 'http://localhost:8000'

export default { 
	API_URL,
	jsonRequestConfig(){
		return {
			baseUrl: API_URL,
			headers: { ...apiContentHeaders(), ...authHeader() }
		};
	},
	fileRequestConfig() {
		return {
			baseUrl: API_URL,
			headers: { ...fileUploadHeaders(), ...authHeader() }
		};
	}
}