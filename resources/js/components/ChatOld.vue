<template>
  <div class="content-wrapper mt-5 pt-3">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header print-hide">
                            <h3 class="card-title green">Messenger</h3>
                        </div>
                        <div class="container chat_app">
                            <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
                            <ContactList :contacts="contacts" @selected="startConversationWith"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import Conversation from './Conversation';
import ContactList from './ContactList';

    export default {
        props:{
            user:{
                type:Object,
                required:true
            }
        },
        data() {
            return {
                selectedContact:null,
                messages:{},
                contacts:{},
            }
        },
        methods: {
            contactslist(){
              axios.get('api/contacts/')
              .then(response => {
                    this.contacts = response.data;
                });
            },
            startConversationWith(contact){
                axios.get(`api/conversation/${contact.id}`)
                .then(response => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    });
            },
            saveNewMessage(text){
                this.messages.push(text);
            },
            handleIncoming(message){
                if(this.selectedContact && message.from == this.selectedContact.id){
                    this.saveNewMessage(message);
                }
                alert(message.text)
            }
        },
        created() {            
            this.contactslist();

        },
        mounted() {
            Echo.private(`messages${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.handleIncoming(e.message)
                })
        },        
        components: { Conversation, ContactList }
    }
</script>

<style lang="scss" scoped>
    .chat_app {
        display: flex;
        padding: 0;
    }
</style>