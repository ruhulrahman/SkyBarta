<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

        <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

            <form @submit.prevent="editMode ? updatePost() : createPost()" @keydown="form.onKeydown($event)">
            <div class="modal-header  bg-success">
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">New User</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea placeholder="What's on your mind?........" class="form-control" rows="2" v-model="postform.desc" :class="{ 'is-invalid': postform.errors.has('desc') }"></textarea>
                    <has-error :form="postform" field="desc"></has-error>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" @click="resetData">Reset</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Post</button>
            </div>
            </form>
            </div>
        </div>
        </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" v-for="(user, index) in users" :key="index">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="getProfilePhoto(user.photo)" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ user.name }}</h3>

                <p v-if="form.quote!=null" class="orange text-center"><q><i>{{ user.quote }}</i></q></p>

                <ul class="list-group mb-3">                  
                  <!-- <li class="list-group-item">
                    <b>Friends</b> <a href="" class="float-right">13,287</a>
                  </li> -->
                  <li class="list-group-item">
                    <b>Followers</b> <a href="" class="float-right">{{ followerCount }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a href="" class="float-right">{{ followingCount }}</a>
                  </li>
                </ul>
                
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b class="text-green">Date of Birth <i class="fas fa-calendar-day"></i></b> <a class="float-right">{{ user.dob }}</a>
                  </li>
                  <li class="list-group-item" >
                      <b class="text-danger">Lives in <i class="fas fa-map-marker"></i></b>
                      <a v-for="(usrloc, index) in userlocations" :key="index" class="float-right"> 
                        <span v-if="usrloc.type=='lives'">
                          <span v-if="usrloc.village_name!=null">{{ usrloc.village_name+", " }}</span>
                          <span v-if="usrloc.union_name!=null">{{ usrloc.union_name+", " }}</span>

                          <span v-if="usrloc.village_name==null">{{ usrloc.thana.name+", "+usrloc.district.name }}</span>
                          <span v-else>{{ usrloc.thana.name }}</span>
                        </span>
                      </a>
                  </li>
                  <li class="list-group-item" >
                      <b class="text-blue">Home Town <i class="fas fa-map-marker"></i></b>
                      <a v-for="(usrloc, index) in userlocations" :key="index" class="float-right"> 
                        <span v-if="usrloc.type=='hometown'">
                          <span v-if="usrloc.village_name!=null">{{ usrloc.village_name+", " }}</span>
                          <span v-if="usrloc.union_name!=null">{{ usrloc.union_name+", " }}</span>

                          <span v-if="usrloc.village_name==null">{{ usrloc.thana.name+", "+usrloc.district.name }}</span>
                          <span v-else>{{ usrloc.thana.name }}</span>
                        </span>
                      </a>
                  </li>
                  <li class="list-group-item">
                    <b>Gender</b> 
                    <a class="float-right">{{ user.gender.name }}</a>
                  </li>
                  <li class="list-group-item" v-if="user.relation_id!=null">
                    <b>Relation <i class="fa fa-heart pink"></i></b>
                    <a class="float-right">{{ user.relation.name }}</a>
                  </li>
                  <li class="list-group-item" v-if="user.religion_id!=null">
                    <b>Religion</b> 
                    <a class="float-right">{{ user.religion.name }}</a>
                  </li>
                  <li class="list-group-item" v-if="user.hobby!=null">
                    <b>Hobby</b> 
                    <a class="float-right">{{ user.hobby }}</a>
                  </li>

                  <li class="list-group-item" v-if="user.blood_id!=null">
                    <b>Blood <i class="nav-icon fas fa-tint red"></i></b> 
                    <a class="float-right">{{ user.blood.name }}</a>
                  </li>

                  <li class="list-group-item" v-if="user.profession_id!=null">
                    <b>Profession</b>
                     <a class="float-right" v-if="user.profession_id!=null">{{ user.profession.name }}</a>
                  </li>
                </ul>
                <a href="#" v-if="isFollower==false && isAuth==false" @click.prevent="followCreate(user.id)" class="btn btn-primary btn-block"><b>Follow</b></a>
                <a href="#" v-if="isFollower==true && isAuth==false" @click.prevent="followCreate(user.id)" class="btn btn-danger btn-block"><b>Unfollow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Biography</strong>
                <p class="text-muted">
                  {{ user.aboutme }}
                </p>

                <hr>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->





          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link " href="#profileInfo" data-toggle="tab">Profile Info</a></li>
                  <li class="nav-item"><a class="nav-link " href="#location" data-toggle="tab">Location</a></li>
                  <li class="nav-item"><a class="nav-link" href="#education" data-toggle="tab">Education</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">            
                    <!-- Post -->                    
                    <div class="post" v-for="(post, post_id) in posts" :key="post_id">
                      <div  v-if="post.privacy.name!='Private'">
                      <div class="user-block">
                        <router-link :to="/profile/+post.user.slug">
                          <img class="img-circle img-bordered-sm" :src="getPosterPhoto(post.user.photo)" alt="user image">
                        </router-link>
                        <span class="username">
                          <router-link :to="/profile/+post.user.slug">{{ post.user.name }}</router-link>
                        </span>
                        <span class="description">Shared publicly - {{ post.created_at | localDate }}</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        {{ post.desc }}
                      </p>
<hr>
                      <p>
                        <a href="#" @click.prevent="doLike(post.id)" class="link-black text-sm">
                              <span v-if="post.likes.length == 0">                                    
                                <i class="fa fa-thumbs-up" ></i> Like
                              </span>
                              <span v-else class="blue">                                    
                                <i class="fa fa-thumbs-up" ></i>Like
                              </span>
                              ({{ post.likes.length }})
                        </a>
                         
                        <span class="float-right">
                          <a href="" @click.prevent="getCommnets(post.id)" class="link-black text-sm">
                            <i class="fa fa-comments mr-1"></i> Comments ({{ post.comments.length }})
                          </a>
                        </span>
                      </p>
               <hr>       
                      
                      
                      <ul class="comment" v-for="(comment, index) in post.comments" :key="index">
                        <li>
                          <div class="user-block">
                            <router-link :to="/profile/+comment.user.slug">
                            <img class="img-circle img-bordered-sm" :src="getPosterPhoto(comment.user.photo)" alt="user image">
                            </router-link>
                            <span class="username">
                            <router-link :to="/profile/+comment.user.slug">{{ comment.user.name }}</router-link>
                            </span>
                            <span class="description">{{ " "+ comment.comment }}</span> 
                          </div>
                        </li>
                      </ul>

                      <input v-model="commentfield" @keydown.enter="send(post.id)" class="form-control form-control-sm" type="text" placeholder="Type a comment">

                      </div>
                    </div>
                    <!-- /.post -->

                  </div>

                  <!-- /.tab-pane -->


                  <!--Profile Info -->
                  <div class="tab-pane" id="profileInfo">
                    
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ID</label>
                        <div class="col-sm-10">
                          <span>{{ user.slug }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <span>{{ user.email }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                          <span>{{ user.mobile }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-10">
                          <span>{{ user.dob }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Monthly Income</label>
                        <div class="col-sm-10">
                          <span>{{ user.m_income }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Family Members</label>
                        <div class="col-sm-10">
                          <span>{{ user.fam_members }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Hobby</label>
                        <div class="col-sm-10">
                          <span>{{ user.hobby }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">About Me</label>
                        <div class="col-sm-10">
                          <span>{{ user.aboutme }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Quote</label>
                        <div class="col-sm-10">
                          <span>{{ user.quote }}</span>
                        </div>
                      </div>





                  </div>
                  <!-- /.Profile Info -->




                  <div class="tab-pane" id="location">

                    <table id="example2" class="table table-bordered table-striped dataTable table-head-fixed" role="grid" aria-describedby="example2_info">
                      <thead>
                          <tr role="row" class="purple">
                              <th>Address Type: </th>
                              <th>Village: </th>
                              <th>Union</th>
                              <th>Thana</th>
                              <th>District</th>
                              <th>Division</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr role="row" class="odd" v-for="(usrloc, index) in userlocations" :key="index">
                              <td>{{ usrloc.type | capsText }}</td>
                              <td>{{ usrloc.village_name }}</td>
                              <td>{{ usrloc.union_name }}</td>
                              <td>{{ usrloc.thana.name }}</td>
                              <td>{{ usrloc.district.name }}</td>
                              <td>{{ usrloc.division.name }}</td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="education">
              <table id="example1" class="table table-bordered table-striped dataTable table-head-fixed" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row" class="purple">
                        <th>Degree Name</th>
                        <th>Major</th>
                        <th>Passing Year</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd" v-for="(ursedu, index) in usereducations" :key="index">
                        <td>{{ ursedu.degree.name }}</td>
                        <td>{{ ursedu.major.name }}</td>
                        <td>{{ ursedu.passing_year }}</td>
                    </tr>
                </tbody>
              </table>
                  </div>
                  <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          






          
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>














  </div>
  <!-- /.content-wrapper -->
</template>
<style>
  .comment{
    list-style-type: none;
    margin: 0;
    padding: 0;
    margin-top: 10px;;
  }
  .description{
    color:black;
  }
  .likes{
    color: slateblue;
  }
  .dropdown-menu.show {
    transform: translate3d(-109px, 26px, 0px) !important;
  }
</style>
<script>
    export default {
        data() {
            return {
              isFollower: '',
              isAuth: '',
              editMode:false,
              userlocations:{},
              usereducations:{},
              posts:{},
              users:{},
              likes:{},
              roles:{},
              genders:{},
              religions:{},
              relations:{},
              comments:{},
              followerCount: 0,
              followingCount: 0,
              likesCount: 0,
              CommentCount: 0,
              commentfield: '',
              form: new Form({
                  id: '',
                  name: '',
                  email: '',
                  slug: '',
                  mobile: '',
                  password: '',
                  role_id: '',
                  aboutme: '',
                  m_income: '',
                  fam_members: '',
                  gender_id: '',
                  dob: '',
                  photo: '',
                  hobby: '',
                  religion_id: '',
                  relation_id: '',
                  quote: '',
                  blood_id: '',
                  profession_id: '',
              }),
              postform: new Form({
                  id: '',
                  desc: '',
              }),
              followform: new Form({
                  id: '',
                  follower_id: '',
                  following_id: '',
              }),
            }
        },
        methods: {
          doLike(post_id){
                axios.get('/api/likeCreate/'+post_id)
                .then((response) => {
                    this.likes = response.data;
                    this.loadPosts();
                })
            },
            send(post_id){
                event.preventDefault()
                
                if(this.commentfield == ''){
                    return;
                }
                // this.$emit('send', this.commentfield);
                axios.post('/api/comment',{
                    post_id: post_id,
                    comment: this.commentfield
                }).then((response) => {
                    this.loadPosts();
                })
                this.commentfield = '';
            },
            followCreate(){
                axios.get('/api/followerCreate/'+this.$route.params.slug)
                .then((response) => {
                    this.followerCheck();
                    this.follower();
                })
            },
            userAsFollower(follower_id){
                // axios.get('/api/follow/'+follower_id)
                //     .then(response => {
                //     });
            },
            getLike(postId){
                axios.get('/api/getLikeCountByPost/' + postId)
                    .then(response => {
                        this.likesCount = response.data;
                    });
            },
            loadLikes(){
              axios.get('/api/like')
              .then(response => {
                    this.likes = response.data;
                });
            },
            getProfilePhoto(photo){
              if(photo){
                    let pt = "/img/profile/"+photo;
                    return pt;
                }else{               
                    let pt = "/img/boy.png";
                    return pt;
                }
            },
            getPosterPhoto(photo){
              if(photo){
                    let pt = "/img/profile/"+photo;
                    return pt;
                }else{               
                    let pt = "/img/boy.png";
                    return pt;
                }
            },
            resetData(){
                this.form.reset();
                this.postform.reset();
            },     
            addNewPostModalOpen(){                
                this.editMode = false;
                this.postform.reset()
                $('#addNewModal').modal('show')
            },
            previewProfilePhoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                console.log(file);
                if(file['size'] < 2097152){
                  reader.onloadend = (file) => {
                      this.form.photo = reader.result;
                  }
                  reader.readAsDataURL(file);
                }else{
                  swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'File size more than 2MB!',
                  })
                }
            },
            loadPosts(){
              // axios.get('api/postByAuth')
              // .then(response => {
              //       this.posts = response.data;
              //   });
            },
            loadProfileData(){
              let slug = this.$route.params.slug;
              axios.get('/api/usersInfo/'+ slug)
              .then(response => {
                    this.users = response.data;
                });

              //user location
              axios.get('/api/userlocation/'+ slug)
              .then(response => {
                    this.userlocations = response.data;
                });

              //user education
              axios.get('/api/usereducation/'+ slug)
              .then(response => {
                    this.usereducations = response.data;
                });

                
              //user post
              axios.get('/api/userpost/'+ slug)
              .then(response => {
                    this.posts = response.data;
                });
            },
            loadPosts(){
               //user post
              axios.get('/api/userpost/'+ this.$route.params.slug)
              .then(response => {
                    this.posts = response.data;
                });

            },
            follower(){
              axios.get('/api/followerCount/'+this.$route.params.slug)
              .then(response => {
                    this.followerCount = response.data;
                });
            },
            followerCheck(){
              axios.get('/api/getFollower/'+this.$route.params.slug)
              .then(response => {
                    this.isFollower = response.data;
                });
            },
            following(){
              axios.get('/api/followingCount/'+this.$route.params.slug)
              .then(response => {
                    this.followingCount = response.data;
                });
            },
            authData(){
              axios.get('/api/authInfo/'+this.$route.params.slug)
              .then(response => {
                    this.isAuth = response.data;
                });
            },
            gendersData(){
              axios.get('/api/gender')
              .then(response => {
                    this.genders = response.data;
                });
            },
            relationsData(){
              axios.get('/api/relation')
              .then(response => {
                    this.relations = response.data;
                });
            },
            religionsData(){
              axios.get('/api/religion')
              .then(response => {
                    this.religions = response.data;
                });
            }
        },
        created() {
          // setInterval(() => { this.loadPosts(); }, 500);
            this.loadProfileData();            
            this.loadPosts();
            this.loadLikes();
            this.follower();
            this.following();
            this.followerCheck();
            this.authData();
            this.gendersData();
            this.relationsData();
            this.religionsData();
            
            // this.getProfilePhoto(photo);

            Fire.$on('AfterCreated', ()=> {
                this.loadPosts();
                this.loadProfileData();
            });
            Fire.$on('AfterDeleted', ()=> {
                this.loadPosts();
            });

        },
        mounted() {
          
        }
    }
</script>
