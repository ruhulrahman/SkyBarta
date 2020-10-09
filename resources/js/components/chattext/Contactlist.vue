<template>
  <div class="">
      <input type="search" class="form-control" v-model="search" placeholder="Search Name" id="">
      <div class="contact-list">
      <ul class="">
          <li v-for="(contact, index) in sortedContacts" @click="selectContact(index, contact)" :class="{'selected' : index == selected}" :key="index">
            <div class="avatar">
                <img :src="getPhoto(contact.photo)" :alt="contact.name">
            </div>
            <div class="contact">
                <p class="name">{{ contact.name }}</p>
                <p class="email">{{ contact.email }}</p>
            </div>
            <span class="badge badge-danger navbar-badge unread" v-if="contact.unread">{{ contact.unread }}</span>
          </li>
      </ul>
      </div>
  </div>
</template>

<script>
    export default {
        name: 'ContactList',
        props:{
            contacts:{},
        },
        data() {
            return {
                selected:0,
                search:'',                
            }
        },
        methods: {
            getPhoto(photo){
                if(photo){
                    let pt = "/img/profile/"+photo;
                    return pt;
                }else{               
                    let pt = "img/boy.png";
                    return pt;
                }
            },
            selectContact(index, contact){
                this.selected = index;
                this.$emit('selected', contact);
            }
        },
        computed: {
            sortedContacts(){
                return _.sortBy(this.contacts, [(contact) => {
                    return contact.unread;
                }]).reverse();
            },
            send(){
                // e.preventDefault();
                
                if(this.search == ''){
                    return;
                }
                this.$emit('search', this.search);
                this.search = '';
            }
        },
    }
</script>
<style lang="scss">
    .contact-list::-webkit-scrollbar {
        width: 8px;
    }

    .contact-list::-webkit-scrollbar-track {
        box-shadow: inset 0px 0px 4px rgb(3 255 46);
    }

    .contact-list::-webkit-scrollbar-thumb {
        background-color: #38C172;
        outline: 1px solid slategrey;
        border-radius: 50px;

    }
    .contact-list{
        flex: 2;
        max-height: 500px;
        overflow: scroll;
        overflow-x: hidden;
        border-left: 1px solid #dedede;
        input{
            
        };
        ul{
            list-style-type: none;
            padding-left: 0;
            li{
                display: flex;
                border-bottom: 1px solid #e4e4e4;
                padding: 2px;
                cursor: pointer;
                position: relative;
                &.selected{
                    background: #d8d8d8 !important;
                };
                .avatar{
                    flex: 1;
                    display: flex;
                    align-items: center;
                    img{
                        width: 45px;
                        height: 45px;
                        border-radius: 100%;
                    }
                };
                .contact{
                    flex: 4;
                    display: flex;
                    overflow: hidden;
                    flex-direction: column;
                    justify-content: center;
                    font-size: 12px;
                    p{
                        margin:0;
                        &.name{
                            font-weight: 700;
                        }
                    }
                };
                .unread{
                    top:16px;
                }
            }
            li:hover{
                background: slateblue;
            }
        }
    }
</style>