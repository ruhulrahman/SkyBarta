<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Education</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
              <li class="breadcrumb-item active">Education</li>
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
                <h3 class="card-title green">Education</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" @click="addNeweducationModalOpen"> Add New education

                        <i class="fab fa-bandcamp"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="example1_length">

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <button @click="print()" class="print-hide float-right mb-3">Print</button>
                    </div>
                    </div>
                  </div>
                          <div class="row">
                             <div class="col-sm-12">
                              <table id="example1" class="table table-bordered table-striped dataTable table-head-fixed" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row" class="purple">
                        <th>SL</th>
                        <th>Education Name</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd" v-for="(edu, index) in education" :key="index">
                        <td>{{ index+1 }}</td>
                        <td>{{ edu.name }}</td>

                        <td>
                            <a v-on:click.once="doThis"></a>
                            <a href="#" @click="editeducation(edu)" class="btn btn-primary"><i class="fas fa-edit"></i></a> ||
                            <a href="#" @click="deleteeducation(edu.id)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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





        <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

            <form @submit.prevent="editMode ? udpateeducation() : createeducation()" @keydown="form.onKeydown($event)">
            <div class="modal-header  bg-success">
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">New Education</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit Education</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Education Name</label>
                    <input v-model="form.name" type="text"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" @click="resetData">Reset</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
            </div>
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
                editMode:false,
                education:{},
                sl:0,
                form: new Form({
                    id: '',
                    name: '',
                })
            }
        },
        methods: {
            print(){
                window.print()
            },
            // Our method to GET results from a Laravel endpoint
            getResults(page = 1) {
                axios.get('api/education?page=' + page)
                    .then(response => {
                        this.education = response.data;
                    });
            },
            udpateeducation(){
                this.$Progress.start()
                //Server request
                this.form.put('api/education/'+this.form.id)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'education updated successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
            },
            resetData(){
                this.form.reset();
            },
            deleteeducation(id){
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
                        axios.delete('api/education/'+id)
                        .then(()=>{
                            Fire.$emit('AfterDeleted');
                            swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
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
            addNeweducationModalOpen(){
                this.editMode = false;
                this.form.reset()
                $('#addNewModal').modal('show')
            },
            editeducation(education){
                this.editMode = true;
                this.form.reset()
                $('#addNewModal').modal('show')
                this.form.fill(education)
            },
            createeducation(){
                this.$Progress.start()
                this.form.post('api/education')
                .then(()=>{
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'education Created successfully'
                    })
                    this.$Progress.finish()
                    this.form.reset()
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'warning',
                        title: 'education didn\'t created'
                    })
                })

            },
            loadEducation(){
                 axios.get('api/education')
                 .then(response => {
                        this.education = response.data;
                    });
            }
        },
        created() {
            Fire.$on("searching", ()=> {
                let query = this.$parent.search;
                axios.get('api/findeducation?q='+ query)
                .then((data)=>{
                    this.education = data.data;
                })
                .catch(()=>{

                })
            });
            this.loadEducation();
            //setInterval(() => { this.loadEducation(); }, 500);
            Fire.$on('AfterCreated', ()=> {
                this.loadEducation();
            });
            Fire.$on('AfterDeleted', ()=> {
                this.loadEducation();
            });
        },
        mounted() {
            console.log('Component mounted.')
            // Fetch initial results
            //this.getResults();
        }
    }
</script>
