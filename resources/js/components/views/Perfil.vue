<template>
	<div>
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
		id() {
			return this.$route.params.id ? this.$route.params.id : 0;
		}
	}
}
</script>

<style>

</style>
