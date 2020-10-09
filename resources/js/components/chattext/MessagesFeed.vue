<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :key="message.id" :class="`message ${message.to == contact.id ? 'sent' : 'received'}`">
                <div class="text">
                    {{ message.text }}
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
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
            scrollToBottom(){
                setTimeout(()=>{
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                },50);
            }
        },
        watch:{
            contact(contact){
                this.scrollToBottom();
            },
            messages(messages){
                this.scrollToBottom();
            }
        },
    }
</script>

<style lang="scss">
    .feed::-webkit-scrollbar {
        width: 8px;
    }

    .feed::-webkit-scrollbar-track {
        box-shadow: inset 0px 0px 4px rgb(3 255 46);
    }

    .feed::-webkit-scrollbar-thumb {
        background-color: #38C172;
        outline: 1px solid slategrey;
        border-radius: 50px;

    }
    .feed{
        height: 100%;
        max-height: 370px;
        overflow: scroll;
        overflow-x: hidden;
        background: #e6e6e6;
        ul{
            list-style-type: none;
            padding: 5px;
            li{
                &.message{
                    margin: 10px 0px;
                    width: 100%; 
                    .text{
                        max-width: 400px;
                        border-radius: 5px;
                        display: inline-block;
                        padding: 10px;                        
                        color: white;
                    }                 
                }
                &.received{
                    text-align: left;
                    .text{
                        background: #757272;
                        border-radius: 5px 30px 30px 5px;
                    }
                }
                &.sent{
                    text-align: right;
                    .text{
                        background: #38C172;
                        border-radius: 30px 5px 5px 30px;
                    }
                }
            }
        }
    }
</style>