<template>
	<v-container >
	<div class="grupo">
		<v-card v-if="!grupo_loading">
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
									<!-- <v-card-actions>
										<v-spacer></v-spacer>
										<v-btn flat color="primary" :to="`/grupo/${id}/modulo/${modulo.id}`" class="route-link">
											<v-icon left>arrow_right_alt</v-icon>Ir al modulo 
										</v-btn>
									</v-card-actions> -->
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
								<router-link :to="`/usuario/${alumno.id}`">
									<v-list-tile-avatar >
											<img :src="alumno.avatar.url">
									</v-list-tile-avatar>
								</router-link>

								<v-list-tile-content>
										<router-link :to="`/usuario/${alumno.id}`" class="route-link">
											<v-list-tile-title v-html="alumno.name"></v-list-tile-title>
										</router-link>
								</v-list-tile-content>

								<v-list-tile-action>
									<v-btn flat icon color="teal"><v-icon>chat_bubble</v-icon></v-btn>
								</v-list-tile-action>
							</v-list-tile>
						</v-list>
					</v-tab-item>
					<v-tab-item :value="'tabs-mensajes'">
						<v-form @submit.prevent="sendMessage" class="mb-0">
							<v-container>
								<v-layout row wrap>
									<v-flex xs12 class="text-xs-center">
										<v-progress-circular v-if="comentario_uploading"
											indeterminate
											color="primary"
											></v-progress-circular>
										<v-text-field v-else
											name="message"
											v-model="message"
											:prepend-icon="fileDialog.radios == 'youtube' ? 'ondemand_video' : 'photo'"
											append-outer-icon="send"
											box
											v-validate.disable="'required|max:255'"
											:error-messages="errors.collect('message')"
											data-vv-name="message"
											clear-icon="close"
											clearable
											label="Deja un mensaje"
											type="text"
											counter
											maxlength="255"
											@click:append-outer="sendMessage"
											@click:prepend="fileDialog.show = !fileDialog.show"
											required
										></v-text-field>
										<v-dialog v-model="fileDialog.show">
											<v-card>
												<v-card-title>Subir un archivo</v-card-title>
												<v-divider></v-divider>
												<v-card-text>
													<v-container>
													<v-text-field v-if="fileDialog.radios == 'youtube'"
														prepend-icon="link"
														clear-icon="close"
														clearable
														label="Url de youtube"
														type="text"
														v-model="fileDialog.url"
														></v-text-field>
													<file-select v-else 
														label="Porfavor selecciona una imagen"
														accept=".jpg,.png,.jpeg"
														v-on:formData="imageSelected"></file-select>
													<v-radio-group v-model="fileDialog.radios" row>
														<v-radio label="Video" value="youtube"></v-radio>
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
						<v-container fluid class="py-0">
							<v-switch v-model="soloMaestro" label="Mensajes del maestro"></v-switch>
						</v-container>
						<v-timeline v-if="!comentarios_loading"  dense class="mt-0">
							<v-slide-y-transition group hide-on-leave>
								<v-timeline-item v-for="comment of comments" :key="`comment-${comment.id}`"
									:color="isTeacher(comment.autor) ? 'pink' : 'teal'" 
									small
									class="my-1"
									>
									<template v-slot:icon >
										<v-avatar size="40" v-show="$vuetify.breakpoint.xs" ><img :src="comment.autor.avatar.url" alt="avatar"></v-avatar>
									</template>
									<v-card>
										<v-card-text>
											<v-layout align-center wrap>
												<v-flex sm1 v-if="$vuetify.breakpoint.smAndUp">
													<v-tooltip bottom>
														<template v-slot:activator="{ on }">
															<router-link :to="`/usuario/${grupo.maestro.id}`">
																<v-avatar size="40" v-on="on"><img :src="comment.autor.avatar.url" alt="avatar"></v-avatar>
															</router-link>
														</template>
														<span>{{comment.autor.name}}</span>
													</v-tooltip>
												</v-flex>
												<v-flex xs12 sm9>
													<div class="caption">{{comment.mensaje}}</div>
													<v-btn v-for="adjunto of comment.adjuntos" :key="`adjunto-${adjunto.id}`"
													flat icon @click="showContent(adjunto)"><v-icon>{{mediaType(adjunto)}}</v-icon></v-btn>		
												</v-flex>
												<v-flex xs12 sm1>
													<span class="caption font-weight-thin grey--text lighten-1">{{formatDate(comment.updated_at)}}</span>
												</v-flex>
												<v-flex xs12 sm1>
													<v-btn small fab v-show="canEdit(comment)" @click="editComment(comment)"> <v-icon samll>edit </v-icon></v-btn>
												</v-flex>
											</v-layout>
										</v-card-text>
									</v-card>
								</v-timeline-item>	
							</v-slide-y-transition>
      					</v-timeline>
					</v-tab-item>
				</v-tabs-items>
			</v-card-text>
		</v-card>
		<v-dialog v-model="contentDialog" max-width="700" class="content-viewer">
			<div v-if="content.video" class="iframe-container">
				<iframe width="560" height="315" frameborder="0" :src="content.url"></iframe>
			</div>
			<!-- <div v-else class="img-container">
				<img :src="content.url">
			</div> -->
			<v-img v-else :src="content.url" alt="Test"></v-img>
		</v-dialog>
		<v-dialog v-model="commentDialog.show" max-width="500" persistent>
            <v-card>
                <v-card-title><h3>Editar datos</h3></v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-form @submit.prevent="saveEditComment">
                        	<v-text-field prepend-icon="message" id="edit-message" name="edit-message" label="Mensaje" type="text"
								v-model="commentDialog.message"
								v-validate="'required|max:255'"
								counter="255"
								:error-messages="errors.collect('edit-message')"
								data-vv-name="commentDialog.message"
								required></v-text-field>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="blue darken-1" flat @click="commentDialog.show = false">Cerrar</v-btn>
                    <v-btn color="blue darken-1" flat @click="saveEditComment">Guardar</v-btn>
                </v-card-actions>
            </v-card>
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
	$_veeValidate: {
		validator: 'new'
	},
	components: {
		FileSelect
	},
	data() {
		return {
			tabs: 'tabs-modulos',
			message: "",
			contentDialog: false,
			content: { 
				url: '',
				video: false,
			},
			fileDialog: {
				show: false,
				radios: 'image',
				fileData: null,
				url: ''
			},
			commentDialog: {
				show: false,
				message: '',
				id: 0,
			},
			dictionary: {
				attributes: {
					message: 'Mensaje a enviar',
				},
				custom: {
					message: {
						required: 'El mensaje no puede estar vacío',
						max: 'El mensaje no puede contener mas de 255 caracteres',
					},
				}
			},
			soloMaestro: false
		}
	},
	computed: {
		id() {
			return this.$route.params.id;
		},
		...mapGetters('user', ['account']),
		...mapGetters('grupo', ['grupo', 'grupo_loading', 'comentarios', 'comentarios_loading', 'comentario_uploading']),
		comments() {
			return this.soloMaestro ?  this.comentarios.filter(c => this.isTeacher(c.autor)) : this.comentarios;
		}
	},
	mounted() {
		this.$validator.localize('es', this.dictionary);
	},
	created() {
		this.fetchGrupo(this.id);
	},
	methods: {
		...mapActions('grupo', ['fetchGrupo', 'fetchComentarios', 'postComentario', 'updateComentario']),
		async sendMessage() {
			let valid = await this.$validator.validate('message');
			if(!valid) return;
			let hasAttachment = false;
			let attachment_type = this.fileDialog.radios;
			let attachment = '';
			if(attachment_type == 'youtube' && this.fileDialog.url != '') {
				attachment = validateYoutubeUrl(this.fileDialog.url)
				if(attachment != '')
					hasAttachment = true;
			}
			else if(attachment_type == 'image' && this.fileDialog.fileData != null) {
				attachment = this.fileDialog.fileData;
				hasAttachment = true;
			}


			let comentario_data = new FormData();
			comentario_data.append('mensaje', this.message);
			if(hasAttachment) {
				comentario_data.append('adjunto', attachment);
				comentario_data.append('tipo_adjunto', attachment_type);
			}
			this.postComentario({ grupo_id: this.id, comentario_data})
				.then(_ => {
					this.message = "";
					this.fileDialog.fileData = null;
					this.fileDialog.url = '';
				})
				.catch(e => {
					if(e && e.errors.mensaje) {
						e.errors.mensaje.forEach(v => this.errors.add({ field: 'message', msg: v}));
					}
				});
		},
		isTeacher(comment_autor) {
			return comment_autor.id == this.grupo.maestro.id;
		},
		canEdit(comment) {
			if(this.account) {
				return comment.autor.id == this.account.id;
			}
			return false;
		},
		editComment(comment) {
			
			this.commentDialog.message = comment.mensaje;
			this.commentDialog.id = comment.id;
			this.commentDialog.show = true;
		},
		async saveEditComment() {
			let valid = await this.$validator.validate('commentDialog.message');
			if(valid) {
				let data = { 
					grupo_id: this.id,
					id: this.commentDialog.id,
					comentario_data: {
						mensaje: this.commentDialog.message 
					}
				};
				await this.updateComentario(data);
				this.commentDialog.show = false;
			}
		},
		showContent(adjunto) {
			this.contentDialog = true;
			this.content.url = adjunto.url;
			this.content.video = adjunto.tipo == 'video-url';
		},
		mediaType(adjunto) {
			return adjunto.tipo == 'video-url' ? 'ondemand_video' : 'photo'
		},
		imageSelected(form) {
			this.fileDialog.fileData = form.get('data');
		},
		formatDate(value) {
			let date = new Date(value).getTime();
			
			let current = Date.now();
			
			var msPerMinute = 60 * 1000;
			var msPerHour = msPerMinute * 60;
			var msPerDay = msPerHour * 24;
			var msPerMonth = msPerDay * 30;
			var msPerYear = msPerDay * 365;
			
			var elapsed = current - date;
			
			if (elapsed < msPerMinute) {
				return Math.round(elapsed/1000) + ' seg';   
			}
			
			else if (elapsed < msPerHour) {
				return Math.round(elapsed/msPerMinute) + ' min';   
			}
			
			else if (elapsed < msPerDay ) {
				return Math.round(elapsed/msPerHour ) + ' h';   
			}

			else if (elapsed < msPerMonth) {
				return Math.round(elapsed/msPerDay) + ' d';   
			}
			
			else if (elapsed < msPerYear) {
				return Math.round(elapsed/msPerMonth) + ' m ';   
			}
			
			else {
				return Math.round(elapsed/msPerYear ) + ' a ';   
			}
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

	.img-container {
		position: relative;
		width: 100%;
		padding-bottom: 56.25%;
		// height: 0;
		img {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
	}
</style>
	

