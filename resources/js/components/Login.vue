<template>
  <v-app class="grey lighten-4">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md6>
            <v-card class="elevation-5">
              <v-toolbar flat dark >
                <v-toolbar-title>Inicio de sesion</v-toolbar-title>
              </v-toolbar>
              <v-card-text class="pa-5 pb-0">
                <v-form @submit.prevent="submit" id="login-form">
                  <v-text-field prepend-icon="person" id="email" name="email" label="Email" type="text"
										v-model="email"
										v-validate="'required|email'"
										:error-messages="errors.collect('email')"
										data-vv-name="email"
										required></v-text-field>
                  <v-text-field prepend-icon="lock" id="password" name="password" label="Contraseña" type="password"
										v-model="password"
										v-validate="'required'"
										:error-messages="errors.collect('password')"
										data-vv-name="password"
										required></v-text-field>
                </v-form>

              </v-card-text>
              <v-card-actions class="px-5 py-3">
								<div class="text-xs-right">
									<span>¿No tienes cuenta? <router-link to="/register">Crea una cuenta</router-link></span>
								</div>
                <v-spacer></v-spacer>
                <v-btn type="submit" color="primary" form="login-form" :loading="user_loading">Iniciar sesion</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'

export default {
	$_veeValidate: {
		validator: 'new'
	},
	data() {
		return {
			email: '',
			password: '', 
			dictionary: {
				attributes: {
					email: 'Dirección de correo electrónico',
					password: 'Contraseña'
				},
				custom: {
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
	computed: {
		...mapGetters('user', ['user_loading', 'login_errors','logged_in'])
	},
	mounted() {
		this.$validator.localize('es', this.dictionary);
	},
	watch: {
		logged_in(value, old) {
			if(value) {
					this.$router.push('/');
			}
		},
		login_errors(errors, old) {
			if(errors != null){
				if(e && e.errors.email) {
					errors.email.forEach(e => {
						this.errors.add({
							field: 'email',
							msg: e
						});
					})
				}
			}
		}
	},
	methods: {
		...mapActions('user', ['login']),
		async submit() {
			let valid = await this.$validator.validateAll();
			if(valid) {
				try {
					await this.login({email: this.email, password: this.password});
				} catch(e) {
					if(e && e.errors.email) {
						this.errors.add({
							field: 'email',
							msg: e.errors.email[0]		
						});
					}
				}
			}
		},
		clear() {
			this.email = '';
			this.password = '';
			this.$validator.reset();
		}
	}
}
</script>

<style scoped>

</style>
