<template>
  <div class="content-wrapper mt-5 pt-3">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header print-hide">
                            <h3 class="card-title green">Messege</h3>
                        </div> -->
                        <div class="container chat_app">
                            <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
                            <ContactList @search="searchUser" :contacts="contacts" @selected="startConversationWith"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>
<style>

</style>
<script>
import Conversation from './Conversation';
import ContactList from './ContactList';

    export default {
        props:{
            user_id:{},
        },
        data() {
            return {
                selectedContact:null,
                search:'',
                messages:{},
                contacts:{},
                users:{},
            }
        },
        methods: {
            searchUser(text){
                Fire.$on("searching", ()=> {
                let query = this.$parent.search;
                axios.get('api/findUser?q='+ text)
                .then((data)=>{
                    this.contacts = data.data;
                })
                .catch(()=>{

                })
            });
            },
            contactslist(){
              axios.get('api/contacts/')
              .then(response => {
                    this.contacts = response.data;
                });
            },
            startConversationWith(contact){
                this.updateUnreadCount(contact, true);

                axios.get(`api/conversation/${contact.id}`)
                .then(response => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    });
            },
            saveNewMessage(message){
                this.messages.push(message);
            },
            handleIncoming(message){
                if(this.selectedContact && message.from == this.selectedContact.id){
                    this.saveNewMessage(message);
                    return;
                }
                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset){
                this.contacts = this.contacts.map((single) => {
                    if(single.id != contact.id){
                        return single;
                    }

                    if(reset){
                        single.unread = 0;
                    }else{
                        single.unread += 1;
                    }
                    return single;
                })
            }
        },
        created() {            
            this.contactslist();

            Fire.$on("searching", ()=> {
                let query = this.$parent.search;
                if(query!=''){
                    axios.get('api/findPeople?q='+ query)
                    .then((data)=>{
                        this.contacts = data.data;
                    })
                    .catch(()=>{

                    })
                }else{
                    this.contactslist();
                }
            });
            
            // axios.get('api/user/')
            //   .then(response => {
            //         this.user = response.data;
            //     });

        },
        mounted() {
            Echo.private(`messages.${this.user_id}`)
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