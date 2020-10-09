<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">District</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
              <li class="breadcrumb-item active">District</li>
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
                <h3 class="card-title green">District</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" @click="addNewdistrictsModalOpen"> Add New District

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
                        <th>District Name</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd" v-for="(district, index) in districts" :key="index">
                        <td>{{ index+1 }}</td>
                        <td>{{ district.name }}</td>

                        <td>
                            <a href="#" @click="editdistricts(district)" class="btn btn-primary"><i class="fas fa-edit"></i></a> ||
                            <a href="#" @click="deletedistricts(district.id)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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

            <form @submit.prevent="editMode ? udpatedistrict() : createdistrict()" @keydown="form.onKeydown($event)">
            <div class="modal-header  bg-success">
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">New district</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit district</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Select Division</label>
                    <select v-show="editMode===true" v-model="form.division_id" class="form-control" :class="{ 'is-invalid': form.errors.has('division_id') }">
                        <option v-for="(division, index) in divisions" :key="index" :selected="form.division_id===division.id" :value="division.id" v-text="division.name">
                        </option>
                    </select>

                    <select v-show="editMode===false" v-model="form.division_id" class="form-control" :class="{ 'is-invalid': form.errors.has('division_id') }">
                        <option selected="selected" disabled="disabled">Select Division</option>
                        <option v-for="(division, index) in divisions" :key="index" :value="division.id" v-text="division.name">
                        </option>
                    </select>
                    <has-error :form="form" field="division_id"></has-error>
                </div>
                <div class="form-group">
                    <label>District Name</label>
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
                divisions:{},
                districts:{},
                sl:0,
                form: new Form({
                    id: '',
                    name: '',
                    division_id: '',
                })
            }
        },
        methods: {
            print(){
                window.print()
            },
            // Our method to GET results from a Laravel endpoint
            getResults(page = 1) {
                axios.get('api/district?page=' + page)
                    .then(response => {
                        this.districts = response.data;
                    });
            },
            udpatedistrict(){
                this.$Progress.start()
                //Server request
                this.form.put('api/district/'+this.form.id)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'districts updated successfully'
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
            deletedistricts(id){
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
                        this.form.delete('api/district/'+id)
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
            addNewdistrictsModalOpen(){
                axios.get('api/division')
                 .then(response => {
                        this.divisions = response.data;
                    });
                this.editMode = false;
                this.form.reset()
                $('#addNewModal').modal('show')
            },
            editdistricts(districts){
                axios.get('api/division')
                 .then(response => {
                        this.divisions = response.data;
                    });
                this.editMode = true;
                this.form.reset()
                $('#addNewModal').modal('show')
                this.form.fill(districts)
            },
            createdistrict(){
                this.$Progress.start()
                this.form.post('api/district')
                .then(()=>{
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Districts Created successfully'
                    })
                    this.$Progress.finish()
                    this.form.reset()
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'warning',
                        title: 'Districts didn\'t created'
                    })
                })

            },
            loaddistricts(){
                 axios.get('api/district')
                 .then(response => {
                        this.districts = response.data;
                    });
            }
        },
        created() {
            Fire.$on("searching", ()=> {
                let query = this.$parent.search;
                axios.get('api/finddistricts?q='+ query)
                .then((data)=>{
                    this.districts = data.data;
                })
                .catch(()=>{

                })
            });
            this.loaddistricts();
            //setInterval(() => { this.loaddistricts(); }, 500);
            Fire.$on('AfterCreated', ()=> {
                this.loaddistricts();
            });
            Fire.$on('AfterDeleted', ()=> {
                this.loaddistricts();
            });
        },
        mounted() {
            console.log('Component mounted.')
            // Fetch initial results
            //this.getResults();
        }
    }
</script>
