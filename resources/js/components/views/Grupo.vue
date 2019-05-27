<template>
	<v-container >
	<div class="grupo">
		<v-card v-if="!isLoading">
			<v-img height="125" :src="grupo.curso.portada.url" class="white--text">
				<v-container fill-height fluid>
					<v-layout fill-height align-end>
						<v-flex xs12 align-end flexbox>
							<span class="headline">{{grupo.curso.nombre}}</span>
							<br>
						</v-flex>
					</v-layout>
				</v-container>
			</v-img>
			<v-card-title>
				<v-layout align-center row class="px-4">
					<v-flex xs12 md8 class="mb-2">
						<div class="subheader">{{grupo.curso.descripcion}}</div>
					</v-flex>
					<v-flex xs12 md4 class="text-md-right">
						<router-link :to="`/usuario/${grupo.maestro.id}`" class="route-link">
							<v-avatar size="36px" class="mr-2">
								<img :src="grupo.maestro.avatar.url" alt="">
							</v-avatar>
							<span class="">{{grupo.maestro.name}}</span>
						</router-link>
					</v-flex>
				</v-layout>
			</v-card-title>
			<v-card-text>
				<v-tabs v-model="tabs" centered grow>
					<v-tabs-slider></v-tabs-slider>
					<v-tab href="#tabs-modulos"> Modulos </v-tab>
					<v-tab href="#tabs-alumnos"> Alumnos </v-tab>
					<v-tab href="#tabs-mensajes"> Mensajes </v-tab>
				</v-tabs>
				<v-divider class="mt-0"></v-divider>
				<v-tabs-items v-model="tabs"> 
					<v-tab-item :value="'tabs-modulos'">
						<v-expansion-panel popout>
							<v-expansion-panel-content
								v-for="modulo in grupo.curso.modulos"
								:key="`modulo-${modulo.id}`">
								<template v-slot:header>
									<div>{{modulo.nombre}}</div>
								</template>
								<v-card>
									<v-card-text>{{modulo.descripcion}} </v-card-text>
									<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn flat color="primary" :to="`/grupo/${id}/modulo/${modulo.id}`" class="route-link">
											<v-icon left>arrow_right_alt</v-icon>Ir al modulo 
										</v-btn>
									</v-card-actions>
								</v-card>
							</v-expansion-panel-content>
						</v-expansion-panel>
					</v-tab-item>
					<v-tab-item :value="'tabs-alumnos'">
						<v-list>
							<v-list-tile
								v-for="alumno in grupo.alumnos"
								:key="`alumno-${alumno.id}`"
								avatar
							>
								<v-list-tile-avatar>
									<img :src="alumno.avatar.url">
								</v-list-tile-avatar>

								<v-list-tile-content>
									<v-list-tile-title v-html="alumno.name"></v-list-tile-title>
								</v-list-tile-content>

								<v-list-tile-action>
									<v-btn flat icon color="teal"><v-icon>chat_bubble</v-icon></v-btn>
								</v-list-tile-action>
							</v-list-tile>
						</v-list>
					</v-tab-item>
					<v-tab-item :value="'tabs-mensajes'">
						<v-form>
							<v-container>
								<v-layout row wrap>
									<v-flex xs12>
										<v-text-field
											v-model="message"
											append-outer-icon="send"
											box
											clear-icon="mdi-close-circle"
											clearable
											label="Deja un mensaje"
											type="text"
											@click:append-outer="sendMessage"
										></v-text-field>
									</v-flex>
								</v-layout>
							</v-container>
						</v-form>
						<v-timeline
							align-top
							dense>
							<v-timeline-item
								v-for="comment of comments"
								:key="`comment-${comment.id}`"
								:color="isTeacher(comment.user) ? 'pink' : 'teal'"
								small>
								<v-layout  pt-3>
									<v-flex xs3 class="text-truncate">
										<v-avatar size="30"> <img :src="comment.user.avatar.url" alt="avatar"></v-avatar>
										<strong class="ml-2 ">{{comment.user.name}}</strong>
									</v-flex>
									<v-flex xs9>
										<div class="caption">{{comment.message}}</div>
									</v-flex>
								</v-layout>
							</v-timeline-item>
      					</v-timeline>
					</v-tab-item>
				</v-tabs-items>
			</v-card-text>
		</v-card>
	</div>
	</v-container>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'

export default {
	data() {
		return {
			tabs: null,
			message: "",
			comments: [
				{"id": 1, "message": "This is a commented text", "user": {id: 1, name: "Luis Adrian Almaguer de la Garza", avatar: { url: "http://localhost:8000/images/placeholder.jpg"}} },
				{"id": 2, "message": "This is a commented text", "user": {id: 2, name: "Max", avatar: { url: "https://avataaars.io/?avatarStyle=Circle&topType=LongHairFrida&accessoriesType=Kurt&hairColor=Red&facialHairType=BeardLight&facialHairColor=BrownDark&clotheType=GraphicShirt&clotheColor=Gray01&graphicType=Skull&eyeType=Wink&eyebrowType=RaisedExcitedNatural&mouthType=Disbelief&skinColor=Brown"}} },
				{"id": 3, "message": "This is a commented text", "user": {id: 2, name: "Max", avatar: { url: "https://avataaars.io/?avatarStyle=Circle&topType=LongHairFrida&accessoriesType=Kurt&hairColor=Red&facialHairType=BeardLight&facialHairColor=BrownDark&clotheType=GraphicShirt&clotheColor=Gray01&graphicType=Skull&eyeType=Wink&eyebrowType=RaisedExcitedNatural&mouthType=Disbelief&skinColor=Brown"}} },
				{"id": 4, "message": "This is a commented text", "user": {id: 2, name: "Max", avatar: { url: "https://avataaars.io/?avatarStyle=Circle&topType=LongHairFrida&accessoriesType=Kurt&hairColor=Red&facialHairType=BeardLight&facialHairColor=BrownDark&clotheType=GraphicShirt&clotheColor=Gray01&graphicType=Skull&eyeType=Wink&eyebrowType=RaisedExcitedNatural&mouthType=Disbelief&skinColor=Brown"}} },
			]
		}
	},
	computed: {
		id() {
			return this.$route.params.id;
		},
		...mapGetters('alumno', ['grupoDetalle', 'isLoading']),
		grupo() {
			return this.grupoDetalle;
		}
	},
	created() {
		/*if(this.grupos.length == 0) {
			this.fetchGrupos();
		}*/
		this.fetchGrupoDetails(this.id);
	},
	methods: {
		...mapActions('alumno', ['fetchGrupoDetails']),
		sendMessage() {
			message = "";
		},
		isTeacher(user) {
			return user.id == this.grupo.maestro.id;
		}
	}
}
</script>

<style>
	
</style>
