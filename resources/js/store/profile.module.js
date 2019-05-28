import { profileService } from '../services/'

const state = {
	loading: false,
	profile: null,
	errors: null,
	updating: false
}

const getters = {
	profile_loading: (state) => state.loading,
	profile_updating: (state) => state.updating,
	profile_errors: (state) => state.errors,
	profile: (state) => state.profile,
}

const actions = {
	async fetchProfile({commit}, id) {
		commit('FETCH_PROFILE');
		try{
			let user = await profileService.getProfile(id);
			commit('FETCH_PROFILE_SUCCESS', user.data);
		} catch(err) {
			commit('FETCH_PROFILE_ERROR', err);
			return Promise.reject(err);
		}
	},
	async updateProfile({commit}, profile_data) {
		commit('UPDATE_PROFILE');
		try{
			let profile = await profileService.updateProfile(profile_data);
			commit('UPDATE_PROFILE_SUCCESS', profile.data);
		} catch(err) {
			commit('UPDATE_PROFILE_ERROR', err);
			return Promise.reject(err);
		}
	}
}

const mutations = {
	FETCH_PROFILE(state) {
		state.loading = true;
	},
	FETCH_PROFILE_SUCCESS(state, profile) {
		state.profile = profile;
		state.loading = false;
	},
	FETCH_PROFILE_ERROR(state, errors) {
		state.errors = errors;
		state.loading = false;
	},
	UPDATE_PROFILE(state) {
		state.updating = true;
	},
	UPDATE_PROFILE_SUCCESS(state, profile) {
		state.profile = profile;
		state.updating = false;
	},
	UPDATE_PROFILE_ERROR(state, errors) {
		state.errors = errors;
		state.updating = false;
	},
}

export const profile = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}