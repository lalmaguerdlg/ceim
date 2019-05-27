<template>
	<div>
		<v-app class="grey lighten-4">
			<navbar/>
			<v-content class="mx-4 mb-4">
				<v-container fluid>
					<router-view></router-view>
				</v-container>
			</v-content>
		</v-app>
	</div>
</template>

<script>
import Navbar from './layout/Navbar.vue'

export default {
	name: 'dash',
	components: {
		Navbar
	}
}

</script>

<style>

</style>
