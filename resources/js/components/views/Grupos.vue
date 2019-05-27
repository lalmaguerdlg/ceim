<template>
	<div id="grupos">
		<h1 class="subheading grey--text">Mis cursos</h1>

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
	</div>
</template>

<script>

import { alumnoService } from '../../services'
import { mapState, mapActions, mapGetters } from 'vuex'

export default {
	data() {
		return {
		}
	},
	computed: {
		...mapGetters('alumno', ['grupos', 'isLoading'])
	},
	created() {
		if(this.grupos.length == 0)
			this.fetchGrupos();
	},
	methods: {
		...mapActions('alumno', ['fetchGrupos']),
		displayDuration(grupo) {
			let usePlural = grupo.curso.duracion > 1;
			let text = usePlural ? grupo.curso.unidad_duracion.plural : grupo.curso.unidad_duracion.nombre;
			return `${grupo.curso.duracion} ${text}`;
		},
		
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
