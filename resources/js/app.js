/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('admin-lte');

import Vue from 'vue'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'


//Laravel Gate register for global
import Gate from './Gate'
Vue.prototype.$gate = new Gate(window.user)

// ES6 Modules or TypeScript
//sweetalert2
import Swal from 'sweetalert2'
window.swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.toast = Toast;


//For instant change
window.Fire = new Vue();


//ProgressBar
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '5px'
})


//vform
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


//vue router
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
    { path: '/siteinfo', component: require('./components/SiteInfo.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/home', component: require('./components/Home.vue').default },
    //Job----------
    { path: '/add-company', component: require('./components/job/AddCompany.vue').default },
    { path: '/post-job', component: require('./components/job/PostJob.vue').default },
    { path: '/find-job', component: require('./components/job/FindJob.vue').default },
    { path: '/job-details/:id', component: require('./components/job/JobDetails.vue').default },
    //Friends
    { path: '/findFriends', component: require('./components/friend/FindFriends.vue').default },
    { path: '/friendRequest', component: require('./components/friend/FriendRequest.vue').default },
    { path: '/friendList', component: require('./components/friend/FriendList.vue').default },
    //User Related
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/relation', component: require('./components/Relation.vue').default },
    { path: '/religion', component: require('./components/Religion.vue').default },
    { path: '/gender', component: require('./components/Gender.vue').default },
    { path: '/skill', component: require('./components/job/Skill.vue').default },
    { path: '/role', component: require('./components/Role.vue').default },
    { path: '/user-role', component: require('./components/UserRole.vue').default },
    // { path: '/user-skill', component: require('./components/UserSkill.vue').default },

    { path: '/find-friends', component: require('./components/FindFriends.vue').default },
    { path: '/timeline', component: require('./components/Timeline.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/blood', component: require('./components/Blood.vue').default },
    { path: '/privacy', component: require('./components/Privacy.vue').default },
    { path: '/degree', component: require('./components/Degree.vue').default },
    { path: '/profession', component: require('./components/Profession.vue').default },
    { path: '/major', component: require('./components/Major.vue').default },
    { path: '/post', component: require('./components/Developer.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
    { path: '/major', component: require('./components/Major.vue').default },
    { path: '/division', component: require('./components/location/Division.vue').default },
    { path: '/district', component: require('./components/location/District.vue').default },
    { path: '/thana', component: require('./components/location/Thana.vue').default },
    { path: '/conversation-view', component: require('./components/chattext/Chat.vue').default },
    { path: '/video-chat', component: require('./components/VideoChat.vue').default },
    // { path: '/chat', component: require('./components/Chat.vue').default },
    { path: '/profile/:slug', component: require('./components/Profile.vue').default },
]

let router = new VueRouter({
    routes,
    mode: 'history'
})


Vue.filter('capsText', function(text) {
    return text.toUpperCase() + text.slice(1);
});

Vue.filter('upText', function(text) {
    return text.toUpperCase();
});

Vue.filter('lowText', function(text) {
    return text.toLowerCase();
});

Vue.filter('myDate', function(text) {
    return moment(text).format('MMMM Do YYYY');
});

Vue.filter('localDate', function(text) {
    return moment(text).fromNow();
});


//Popperjs
// import { createPopper } from '@popperjs/core';
// const popcorn = document.querySelector('#popcorn');
// const tooltip = document.querySelector('#tooltip');
// createPopper(popcorn, tooltip, {
//     placement: 'bottom-end',
// });

//laravel vue Pagination
Vue.component('pagination', require('laravel-vue-pagination'));



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('/dashboard', require('./components/Dashboard.vue'));
//Vue.component('/profile', require('./components/Profile.vue'));


//Passposrt component
// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue').default
// );

// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue').default
// );

// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue').default
// );


//My component
Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

// //Chat Component
// Vue.component(
//     'chat-app',
//     require('./components/chattext/Chat.vue').default
// );







const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ""
    },
    methods: {
        searchData: _.debounce(() => {
            Fire.$emit("searching");
        }, 500), //milisecond
        printDoc() {
            window.print();
        }
    },

});