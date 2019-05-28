<template>
  <div :class="getPosition">
    <div class="caption grey--text">{{message.sender}}</div>
    <v-chip class="message-container">
        {{ message.text }}
    </v-chip>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
  export default {
    name: 'Message',
    props: {
      message: {
        type: Object,
        required: true
      }
    },
    computed: {
		...mapGetters('user', ['account']),
      getPosition () {
        if (this.message.sender === this.account.email) {
          return 'text-xs-right'
        } else {
          return 'text-xs-left'
        }
      }
    }
  }
</script>
<style scoped>
.my.message {
  text-align: right;
}
.message-container {
  border: 1px solid silver;
}

.caption {
  font-size: 0.8em !important;
}
</style>