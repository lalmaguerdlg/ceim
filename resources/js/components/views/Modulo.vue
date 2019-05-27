<template>
	<div>
		<h1>{{grupo_id}}</h1>
		<h1>{{id}}</h1>
	</div>
</template>

<script>
export default {
	data() {
		return {

		}
	},
	computed: {
		grupo_id() {
			return this.$route.params.id
		},
		id() {
			return this.$route.params.id_modulo
		}
	}
}
</script>

<style>

</style>
