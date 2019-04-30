<template>
	<div class="team">
		<h1 class="subheading grey--text">Team</h1>
		
		<v-container class="my-5">
			
			<v-layout row wrap>
				<v-flex xs12 sm6 md4 lg3 v-for="(person,index) of team" :key="index">
					<v-card flat class="text-xs-center ma-3">
						<v-responsive class="pt-4">
							<v-avatar size="100" class="grey lighten-2">
								<img :src="person.avatar">
							</v-avatar>
						</v-responsive>
						<v-card-text>
							<div class="subheading">{{person.name}}</div>
							<div class="grey--text">{{person.role}}</div>						
						</v-card-text>
						<v-card-actions>
							<v-btn flat color="grey">
								<v-icon small left>message</v-icon>
								<span class="hidden-xs-only">Message</span>
							</v-btn>
						</v-card-actions>
					</v-card>
				</v-flex>
			</v-layout>

		</v-container>
	</div>
</template>

<script>
export default {
	data() {
		return {
			team: [
				{ name: 'Max', role: 'Web developer', avatar: 'https://picsum.photos/id/1/200/200' },
				{ name: 'Ryu', role: 'Graphic designer', avatar: 'https://picsum.photos/id/2/200/200'},
				{ name: 'Chun Li', role: 'Web developer', avatar: 'https://picsum.photos/id/3/200/200'},
				{ name: 'Gouken', role: 'Web developer', avatar: 'https://picsum.photos/id/4/200/200'},
				{ name: 'Yoshi', role: 'Graphic designer', avatar: 'https://picsum.photos/id/5/200/200'},
			]
		}
	}
}
</script>

<style>

</style>
