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
						<v-form class="mb-0">
							<v-container>
								<v-layout row wrap>
									<v-flex xs12>
										<v-text-field
											v-model="message"
											:prepend-icon="fileDialog.radios == 'video' ? 'ondemand_video' : 'photo'"
											append-outer-icon="send"
											box
											clear-icon="close"
											clearable
											label="Deja un mensaje"
											type="text"
											@click:append-outer="sendMessage"
											@click:prepend="fileDialog.show = !fileDialog.show"
										></v-text-field>
										<v-dialog v-model="fileDialog.show">
											<v-card>
												<v-card-title>Subir un archivo</v-card-title>
												<v-divider></v-divider>
												<v-card-text>
													<v-container>
													<v-text-field v-if="fileDialog.radios == 'video'"
														prepend-icon="link"
														clear-icon="close"
														clearable
														label="Url del video"
														type="text"
														v-model="fileDialog.url"
														></v-text-field>							
													<file-select v-else 
														label="Porfavor selecciona una imagen"
														accept=".jpg,.png,.jpeg"
														v-on:formData="imageSelected"></file-select>
													<v-radio-group v-model="fileDialog.radios" row>
														<v-radio label="Video" value="video"></v-radio>
														<v-radio label="Imagen" value="image"></v-radio>
													</v-radio-group>
													</v-container>
												</v-card-text>
												<v-divider></v-divider>
												<v-card-actions>
													<v-btn color="blue darken-1" flat @click="fileDialog.show = false">Cerrar</v-btn>
													<v-btn color="blue darken-1" flat @click="fileDialog.show = false">Guardar</v-btn>
												</v-card-actions>
											</v-card>
										</v-dialog>
									</v-flex>
								</v-layout>
							</v-container>
						</v-form>
						<v-timeline  dense class="mt-0">
							<v-timeline-item v-for="comment of comments" :key="`comment-${comment.id}`"
								:color="isTeacher(comment.user) ? 'pink' : 'teal'" 
								small
								class="my-1">
								<template v-slot:icon v-if="$vuetify.breakpoint.xs">
									<v-avatar size="40" ><img :src="comment.user.avatar.url" alt="avatar"></v-avatar>
								</template>
								<v-card>
									<v-card-text>
										<v-layout align-center>
											<v-flex sm1 v-if="$vuetify.breakpoint.smAndUp">
												<v-tooltip bottom>
													<template v-slot:activator="{ on }">
														<v-avatar size="40" v-on="on"><img :src="comment.user.avatar.url" alt="avatar"></v-avatar>
													</template>
													<span>{{comment.user.name}}</span>
												</v-tooltip>
											</v-flex>
											<v-flex xs12 sm10>
												<div class="caption">{{comment.message}}</div>
												<v-btn flat icon v-if="comment.media" @click="showContent(comment)"><v-icon>{{mediaType(comment.media)}}</v-icon></v-btn>		
											</v-flex>
										</v-layout>
	
									</v-card-text>
								</v-card>
							</v-timeline-item>
      					</v-timeline>
					</v-tab-item>
				</v-tabs-items>
			</v-card-text>
		</v-card>
		<v-dialog v-model="contentDialog" max-width="700">
				<div v-if="content.video" class="iframe-container">
					<iframe width="560" height="315" frameborder="0" :src="content.url"></iframe>
				</div>
				<v-img v-else :src="content.url"></v-img>
		</v-dialog>
	</div>
	</v-container>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'
import FileSelect from '../widgets/FileSelect.vue'


function validateYoutubeUrl(url) {
	let embedUrl = '';
	if (url != undefined || url != '') {
		var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
		var match = url.match(regExp);
		if (match && match[2].length == 11) {
			embedUrl = 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0';
		}
	}
	return embedUrl;
}

export default {
	components: {
		FileSelect
	},
	data() {
		return {
			tabs: 'tabs-mensajes',
			message: "",
			comments: [
				{"id": 1, "message": "This is a commented text", media: { url: 'https://www.youtube.com/embed/e0Meo8ablI8', type: 'video'},"user": {id: 1, name: "Luis Adrian Almaguer de la Garza", avatar: { url: "http://localhost:8000/images/placeholder.jpg"}} },
				{"id": 2, "message": "This is a commented text", media: { url: 'https://www.w3schools.com/w3images/fjords.jpg', type: 'image'}, "user": {id: 2, name: "Max", avatar: { url: "https://avataaars.io/?avatarStyle=Circle&topType=LongHairFrida&accessoriesType=Kurt&hairColor=Red&facialHairType=BeardLight&facialHairColor=BrownDark&clotheType=GraphicShirt&clotheColor=Gray01&graphicType=Skull&eyeType=Wink&eyebrowType=RaisedExcitedNatural&mouthType=Disbelief&skinColor=Brown"}} },
				{"id": 3, "message": "This is a commented text", media: { url: 'https://www.youtube.com/embed/74O6cGGGxeA', type: 'video'}, "user": {id: 2, name: "Max", avatar: { url: "https://avataaars.io/?avatarStyle=Circle&topType=LongHairFrida&accessoriesType=Kurt&hairColor=Red&facialHairType=BeardLight&facialHairColor=BrownDark&clotheType=GraphicShirt&clotheColor=Gray01&graphicType=Skull&eyeType=Wink&eyebrowType=RaisedExcitedNatural&mouthType=Disbelief&skinColor=Brown"}} },
				{"id": 4, "message": "This is a commented text", media: { url: 'https://www.ostraining.com/cdn/images/coding/responsivevideos_1.jpg', type: 'image'}, "user": {id: 3, name: "Mark", avatar: { url: "https://avataaars.io/?avatarStyle=Circle&topType=NoHair&accessoriesType=Blank&facialHairType=MoustacheFancy&facialHairColor=BrownDark&clotheType=ShirtScoopNeck&clotheColor=Blue02&eyeType=Side&eyebrowType=SadConcernedNatural&mouthType=ScreamOpen&skinColor=Yellow"}} },
			],
			contentDialog: false,
			content: { 
				url: '',
				video: false,
			},
			fileDialog: {
				show: false,
				radios: 'video',
				fileData: null,
				url: ''
			},
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
		this.fetchGrupoDetails(this.id);
	},
	methods: {
		...mapActions('alumno', ['fetchGrupoDetails']),
		sendMessage() {
			let hasFile = false;
			let embed = '';
			if(this.fileDialog.radios == 'video' && this.fileDialog.url != '') {
				embed = validateYoutubeUrl(this.fileDialog.url)
				if(embed != '')
					hasFile = true;
			}
			else if(this.fileDialog.radios == 'image' && this.fileDialog.fileData != null) {
				hasFile = true;
			}

			console.log(this.message, hasFile ? this.fileDialog.radios == 'video' ? embed : this.fileDialog.fileData : '');
			this.message = "";
		},
		isTeacher(user) {
			return user.id == this.grupo.maestro.id;
		},
		showContent(comment) {
			this.contentDialog = true;
			this.content.url = comment.media.url;
			this.content.video = comment.media.type == 'video';
		},
		mediaType(media) {
			return media.type == 'video' ? 'ondemand_video' : 'photo'
		},
		imageSelected(form) {
			this.fileDialog.fileData = form.get('data');
		}
	}
}
</script>

<style <style lang="scss" scoped>
	.iframe-container {
		position: relative;
		width: 100%;
		padding-bottom: 56.25%;
		height: 0;
		iframe {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
	}
</style>
	

