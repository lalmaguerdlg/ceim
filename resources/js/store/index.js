import Vue from 'vue';
import Vuex from 'vuex';

import { user } from './user.module'
import { profile } from './profile.module'
import { alumno } from './alumno.module'
import { grupo } from './grupo.module'
import { messages } from './messages.module'

Vue.use(Vuex);

import firebase_config from '../helpers/firestore.config'
import Firebase from 'firebase';
import 'firebase/firestore';
Firebase.initializeApp(firebase_config);

const state = {
	db: Firebase.firestore()
}

export default new Vuex.Store({
	state,
	modules: {
		user,
		profile,
		alumno,
		grupo,
		messages
	}
});