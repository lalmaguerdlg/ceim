import Vue from 'vue'
import VueRouter from 'vue-router'

import LoginView from './components/Login.vue'
import RegisterView from './components/Register.vue'
import DashView from './components/Dash.vue'
//import NotFoundView from './components/NotFound.vue'

import GruposView from './components/views/Grupos.vue'
import GrupoView from './components/views/Grupo.vue'
import ModuloView from './components/views/Modulo.vue'
import PerfilView from './components/views/Perfil.vue'

/*
import Login from './views/Login.vue'
import Projects from './views/Projects.vue'
import Team from './views/Team.vue'

import Cursos from './views/Cursos.vue'
*/
Vue.use(VueRouter);

const routes = [
	{ path: '/login', name: 'login', component: LoginView },
	{ path: '/register', name: 'register', component: RegisterView },
	{ 
		path: '/', 
		component: DashView,
		children: [
			{
				path: 'grupos',
				alias: '',
				component: GruposView,
			},
			{
				path: 'grupo/:id',
				component: GrupoView,
			},
			{
				path: 'grupo/:id/modulo/:id_modulo',
				component: ModuloView,
			},
			{
				path: 'usuario',
				component: PerfilView,
			},
			{
				path: 'usuario/:id',
				component: PerfilView,
			},
		]
	},
];

/*
const routes = [
	{ path: '/', name: 'cursos', component: Cursos },
	{ path: '/login', name: 'cursos', component: Login },
	{ path: '/register', name: 'cursos', component: Cursos },
	{ path: '/pagos', name: 'pagos', component: Projects },
	{ path: '/ayuda', name: 'ayuda', component: Team },
	{ path: '/usuario', name: 'ayuda', component: Team },
	{ path: '*', redirect: '/'}
]
*/

const router =  new VueRouter({
	//mode: 'history',
	routes
});

router.beforeEach((to, from, next) => {
	const publicPages = ['/login', '/register'];
	//const onlyPublic = ['/login', '/register'];
	
	//const publicRequired = onlyPublic.includes(to.path);
	const authRequired = !publicPages.includes(to.path);
	
	const loggedIn = localStorage.getItem('user');

	/*if(publicRequired && loggedIn) {
		return next('/');
	}*/

	if( authRequired && !loggedIn ) {
		return next('/login');
	}
	else if(!authRequired && loggedIn) {
		return next('/');
	}

	next();
});


export default router;