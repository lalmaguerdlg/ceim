import { userService } from '../services/'

const tokensLocal = JSON.parse(localStorage.getItem('user'));

const state = {
	loading: false,
	account: null,
	session: null,
	loggedIn: false,
	errors: null,
	fetchingUser: false,
}

if(tokensLocal) {
	state.session = tokensLocal;
	state.account = null;
	state.loggedIn = true;
}

const getters = {
	user_loading: (state) => state.loading,
	login_errors: (state) => state.errors,
	logged_in: (state) => state.loggedIn,
	account: (state) => state.account,
}

const actions = {
	async login({dispatch, commit}, {email, password}) {
		commit('LOGIN_REQUEST');
		try{
			let tokens = await userService.login(email, password);
			await dispatch('fetchUser');
			commit('LOGIN_REQUEST_SUCCESS', tokens);
		} catch(err) {
			commit('LOGIN_REQUEST_ERROR', err);
			return Promise.reject(err);
		}
	},
	async fetchUser({commit}) {
		commit('FETCH_USER');
		try{
			let user = await userService.getUser();
			commit('FETCH_USER_SUCCESS', user.data);
		} catch(err) {
			commit('FETCH_USER_ERROR', err);
		}
	}
}

const mutations = {
	LOGIN_REQUEST(state) {
		state = {
			loading: true,
			account: null,
			session: null,
			loggedIn: false,
			errors: null
		}
	},
	LOGIN_REQUEST_SUCCESS(state, tokens) {
		state.session = tokens;
		state.loggedIn = true;
		state.loading = false;
		state.errors = null;
	},
	LOGIN_REQUEST_ERROR(state, errors) {
		state.loading = false;
		state.errors = errors;
	},
	FETCH_USER(state) {
		state.loading = true;
	},
	FETCH_USER_SUCCESS(state, account) {
		state.loading = false;
		state.account = account;
	},
	FETCH_USER_ERROR(state, errors) {
		state.loading = false;
		state.errors = errors;
	}
}

export const user = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}