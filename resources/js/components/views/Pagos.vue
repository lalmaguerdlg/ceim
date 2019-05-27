<template>
	
	<div>

		<perfil :perfilBlade="perfil"></perfil>


	</div>

</template>

<script>
import Perfil from './Perfil.vue'

export default {
	components: {
		Perfil
	},
	data() {
		return { 
			perfil: {
				nombre: 'Luis',
				edad: 23
			}
		}
	}
}
</script>

<style>

</style>
