<template>
	<v-app class="grey lighten-4">
	<v-content>
		<v-container fluid fill-height>
			<v-layout align-center justify-center>
				<v-flex xs12 sm8 md6>
					<v-card class="elevation-5">
						<v-toolbar flat dark >
							<v-toolbar-title>Registro</v-toolbar-title>
						</v-toolbar>
						<v-card-text class="pa-5 pb-0">
							<v-form @submit.prevent="submitRegister" id="login-form">
								<v-text-field prepend-icon="person" name="name" label="Nombre" type="text"
									v-model="name"
									v-validate="'required|max:100'"
									counter="100"
									:error-messages="errors.collect('name')"
									required></v-text-field>
								<v-text-field prepend-icon="email" name="email" label="Email" type="text"
									v-model="email"
									v-validate="'required|email'"
									:error-messages="errors.collect('email')"
									required></v-text-field>
								<v-text-field prepend-icon="lock" name="password" label="Contraseña" type="password"
									v-model="password"
									v-validate="'required'"
									:error-messages="errors.collect('password')"
									required></v-text-field>
							</v-form>
						</v-card-text>
						<v-card-actions class="px-5 py-3">
							<v-btn type="submit" color="primary" form="login-form" :loading="user_loading">Crear cuenta</v-btn>
							<v-spacer></v-spacer>
							<div class="text-xs-right">
								<span>¿Ya tienes una cuenta? <router-link to="/login">Inicia sesion</router-link> </span>
							</div>
						</v-card-actions>
					</v-card>
				</v-flex>
			</v-layout>
		</v-container>
	</v-content>
  	</v-app>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
	$_veeValidate: {
		validator: 'new'
	},
	data() {
		return {
			name: '',
			email: '',
			password: '',
			dictionary: {
				attributes: {
					name: 'Nombre del estudiante',
					email: 'Dirección de correo electrónico',
					password: 'Contraseña'
				},
				custom: {
					name: {
						required: () => 'El nombre no puede estar vacío',
						max: 'El nombre no puede contener mas de 100 caracteres',
					},
					email: {
						required: () => 'El correo no puede estar vacío',
						email: 'El correo no tiene el formato correcto',
					},
					password: {
						required: () => 'La contraseña no puede estar vacía',
					}
				}
			}
		}
	},
	mounted() {
		this.$validator.localize('es', this.dictionary);
	},
	computed: {
		...mapGetters('user', ['user_loading', 'login_errors','logged_in'])
	},
	watch: {
		logged_in(value, old) {
			if(value) {
				this.$router.push('/');
			}
		},
		login_errors(e, old) {
			console.log(e, old);
			if(e != null){
				if(e && e.errors.email) {
					e.errors.email.forEach(msg => this.errors.add({ field: 'email', msg: msg }))
				}
				if(e && e.errors.name) {
					e.errors.name.forEach(msg => this.errors.add({ field: 'name', msg: msg }))
				}
				if(e && e.errors.password) {
					e.errors.password.forEach(msg => this.errors.add({ field: 'password', msg: msg }))
				}
			}
		}
	},
	methods: {
		...mapActions('user', ['register']),
		async submitRegister() {
			let valid = this.$validator.validateAll();
			if(valid) {
				this.register({
					name: this.name,
					email: this.email,
					password: this.password
				});
			}
		}
	}
}
</script>

<style>

</style>
