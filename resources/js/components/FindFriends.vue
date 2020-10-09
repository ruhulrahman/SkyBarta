<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    
            <div class="card-header print-hide">
                <h3 class="card-title green">Users</h3>
                

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label>Dropdown Search By Profession <i class="fas fa-briefcase green" aria-hidden="true"></i></label>
                        <select @change='getUserByProfesssion()' v-model="professionID" class="form-control">
                            <option selected="selected" disabled="disabled">Select profession</option>
                            <option value="all">All Professional Member</option>
                            <option v-for="(profession, index) in professions" :key="index" :value="profession.id" v-text="profession.name">
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label>Dropdown Search By Blood  <i class="nav-icon fas fa-tint red"></i></label>
                        <select @change='getUserByBlood()' v-model="bloodID" class="form-control">
                            <option selected="selected" disabled="disabled">Select blood</option>
                            <option value="all">All blood Member</option>
                            <option v-for="(blood, index) in bloods" :key="index" :value="blood.id" v-text="blood.name">
                            </option>
                        </select>
                    </div>
                    </div>
                  </div>
                          <div class="row">
                             <div class="col-sm-12">
                              <table id="example1" class="table table-bordered table-striped dataTable table-head-fixed" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row" class="purple">
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd" v-for="(user, index) in users" :key="index">
                        <td><router-link :to="/profile/+user.slug"><img class="profile-user-img img-fluid mb-1 img-circle" :src="getProfilePhoto(user.photo)" alt=""></router-link></td>
                        <td><router-link :to="/profile/+user.slug">{{ user.name }}</router-link></td>
                        <td>{{ user.mobile }}</td>
                        <td>{{ user.email }}</td>                        
                        <td>
                            <a href="#" v-if="followings.following_id != user.id" @click.prevent="followCreate(user.id)" class="btn btn-primary btn-block"><b>Follow</b></a>
                            <a href="#" v-if="followings.following_id == user.id" @click.prevent="followCreate(user.id)" class="btn btn-danger btn-block"><b>Unfollow</b></a>
                        </td>
                    </tr>

                </tbody>
              </table>
                  
              
              </div>
              </div>
              
                </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>


    </div>
    
    </section>

    
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    export default {
        data(){
            return{
                followings: '',
                isAuth: '',
                professionID: 0,
                bloodID: 0,
                users:{},
                professions:{},
                bloods:{},
            }
        },
        methods: {
            print(){
                window.print()
            },
            followCreate(){
                axios.get('/api/followerCreate/'+this.$route.params.slug)
                .then((response) => {
                    this.followerCheck();
                    this.follower();
                })
            },
            getProfilePhoto(photo){
                if(photo){
                    let pt = "/img/profile/"+photo;
                    return pt;
                }else{               
                    let pt = "img/boy.png";
                    return pt;
                }
            },
            // Our method to GET results from a Laravel endpoint
            
            // loadUsers(){
            //     axios.get('api/user').then(({ data }) => { this.users = data })
            // },
            loadData(){
              axios.get('api/profession')
              .then(response => {
                    this.professions = response.data;
                });

              axios.get('api/blood')
              .then(response => {
                    this.bloods = response.data;
                });
            },
            getUserByProfesssion(){
                if(this.professionID == 'all'){
                    axios.get('api/user')
                    .then(response => {
                        this.users = response.data;
                    });
                }else{
                    axios.get('api/findUserByprofession/'+this.professionID)
                    .then(response => {
                        this.users = response.data;
                    });
                }
            },
            getUserByBlood(){
                if(this.bloodID == 'all'){
                    axios.get('api/user')
                    .then(response => {
                        this.users = response.data;
                    });
                }else{
                    axios.get('api/findUserByBlood/'+this.bloodID)
                    .then(response => {
                        this.users = response.data;
                    });
                }
            },
            authData(){
              axios.get('api/authInfo')
              .then(response => {
                    this.isAuth = response.data;
                });
            },
            followerCheck(){
              axios.get('api/getfollow')
              .then(response => {
                    this.followings = response.data;
                });
            },
        },
        created() {
            Fire.$on("searching", ()=> {
                let query = this.$parent.search;
                axios.get('api/findPeople?q='+ query)
                .then((data)=>{
                    this.users = data.data;
                })
                .catch(()=>{

                })
            });
            // this.loadUsers();

            this.loadData();
            this.followerCheck();
            this.authData();
        },
        mounted() {
            console.log('Component mounted.')
            // Fetch initial results
            //this.getResults();
        }
    }
</script>
