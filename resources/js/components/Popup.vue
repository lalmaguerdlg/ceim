<template>
	<v-dialog max-width="600px" v-model="dialog">
		<v-btn flat slot="activator" class="success">Add new project</v-btn>
		<v-card>
			<v-card-title>
				<h2>Add a New Project</h2>
			</v-card-title>
			<v-card-text>
				<v-form class="px-3" ref="form">
					<v-text-field label="Title" v-model="project.title"
					 prepend-icon="folder"
					 :rules="titleRules">
					</v-text-field>
					<v-textarea label="Information" v-model="project.content"
					 prepend-icon="edit"
					 :rules="titleRules">
					</v-textarea>
					<v-menu>
						<v-text-field slot="activator" label="Due date" 
						 prepend-icon="date_range" :value="project.due"></v-text-field>
						<v-date-picker v-model="project.due"></v-date-picker>
					</v-menu>
					<v-spacer></v-spacer>
					<v-btn flat class="success mx-0 mt-3" @click="submit">Add project</v-btn>
				</v-form>
			</v-card-text>
		</v-card>
	</v-dialog>
</template>

<script>
export default {
	data() {
		return {
			project: {
				title: '',
				content: '',
				due: null,
			},
			titleRules: [
				v => v.length >= 3 || 'Minimum length is 3 characters',
			],
			dialog: false,
		}
	},
	methods: {
		submit() {
			if(this.$refs.form.validate()) {
				this.$emit('projectAdded', this.project);
				this.dialog = false;
			}
		}
	}
}
</script>

<style>

</style>
