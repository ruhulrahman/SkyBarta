<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Find Friends</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
              
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

        <!-- Modal -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3" v-for="(user, index) in users" :key="index">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="getProfilePhoto(user.photo)" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ user.name }}</h3>
                <button @click="addFriend(user.id)"  class="btn btn-primary btn-block"><b>Add Friend</b></button>


                            
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    export default {
        data() {
            return {
              editMode:false,
              posts:{},
              users:{},
              friends:{},
              likeCount: 0,
              form: new Form({
                  id: '',
                  name: '',
                  photo: '',
              }),
              friendform: new Form({
                  id: '',
                  user_id: '',
                  request_id: '',
                  accept_id: '',
              }),
            }
        },
        methods: {
            addFriend(user_id){
              this.$Progress.start()
                axios.get('api/addFriend/'+user_id)
                .then(()=>{
                    Fire.$emit('AfterCreated');
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'You send Friend Request'
                    })
                    this.$Progress.finish()
                })
            },
            getProfilePhoto(photo){
              let pt;
                if(photo==""){
                    pt = "img/profile/boy.png";
                }else{
                    pt = "img/profile/"+photo;
                }
                return pt;
              //  let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+this.form.photo;
              //   return photo;
            },
            getPosterPhoto(photo){
              let pt = "img/profile/"+photo;
                return pt;
            },      
            editPost(posts){
                this.editMode = true;
                this.form.reset()
                $('#addNewModal').modal('show')
                this.form.fill(posts)
            },
            createPost(){                
                this.$Progress.start()
                this.postform.post('api/post')
                .then(()=>{
                    Fire.$emit('AfterCreated');
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
                    Fire.$emit('AfterCreated')
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
                        this.postform.delete('api/post/'+id)
                        .then(()=>{
                            Fire.$emit('AfterDeleted');
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
            loadPosts(){
              axios.get('api/post')
              .then(response => {
                    this.posts = response.data;
                });
            },
            loadProfileData(){
              axios.get('api/timeline').then(({ data }) => { this.form.fill(data) });
            },
            loadFriends(){
              // axios.get('api/friend')
              // .then(response => {
              //       this.friends = response.data;
              //   });
            },
            loadFindFriends(){
              axios.get('api/findFriend')
              .then(response => {
                    this.users = response.data;
                });
            }
        },
        created() {
          // setInterval(() => { this.loadPosts(); }, 500);
            this.loadProfileData();            
            this.loadPosts();
            this.loadFindFriends();
            this.loadFriends();


            Fire.$on('AfterCreated', ()=> {
                this.loadPosts();
                this.loadProfileData();
                this.loadFriends();
            });
            Fire.$on('AfterDeleted', ()=> {
                this.loadPosts();
                this.loadProfileData();
                this.loadFriends();
            });

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
