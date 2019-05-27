<template>
	<div>
		<h1>{{perfil.nombre}}</h1>
		<p>{{perfil.edad}}</p>

		<h1>{{perfilBlade.nombre}}</h1>
		<p>{{perfilBlade.edad}}</p>
	</div>
</template>

<script>
export default {
	props: ['perfilBlade'],
	data() {
		return {
			perfil: {
				nombre: '',
				edad: 0
			}
		}
	}
}
</script>

<style>

</style>
