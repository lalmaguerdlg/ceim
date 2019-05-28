<template>
	<v-container fluid fill-height>
		<v-layout column fill-height>
			<v-flex xs-10>
				<Message 
					v-for="(message) in messages" 
					:message="message" 
					:key="message.created"
					/>
			</v-flex>
			<v-spacer></v-spacer>
			<v-flex xs-2>
				<v-form @submit.prevent="sendMessage" class="form">
					<v-text-field name="message"
						v-model="message"
						append-outer-icon="send"
						box
						clear-icon="close"
						clearable
						label="Deja un mensaje"
						type="text"
						counter
						maxlength="255"
						@click:append-outer="sendMessage"
						required
					></v-text-field>
				</v-form>
			</v-flex>
		</v-layout>
	</v-container>
</template>
<script>
  import Message from './widgets/Message.vue'
  import { mapState } from 'vuex'
  export default {
    name: 'Chat',
    props: {

	},
	data() {
		return {
			message: ''
		}
	},
	methods: {
		sendMessage() {
			this.$store.dispatch('messages/sendMessage', { 
				text: this.message, 
				created: Date.now(),
				sender: this.account.email,
				conversationId: "JxyS9Uiw8igbHIT0BP97",
			})
			this.message = '';
		}
	},
	computed: {
		...mapState('messages', ['messages']),
		...mapState('user', ['account'])
	},
    created () {		
		this.$store.state.db.collection('messages').onSnapshot(snapshot => {
			snapshot.docChanges().forEach(change => {
                    if (change.type == 'added') {
                        let doc = change.doc;
						this.$store.commit('messages/ADD_MESSAGE', { 
							id: doc.id,
                            sender: doc.data().sender,
                            text: doc.data().text,
							created: doc.data().created
						});
					}
                });
		})
    },
    components: {
      Message
    }
  }
</script>
<style scoped>
	.form {
		position: absolute;
		bottom: 0;
		width: 80%;
	}
</style>