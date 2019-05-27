import { userService } from '../services/'
import { router } from '../router'

const user = JSON.parse(localStorage.getItem('user'));

const state = {
	user: null,
	loggedIn: false,
	loginProsses: {
		errors: {
			email: [],
			password: []
		}
	}
}


const state = user 
	? { status: { loggedIn: true }, user }
	: { status: { loggedIn: false }, user: null };


const actions = {
	login({dispatch, commit}, {username, password}) {
		commit('LOGIN_REQUEST', { username });

		userService.login(username, password)
	}
}


/* Este archivo no esta terminado ...... 
	hace falta concretar el inicio de sesion utilizando VUEX
*/