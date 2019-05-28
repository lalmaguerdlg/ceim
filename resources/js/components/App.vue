<template>
	<div>
		<router-view :key="$route.fullPath"></router-view>
		<!-- <v-app class="grey lighten-4">
			<navbar/>
			<v-content class="mx-4 mb-4">
				<v-container fluid>
					<router-view></router-view>
				</v-container>
			</v-content>
		</v-app> -->
	</div>
</template>

<script>

import Navbar from './layout/Navbar.vue'

export default {
	name: 'app',
	components: {
		Navbar
	}
}

</script>

<style>

a.route-link {
	text-decoration: none !important;
	color: inherit !important;
}

</style>
