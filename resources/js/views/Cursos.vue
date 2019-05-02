<template>
	<div class="cursos">
		<h1 class="subheading grey--text">Mis cursos</h1>

		<v-container class="my-4"> 
			<v-card flat v-for="(project,index) of projects" :key="index" class="my-4" :class="`project ${project.status}`">
				<v-layout wrap>
					<v-flex xs12 sm12 md2>
						<v-img max-height="200" src="https://3c1703fe8d.site.internapcdn.net/newman/gfx/news/2018/europeslostf.jpg"></v-img>
					</v-flex>
					<v-flex xs12 sm12 md10>
						<v-layout row wrap class="mx-0" :class="`pa-3`">
							<v-flex xs12 md6>
								<div class="caption grey--text">Project Title</div>
								<div>{{project.title}}</div>
							</v-flex>
							<v-flex xs6 sm4 md2>
								<div class="caption grey--text">Person</div>
								<div>{{project.person}}</div>
							</v-flex>
							<v-flex xs6 sm4 md2>
								<div class="caption grey--text">Due by</div>
								<div>{{project.date}}</div>
							</v-flex>
							<v-flex xs12 sm4 md2>
								<div class="right">
									<v-chip small :class="`${project.status} white--text caption my-2`">
										{{project.status}}
									</v-chip>
								</div>
							</v-flex>
						</v-layout>
					</v-flex>
				</v-layout>
			</v-card>
		</v-container>
	</div>
</template>

<script>
export default {
	data() {
		return {
			projects: [
				{title: 'Create a new website', person: 'The net ninja', date: '1st Jan 2019', status: 'ongoing'},
				{title: 'A new website', person: 'Max', date: '1st Jan 2019', status: 'complete'},
				{title: 'Settup room', person: 'Robert Milkton', date: '1st Jan 2019', status: 'ongoing'},
				{title: 'Play some games', person: 'Andrew Mark', date: '1st Jan 2019', status: 'overdue'},
			]
		}
	},
}
</script>

<style lang="scss">

</style>
