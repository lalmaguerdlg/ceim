import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './views/Dashboard.vue'
import Projects from './views/Projects.vue'
import Team from './views/Team.vue'

import Cursos from './views/Cursos.vue'

Vue.use(VueRouter);

const routes = [
	{ path: '/', name: 'cursos', component: Cursos },
	{ path: '/pagos', name: 'pagos', component: Projects },
	{ path: '/ayuda', name: 'ayuda', component: Team },
	{ path: '/usuario', name: 'ayuda', component: Team },
]

export default new VueRouter({
	routes
})
