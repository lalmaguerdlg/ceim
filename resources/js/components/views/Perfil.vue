<template>
    <v-container fluid>
        <v-layout column>
            <v-card v-if="!profile_loading && profile">
                <v-img height="250" :src="profile.portada.url" class="white--text"
                    @mouseenter="edit.portada = true" @mouseleave="edit.portada = false">
                <v-scale-transition>
                    <v-btn icon small flat class="edit-portada white--text" v-show="btnPortada" @click="showEditImage('portada')"> <v-icon small>edit</v-icon> </v-btn>
                </v-scale-transition>
				<v-container fill-height fluid>
					<v-layout fill-height align-end wrap>
                        <v-flex xs12 sm2 class="ml-4 text-xs-center" @mouseenter="edit.avatar = true" @mouseleave="edit.avatar = false">
                            <v-badge color="primary" left overlap v-model="btnAvatar">
                                <template v-slot:badge>
                                    <a href="javascript:;" @click="showEditImage('avatar')">
                                        <v-icon dark small>edit</v-icon>
                                    </a>
                                </template>
                                <v-avatar size="96" class="mr-4">
                                    <img :src="profile.avatar.url" alt="Avatar" >
                                </v-avatar>
                            </v-badge>
                        </v-flex>
						<v-flex xs12 sm8>
							<span class="headline">{{profile.name}}</span>
						</v-flex>
					</v-layout>
				</v-container>
			    </v-img>
                <v-card-text>
                    <v-layout wrap>
                        <v-flex xs12 sm6>
                            <div class="subtitle">Email</div>
                            <span class="title">{{profile.email}}</span>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <div class="text-xs-right">
                                <v-chip v-for="rol in profile.roles" :key="`rol-${rol.id}`">{{capitalizeFirst(rol.rol)}}</v-chip>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn fab color="primary" @click.native="showEditModal" small class="mb-2 mr-2" v-if="canEdit">
                        <v-icon dark>edit</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-layout>
        <v-dialog v-model="modals.details.show" max-width="500" persistent>
            <v-card>
                <v-card-title><h3>Editar datos</h3></v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-form @submit.prevent="updateDetails">
                        <!-- <v-text-field prepend-icon="person" id="email" name="email" label="Email" type="text"
                            v-model="email"
                            v-validate="'required|email'"
                            :error-messages="errors.collect('email')"
                            data-vv-name="email"
                            required></v-text-field> -->
                        <v-text-field prepend-icon="person" id="name" name="name" label="Nombre" type="text"
                            v-model="modals.details.name"
                            v-validate="'required|max:100'"
                            counter="100"
                            :error-messages="errors.collect('name')"
                            data-vv-name="name"
                            required></v-text-field>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="blue darken-1" flat @click="closeEditModal">Cerrar</v-btn>
                    <v-btn color="blue darken-1" flat @click="updateDetails">Guardar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="modals.image.show" max-width="500" persistent>
            <v-card>
                <v-card-title><h3>Subir imagen</h3></v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-form @submit.prevent="updateImage">
                            <v-text-field v-if="modals.image.radios == 'url'"
                                prepend-icon="link"
                                clear-icon="close"
                                clearable
                                label="Url de la imagen"
                                type="text"
                                v-model="modals.image.url"
                                ></v-text-field>
                            <file-select v-else 
                                label="Porfavor selecciona una imagen"
                                accept=".jpg,.png,.jpeg"
                                v-on:formData="imageSelected"></file-select>
                            <v-radio-group v-model="modals.image.radios" row>
                                <v-radio label="URL" value="url"></v-radio>
                                <v-radio label="Subir" value="upload"></v-radio>
                            </v-radio-group>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="blue darken-1" flat @click="closeEditImage">Cerrar</v-btn>
                    <v-btn color="blue darken-1" flat @click="updateImage">Guardar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>

import FileSelect from '../widgets/FileSelect.vue'
import { mapActions, mapGetters } from 'vuex';
import { userService } from '../../services';

export default {
    components: {
        FileSelect,
    },
    $_veeValidate: {
		validator: 'new'
	},
    data () {
        return {
            edit: {
                avatar: false,
                portada: false,
            },
            modals: {
                image: {
                    show: false,
                    current: 'avatar',
                    url: '',
                    imageData: null,
                    radios: 'url'
                },
                details: {
                    show: false,
                    name: '',
                }
            },
            dictionary: {
				attributes: {
					name: 'Nombre del usuario',
				},
				custom: {
					message: {
						required: 'El nombre del usuario no puede estar vacío',
						max: 'El nombre del usuario no puede contener mas de 100 caracteres',
					},
				}
			},
        }
    },
    computed: {
        ...mapGetters('profile', ['profile_loading', 'profile', 'profile_updating']),
        ...mapGetters('user', ['account']),
        canEdit() {
            if(this.account && this.profile) {
                return this.account.id == this.profile.id;
            }
            return false;
        },
        id() {
            return this.$route.params.id ? this.$route.params.id : 0;
        },
        btnPortada() {
            return this.canEdit && this.edit.portada
        },
        btnAvatar() {
            return this.canEdit && this.edit.avatar
        },
        btnDetails() {
            return this.canEdit
        },
    },
    created() {
        this.$validator.localize('es', this.dictionary);
        if(this.id) {
            this.fetchProfile(this.id);
        }
        else{
            this.$router.push('/')
        }
    },
    beforeRouteUpdate(to, from, next) {
        if(to.params.id) {
            this.fetchProfile(to.params.id);
        }
        else{
            this.$router.push('/')
        }
        next();
    },
    methods: {
        ...mapActions('profile', ['fetchProfile', 'updateProfile']),
        capitalizeFirst(rol) {
            return rol.charAt(0).toUpperCase() + rol.slice(1);
        },
        showEditImage(imageToEdit) {
            this.modals.image.current = imageToEdit;
            this.modals.image.show = true;
        },
        closeEditImage() {
            this.modals.image.url = '';
            this.modals.image.imageData = null;
            this.modals.image.show = false;
        },
        showEditModal(){
            this.modals.details.name = this.profile.name;
            this.modals.details.show = true;
        },
        closeEditModal() {
            this.modals.details.name = '';
            this.modals.details.show = false;
        },
        imageSelected(form) {
			this.modals.image.imageData = form.get('data');
        },
        async updateImage() {
            if(this.modals.image.url != '' || this.modals.image.imageData != null) {
                try {
                    let profile_data = new FormData();
                    if(this.modals.image.radios == 'url') {
                        profile_data.append(this.modals.image.current, this.modals.image.url);
                    }
                    else if(this.modals.image.radios == 'upload') {
                        profile_data.append(this.modals.image.current, this.modals.image.imageData);
                    }
                    await this.updateProfile(profile_data);
                    this.closeEditImage();
                }
                catch(err) {
                    // if(err && (err.errors.avatar || err.errors.portada)){
                    //     this.errors;
                    // }
                }
            }
            
        },
        async updateDetails() {
            let valid = await this.$validator.validateAll();
            if(valid) {

                try {
                    let profile_data = new FormData();
                    profile_data.append('name', this.modals.details.name);
                    await this.updateProfile(profile_data);
                    this.closeEditImage();
                }
                catch(err) {
                    if(err && (err.errors.name)){
                        this.errors;
                        e.errors.name.forEach(v => this.errors.add({ field: 'name', msg: v}));                    
                    }
                }

                this.closeEditModal();
            }
        }
    }
}
</script>


<style lang="scss" scoped>

.edit-portada {
    position: absolute;
    top: 5px;
    left: 5px;
}

</style>
