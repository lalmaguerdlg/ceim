<template>
	<div id="grupos">
		<h1 class="subheading grey--text" >Mis cursos</h1>
		<v-btn v-show="isAdmin" @click="grupoDialog.show = true"><v-icon left>add</v-icon>Crear grupo</v-btn>
		<v-container class="my-4"> 
			<v-card flat v-for="grupo of grupos" :key="`grupo-${grupo.id}`" class="my-4 route-link" :class="`curso`" :to="`/grupo/${grupo.id}`">
				<v-layout wrap>
					<v-flex xs12 sm12 md2>
						<v-img height="125" :src="grupo.curso.portada.url"></v-img>
					</v-flex>
					<v-flex xs12 sm12 md10>
						<v-layout row wrap class="mx-0" :class="`pa-3`">
							<v-flex xs12 md6>
								<h6 class="title">{{grupo.curso.nombre}}</h6>
								<p class="subbheading">{{grupo.curso.descripcion}}</p>
								<p class="caption">Duración: {{displayDuration(grupo)}}</p>
							</v-flex>
							<v-flex xs12 md6>
								<p><span class="body-2">Grupo: </span><span class="body-1">00{{grupo.id}}</span></p>
							</v-flex>
						</v-layout>
					</v-flex>
				</v-layout>
			</v-card>
		</v-container>
		<v-dialog v-model="grupoDialog.show" max-width="500" persistent>
            <v-card>
                <v-card-title><h3>Crear un grupo</h3></v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-form @submit.prevent="createGrupo">
                            <v-text-field
                                clear-icon="close"
                                clearable
                                label="Cantidad de alumnos"
                                type="number"
                                v-model="grupoDialog.cantidad"
                                ></v-text-field>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="blue darken-1" flat @click="grupoDialog.show = false">Cerrar</v-btn>
                    <v-btn color="blue darken-1" flat @click="addGrupo">Crear</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
	</div>
</template>

<script>

import { alumnoService } from '../../services'
import { mapState, mapActions, mapGetters } from 'vuex'

export default {
	data() {
		return {
			grupoDialog: {
				show: false,
				cantidad: 30,
			}
		}
	},
	computed: {
		...mapGetters('alumno', ['grupos', 'grupos_loading']),
		...mapGetters('user', ['account']),
		isAdmin() {
			if(this.account) {
				let foundIndex = this.account.roles.findIndex(v => v.rol == 'admin');
				return foundIndex != -1;
			}
			return false;
		}
	},
	created() {
		if(this.grupos.length == 0)
			this.fetchGrupos();
	},
	methods: {
		...mapActions('alumno', ['fetchGrupos', 'createGrupo']),
		displayDuration(grupo) {
			let usePlural = grupo.curso.duracion > 1;
			let text = usePlural ? grupo.curso.unidad_duracion.plural : grupo.curso.unidad_duracion.nombre;
			return `${grupo.curso.duracion} ${text}`;
		},
		addGrupo() {
			let nuevo_grupo = {
				"inicio_curso": new Date(),//"5/21/2019",
				"fin_curso": "",//"5/22/2019",
				"maestro": "1",
				"capacidad": this.grupoDialog.cantidad
			};
			this.createGrupo(nuevo_grupo)
				.then(_ => this.grupoDialog.show = false)
				.catch(e => console.log(e))
		}
	}
}
</script>

<style lang="scss" scoped>

::v-deep.route-link {
	& {
		text-decoration: none;
	}
}

</style>
