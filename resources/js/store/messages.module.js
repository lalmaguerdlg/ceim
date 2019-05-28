
const tokensLocal = JSON.parse(localStorage.getItem('user'));

const state = {
	messages: [],
}

const getters = {
	
}

const actions = {
	sendMessage ({ commit, rootState }, { text, created, sender }) {
		let message = {
			text, created, sender
		}
		rootState.db.collection('messages').add(message)
		.catch(err => {
			console.log(err);
		});
		//commit('ADD_MESSAGE', message);
	}
}

const mutations = {
	ADD_MESSAGE(state, message) {
		state.messages.push(message);
	}
}

export const messages = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}