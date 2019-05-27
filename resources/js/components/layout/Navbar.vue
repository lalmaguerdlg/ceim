<template>
	<nav>
		<v-toolbar flat app>
			<v-toolbar-side-icon class="grey--test" @click="open = !open"></v-toolbar-side-icon>
			<!-- Logo -->
			<v-toolbar-title class="text-uppercase grey--text">
				<router-link class="font-weight-medium route-link" to="/"> CEIM</router-link>
			</v-toolbar-title>
			<v-spacer></v-spacer>
			
			<!-- dropdown menu -->
			<v-menu offset-y>
				<v-btn flat slot="activator" color="grey"> 
					<v-icon left>expand_more</v-icon>
					<span>Menu</span> 
				</v-btn>
				<v-list>
					<v-list-tile v-for="(link,i) of [...links, ...bottomLinks]" :key="i" router :to="link.route" class="route-link">
						<v-list-tile-title>{{link.text}}</v-list-tile-title>
					</v-list-tile>
				</v-list>
			</v-menu>

			<v-btn icon flat color="grey">
				<v-icon>notifications_none</v-icon>
			</v-btn>

			<!-- Logout -->
			<v-btn flat color="grey" @click="logout">
				<span>Cerrar sesion</span>
				<v-icon right>exit_to_app</v-icon>
			</v-btn>
		</v-toolbar>
		<v-navigation-drawer v-model="open" class="secondary vertical-navigation" app>
			<!-- App name -->
			<v-toolbar flat dark>
				<v-list class="pt-2 pb-0" dark >
					<v-list-tile>
						<v-list-tile-title class="title text-xs-center font-weight-medium text-uppercase">
							Alumnos
						</v-list-tile-title>
					</v-list-tile>
				</v-list>
			</v-toolbar>
			
				<v-list class="py-0">
					<v-list-tile avatar router to="/usuario" class="route-link">
						<v-list-tile-avatar>
							<img src="https://randomuser.me/api/portraits/men/85.jpg">
						</v-list-tile-avatar>
						<v-list-tile-content class="white--text">
							<v-list-tile-title>John Leider</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</v-list>
			
			<v-divider class="ma-0"></v-divider>

			<!-- router links -->
			<v-list class="pt-0">
				<v-list-tile v-for="(link, index) of links" :key="index" router :to="link.route" class="route-link">
					<v-list-tile-action>
						<v-icon class="white--text">{{link.icon}}</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title class="white--text">
							{{link.text}}
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</v-list>
			<v-spacer></v-spacer>
			<v-list class="pt-0">
				<v-list-tile v-for="(link, index) of bottomLinks" :key="index" router :to="link.route" class="route-link">
					<v-list-tile-action>
						<v-icon class="white--text">{{link.icon}}</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title class="white--text">
							{{link.text}}
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</v-list>

		</v-navigation-drawer>
	</nav>
</template>

<script>

import { userService } from '../../services'

export default {
	data() {
		return {
			open: null,
			mini: true,
			links: [
				{ icon: 'library_books', text: 'Cursos', route: '/'},
				// { icon: 'payment', text: 'Pagos', route: '/pagos'},
				{ icon: 'email', text: 'Mensajes', route: '/mensajes'},
			],
			bottomLinks: [
				// { icon: 'help', text: 'Ayuda', route: '/ayuda'},
			],
			snackbar: false,
		}
	},

	methods: {
		async logout() {
			let response = await userService.logout();
		}
	}
}
</script>

<style lang="scss" scoped>

::v-deep.route-link {
	&>.v-list__tile--link {
		text-decoration: none;
	}
}

.vertical-navigation {
	display:flex;
	flex-direction:column;
}

</style>
