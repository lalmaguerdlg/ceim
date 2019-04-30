<template>
	<div class="home">
		<h1 class="subheading grey--text">Dashboard</h1>



		<v-container class="my-5">

			<v-layout row class="mb-3">
				<v-tooltip top>
					<v-btn slot="activator" small flat color="grey" @click="sortBy('title')">
						<v-icon left small>folder</v-icon>
						<span class="caption text-lowercase">By project name</span>
					</v-btn>
					<span>Sort projects by project name.</span>
				</v-tooltip>
				<v-tooltip top>
					<v-btn slot="activator" small flat color="grey" @click="sortBy('person')">
						<v-icon left small>person</v-icon>
						<span class="caption text-lowercase">By person</span>
					</v-btn>
					<span>Sort projects by person name.</span>
				</v-tooltip>
				
			</v-layout>

			<v-card flat v-for="(project,index) of projects" :key="index">
				<v-layout row wrap class="mx-0" :class="`pa-3 project ${project.status}`">
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
	methods: {
		sortBy(prop) {
			this.projects.sort((a, b) => a[prop] < b[prop] ? -1 : 1);
		},
	}
}
</script>

<style scoped>

.project.complete {
	border-left: 4px solid #3cd1c2;
}
.project.ongoing {
	border-left: 4px solid orange;
}
.project.overdue {
	border-left: 4px solid tomato;
}

.v-chip.complete {
	background: #3cd1c2;
}
.v-chip.ongoing {
	background: orange;
}
.v-chip.overdue {
	background: tomato;
}

</style>
