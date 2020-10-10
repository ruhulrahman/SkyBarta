<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Home</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>
              <li class="breadcrumb-item active">Home</li>
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

            <form @submit.prevent="editMode ? udpatePost() : createPost()" @keydown="form.onKeydown($event)">
            <div class="modal-header  bg-success">
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">New Post</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="privacy">Privacy</label>
                    <select v-show="editMode===true" v-model="postform.privacy_id" class="form-control" :class="{ 'is-invalid': postform.errors.has('privacy_id') }">
                        <option v-for="(privacy, index) in privacies" :key="index" :selected="postform.privacy_id===privacy.id" :value="privacy.id" v-text="privacy.name">
                        </option>
                    </select>
                    <select v-show="editMode===false" v-model="postform.privacy_id" class="form-control" :class="{ 'is-invalid': postform.errors.has('privacy_id') }">
                        <option v-for="(privacy, index) in privacies" :key="index" :value="privacy.id" v-text="privacy.name">
                        </option>
                    </select>
                    <has-error :form="postform" field="privacy_id"></has-error>
                </div>
                <div class="form-group">
                    <textarea placeholder="What's on your mind?........" class="form-control" id="bio" rows="2" v-model="postform.desc" :class="{ 'is-invalid': postform.errors.has('desc') }"></textarea>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="getProfilePhoto(this.form.photo)" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ this.form.name }}</h3>

                <router-link to="/find-friends" class="btn btn-primary btn-block">Find Friends</router-link>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
          <div class="col-md-9">



            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">
                    <!-- Post -->    
                    <div class="post">
                      <div class="form-group row">
                        <div class="col-sm-10">
                          <textarea class="form-control" @click="addNewPostModalOpen" placeholder="what's on your mind......"></textarea>
                        </div>
                      </div>
                    </div>
                    <!-- /.post -->  
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>



            <div class="card" v-for="(post, index) in posts" :key="index">
              <div class="card-body" v-if="post.privacy.name!='Private'">
                <div class="tab-content">
                  <div class="tab-pane active">               
                    <!-- Post -->                    
                    <div class="post">
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
                      <input v-model="commentfield" @keydown.enter="send(post.id)" class="form-control form-control-sm" type="text" placeholder="Type a comment">
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
                      
                    </div>
                    <!-- /.post -->
                                       
                  </div>

                  
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
</style>
<script>
    export default {
        data() {
            return {
              like: false,
              commentfield: '',
              editMode:false,
              posts:{},
              privacies:{},
              likes:{},
              comments:{},
              likesCount: 0,
              CommentCount: 0,
              form: new Form({
                  id: '',
                  name: '',
                  email: '',
                  password: '',
                  type: '',
                  bio: '',
                  photo: '',
              }),
              postform: new Form({
                  id: '',
                  desc: '',
                  privacy_id: '',
              }),
              likeform: new Form({
                  id: '',
                  post_id: '',
                  user_id: '',
                  count: '',
              }),
            }
        },
        methods: {
            doLike(post_id){
                axios.get('api/likeCreate/'+post_id)
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
                axios.post('api/comment',{
                    post_id: post_id,
                    comment: this.commentfield
                }).then((response) => {
                    this.loadPosts();
                    this.getCommnets();
                })
                this.commentfield = '';
            },            
            // getCommnets(){
            //     axios.get('api/getCommentCountByPost')
            //         .then(response => {
            //             this.CommentCount = response.data;
            //         });
            // },     
            getLike(postId){
                axios.get('api/getLikeCountByPost/' + postId)
                    .then(response => {
                        this.likesCount = response.data;
                    });
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
            getPosterPhoto(photo){
                if(photo){
                    let pt = "/img/profile/"+photo;
                    return pt;
                }else{               
                    let pt = "img/boy.png";
                    return pt;
                }
            },
            resetData(){
                this.postform.reset();
            },           
            addNewPostModalOpen(){                
                this.editMode = false;
                this.postform.reset()
                $('#addNewModal').modal('show')
            },            
            editPost(posts){
                this.editMode = true;
                this.postform.reset()
                $('#addNewModal').modal('show')
                this.postform.fill(posts)
            },
            createPost(){               
                if(this.postform.desc == ""){
                  return;
                }

                this.$Progress.start()
                this.postform.post('api/post')
                .then(()=>{
                    // Fire.$emit('AfterCreated');
                    this.loadPosts();
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Posted successfully'
                    })
                    this.$Progress.finish()
                    this.postform.reset()
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'warning',
                        title: 'Post didn\'t Completed'
                    })
                })
                
            },            
            udpatePost(){
                this.$Progress.start()
                //Server request
                this.form.put('api/user/'+this.form.id)
                .then(() => {
                    // Fire.$emit('AfterCreated')
                    this.loadPosts();
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'User updated successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
            },
            updateProfile(){
              this.$Progress.start()
                this.form.put("api/profile")
                    .then(()=>{
                      Fire.$emit('AfterCreated');
                      toast.fire({
                        icon: 'success',
                        title: 'Profile updated successfully'
                      })
                      this.$Progress.finish()
                    })
                    .catch(()=>{
                      this.$Progress.fail()
                    });
                
            },
            deleteposts(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //send to server
                        axios.delete('api/post/'+id)
                        .then(()=>{
                            // Fire.$emit('AfterDeleted');
                            this.loadPosts();
                            swal.fire(
                            'Deleted!',
                            'Your post has been deleted.',
                            'success'
                            )
                        })
                        .catch(()=>{
                            swal.fire(
                                'Failed!',
                                'Something wrong here.',
                                'error'
                                )
                        })
                    }
                })
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
              // axios.get('api/getFollowPost')
              axios.get('api/post')
              .then(response => {
                    this.posts = response.data;
                });
            },
            loadLikes(){
              axios.get('api/like')
              .then(response => {
                    this.likes = response.data;
                });
            },
            loadprivacies(){
              axios.get('api/privacy')
              .then(response => {
                    this.privacies = response.data;
                });
            },
            loadProfileData(){
              axios.get('api/timeline').then(({ data }) => { this.form.fill(data) });
            }
        },
        created() {
          // setInterval(() => { this.loadPosts(); }, 500);
            this.loadProfileData();            
            this.loadPosts();
            this.loadLikes();
            this.loadprivacies();


            Fire.$on('AfterCreated', ()=> {
                this.loadPosts();
            });
            Fire.$on('AfterDeleted', ()=> {
                this.loadPosts();
            });

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
