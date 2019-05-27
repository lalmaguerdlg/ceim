<template>
	<div class="projects">
		<h1 class="subheading grey--text">Projects</h1>

		<v-container class="my-5">
			<v-expansion-panel >
				<v-expansion-panel-content v-for="(project, i) of myProjects" :key="i">
					<template v-slot:header>
						<div>{{project.title}}</div>
					</template>

					<v-card>
						<v-card-text class="px-4 grey--text">
							<div class="font-weight-bold">due by {{project.date}}</div>
							<div>{{project.data}}</div>
						</v-card-text>
					</v-card>
				</v-expansion-panel-content>
			</v-expansion-panel>
		</v-container>

	</div>

</template>

<script>
export default {
	data() {
		return {
			projects: [
				{ title: 'Create a new website', person: 'The net ninja', date: '1st Jan 2019', status: 'ongoing', data: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque fuga molestiae consequuntur iste deserunt voluptatem eius esse repudiandae rerum sit omnis, ut quos, vel ipsa? Veritatis necessitatibus distinctio eum exercitationem.'},
				{ title: 'A new website', person: 'Max', date: '1st Jan 2019', status: 'complete', data: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque fuga molestiae consequuntur iste deserunt voluptatem eius esse repudiandae rerum sit omnis, ut quos, vel ipsa? Veritatis necessitatibus distinctio eum exercitationem.'},
				{ title: 'Settup room', person: 'Max', date: '1st Jan 2019', status: 'ongoing', data: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque fuga molestiae consequuntur iste deserunt voluptatem eius esse repudiandae rerum sit omnis, ut quos, vel ipsa? Veritatis necessitatibus distinctio eum exercitationem.' },
				{ title: 'Settup room', person: 'Robert Milkton', date: '1st Jan 2019', status: 'ongoing', data: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque fuga molestiae consequuntur iste deserunt voluptatem eius esse repudiandae rerum sit omnis, ut quos, vel ipsa? Veritatis necessitatibus distinctio eum exercitationem.' },
				{ title: 'Play some games', person: 'Andrew Mark', date: '1st Jan 2019', status: 'overdue', data: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque fuga molestiae consequuntur iste deserunt voluptatem eius esse repudiandae rerum sit omnis, ut quos, vel ipsa? Veritatis necessitatibus distinctio eum exercitationem.' },
			]
		}
	},
	computed: {
		myProjects() {
			return this.projects.filter(project => { 
				return project.person == 'Max';
			});
		}
	}
}
</script>

<style>

</style>
