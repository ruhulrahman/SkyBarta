<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Post Job</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
              <li class="breadcrumb-item active">Post Job</li>
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
                <h3 class="card-title green">Post Jobs</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" @click="addNewjobModalOpen"> Add New Job

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
                        <th>Company Name</th>
                        <th>Job Title</th>
                        <th>Job Description</th>
                        <th>Salary Range</th>
                        <th>Deadline</th>
                        <th>Category</th>
                        <th>Privacy</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd" v-for="(job, index) in jobs" :key="index">
                        <td>{{ index+1 }}</td>
                        <td>{{ job.company.name }}</td>
                        <td>{{ job.title }}</td>
                        <td>{{ job.description }}</td>
                        <td>{{ job.salary_range }}</td>
                        <td>{{ job.deadline }}</td>
                        <td>{{ job.category.name }}</td>
                        <td><span class="btn btn-success">{{ job.privacy.name }}</span></td>

                        <td>
                            <router-link :to="/job-details/+job.id"><i class="fas fa-eye"></i></router-link>
                            <a href="#" @click.prevent="editjob(job)" class="btn btn-primary"><i class="fas fa-edit"></i></a> ||
                            <a href="#" @click.prevent="deletejob(job.id)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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

            <form @submit.prevent="editMode ? udpatejob() : createjob()" @keydown="form.onKeydown($event)">
            <div class="modal-header  bg-success">
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">New job</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Compnay Name</label>
                    <select v-show="editMode===true" v-model="form.company_id" class="form-control" :class="{ 'is-invalid': form.errors.has('company_id') }">
                        <option v-for="(company, index) in companies" :key="index" :selected="form.company_id===company.id" :value="company.id" v-text="company.name">
                        </option>
                    </select>

                    <select v-show="editMode===false" v-model="form.company_id" class="form-control" :class="{ 'is-invalid': form.errors.has('company_id') }">
                        <option selected="selected" disabled="disabled">Select company</option>
                        <option v-for="(company, index) in companies" :key="index" :value="company.id" v-text="company.name">
                        </option>
                    </select>
                    <has-error :form="form" field="company_id"></has-error>
                </div>
                <div class="form-group">
                    <label>Job Title</label>
                    <input v-model="form.title" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                    <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                    <label>Job Description</label>
                    <textarea class="form-control" rows="6" v-model="form.description" placeholder="Job description...." :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                    <has-error :form="form" field="description"></has-error>
                </div>
                <div class="form-group">
                    <label>Salary Range</label>
                    <input v-model="form.salary_range" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('salary_range') }">
                    <has-error :form="form" field="salary_range"></has-error>
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input v-model="form.deadline" type="date" class="form-control" :class="{ 'is-invalid': form.errors.has('deadline') }">
                    <has-error :form="form" field="deadline"></has-error>
                </div>
                <div class="form-group">
                    <label>Job Category</label>
                    <select v-show="editMode===true" v-model="form.category_id" class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                        <option v-for="(category, index) in categories" :key="index" :selected="form.category_id===category.id" :value="category.id" v-text="category.name">
                        </option>
                    </select>

                    <select v-show="editMode===false" v-model="form.category_id" class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                        <option selected="selected" disabled="disabled">Select category</option>
                        <option v-for="(category, index) in categories" :key="index" :value="category.id" v-text="category.name">
                        </option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>
                <div class="form-group">
                    <label>Job Privacy</label>
                    <select v-show="editMode===true" v-model="form.privacy_id" class="form-control" :class="{ 'is-invalid': form.errors.has('privacy_id') }">
                        <option v-for="(privacy, index) in privacies" :key="index" :selected="form.privacy_id===privacy.id" :value="privacy.id" v-text="privacy.name">
                        </option>
                    </select>

                    <select v-show="editMode===false" v-model="form.privacy_id" class="form-control" :class="{ 'is-invalid': form.errors.has('privacy_id') }">
                        <option selected="selected" disabled="disabled">Select Privacy</option>
                        <option v-for="(privacy, index) in privacies" :key="index" :value="privacy.id" v-text="privacy.name">
                        </option>
                    </select>
                    <has-error :form="form" field="privacy_id"></has-error>
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
                jobs:{},
                categories:{},
                privacies:{},
                companies:{},
                sl:0,
                form: new Form({
                    id: '',
                    company_id: '',
                    title: '',
                    description: '',
                    salary_range: '',
                    deadline: '',
                    category_id: '',
                    privacy_id: '',
                })
            }
        },
        methods: {
            print(){
                window.print()
            },
            // Our method to GET results from a Laravel endpoint
            getResults(page = 1) {
                axios.get('api/job?page=' + page)
                    .then(response => {
                        this.jobs = response.data;
                    });
            },
            udpatejob(){
                this.$Progress.start()
                //Server request
                this.form.put('api/job/'+this.form.id)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'job updated successfully'
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
            deletejob(id){
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
                        axios.delete('api/job/'+id)
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
            addNewjobModalOpen(){
                this.editMode = false;
                this.form.reset()
                $('#addNewModal').modal('show')
            },
            editjob(job){
                this.editMode = true;
                this.form.reset()
                $('#addNewModal').modal('show')
                this.form.fill(job)
            },
            createjob(){
                this.$Progress.start()
                this.form.post('api/job')
                .then(()=>{
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'job Created successfully'
                    })
                    this.$Progress.finish()
                    this.form.reset()
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'warning',
                        title: 'job didn\'t created'
                    })
                })

            },
            loadjobs(){
                 axios.get('api/job')
                 .then(response => {
                        this.jobs = response.data;
                    });
            },
            loadjobCategories(){
                 axios.get('api/profession')
                 .then(response => {
                        this.categories = response.data;
                    });
            },
            loadPrivacies(){
                 axios.get('api/privacy')
                 .then(response => {
                        this.privacies = response.data;
                    });
            },
            loadCompanies(){
                 axios.get('api/company')
                 .then(response => {
                        this.companies = response.data;
                    });
            }
        },
        created() {
            Fire.$on("searching", ()=> {
                let query = this.$parent.search;
                axios.get('api/findjob?q='+ query)
                .then((data)=>{
                    this.jobs = data.data;
                })
                .catch(()=>{

                })
            });
            this.loadjobs();
            this.loadjobCategories();
            this.loadPrivacies();
            this.loadCompanies();
            //setInterval(() => { this.loadjobs(); }, 500);
            Fire.$on('AfterCreated', ()=> {
                this.loadjobs();
            });
            Fire.$on('AfterDeleted', ()=> {
                this.loadjobs();
            });
        },
        mounted() {
            console.log('Component mounted.')
            // Fetch initial results
            //this.getResults();
        }
    }
</script>
