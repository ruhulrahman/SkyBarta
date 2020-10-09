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
          <div class="col-md-3" v-for="(friend, index) in friends" :key="index">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="getProfilePhoto()" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ friend.name }}</h3>

                <button @click="ConfirmFndRequest(friend.fnd_id)" class="btn-xm btn-primary"><b>Confirm Request</b></button>
                <button @click="CancelFndRequest(friend.fnd_id)" class="btn-xm btn-danger"><b>Cancel</b></button>
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
            }
        },
        methods: {
            ConfirmFndRequest(friend_id){
              this.$Progress.start()
                axios.get('api/confirmRequest/'+friend_id)
                .then(()=>{
                    Fire.$emit('AfterCreated');
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'You Confirmed Request'
                    })
                    this.$Progress.finish()
                })
            },
            getProfilePhoto(){
               let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+this.form.photo;
                return photo;
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
                this.form.put('api/friend/'+this.form.id)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'friend updated successfully'
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
            CancelFndRequest(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel Request!'
                }).then((result) => {
                    if (result.value) {
                        //send to server
                        axios.delete('api/friend/'+id)
                        .then(()=>{
                            Fire.$emit('AfterDeleted');
                            swal.fire(
                            'Canceled!',
                            'You have canceled request.',
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
            loadProfileData(){
              axios.get('api/profile').then(({ data }) => { this.form.fill(data) });
            },
            friendRequest(){
              axios.get('api/friendRequest')
              .then(response => {
                    this.friends = response.data;
                });
            }
        },
        created() {
          // setInterval(() => { this.loadPosts(); }, 500);
            this.loadProfileData();
            this.friendRequest();


            Fire.$on('AfterCreated', ()=> {
                this.friendRequest();
            });
            Fire.$on('AfterDeleted', ()=> {
                this.friendRequest();
            });

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
