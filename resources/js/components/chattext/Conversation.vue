<template>
  <div class="conversation">
      <h3>{{ contact ? contact.name : "Select Contact" }} <i class="fas fa-sms"></i></h3>
      <MessagesFeed :contact="contact" :messages="messages"/>
      <MessageComposer @send="sendMessage"/>
  </div>
</template>
<style>
.conversation i{
    font-size:38px;
    color:#38c172
}
</style>
<script>
import MessagesFeed from './MessagesFeed';
import MessageComposer from './MessageComposer';
    export default {
        name: 'Conversation',
        props:{
            contact:{},
            messages:{},
        },
        data() {
            return {

            }
        },
        methods: {
            sendMessage(text){
                console.log(text);
                if(!this.contact){
                    return;
                }

                axios.post('api/conversation/send',{
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('new', response.data);
                })
            }
        },
        components:{MessagesFeed, MessageComposer}
    }
</script>

<style lang="scss">
    .conversation{
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        h3{
            margin: 0;
            padding: 10px;
            border-bottom: 1px dashed lightgray;
        }
    }
</style>
