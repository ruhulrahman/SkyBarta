<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Job Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
              <li class="breadcrumb-item active">Job</li>
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
                <div class="card" v-for="(job, index) in jobs" :key="index">
            <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="mt-4 mb-4">Company Name: <b class="red">{{ job.company.name }}</b></h1>
                                <h2>Job Title: <b class="green">{{ job.title }}</b></h2>
                                <h3 class="mt-4"><u>Job Description:</u></h3>
                                <p class="text-justify ml-4">{{ job.description }}</p>
                                <h3 class="mt-4 mb-4">Salary Range: {{ job.salary_range }}</h3>
                                <h3 class="mt-4 mb-4">Deadline: {{ job.deadline }}</h3>

                                <hr>

                                <div class="text-center" v-if="job.user.id != user_id">
                                    <address>
                                        Company Name: <b>{{ job.company.name }}</b><br>
                                        Company Email: <b>{{ job.company.email }}</b><br>
                                        Company Address: <b>{{ job.company.address }}</b><br>
                                        Company Creator: <b>{{ job.user.name }}</b>
                                    </address>
                                    <p class="text-center" v-if="job.id==job_applied_id">
                                        <span class="btn btn-primary">Applied</span>
                                    </p>
                                    <p class="text-center" v-else>
                                        <a href="#" @click.prevent="applyJob(job.id)" class="btn btn-success">Apply Job</a>
                                    </p>
                                </div>
                                <div v-else-if="job.user.id == user_id">
                                    <h3 class="text-center" >Appicant's List</h3>
                              <table class="table table-bordered table-striped dataTable table-head-fixed" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row" class="purple">
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(applicant, index) in applicants" :key="index">
                                            <td>{{ index+1 }}</td>
                                            <td><router-link :to="/profile/+applicant.user.slug">{{ applicant.user.name }}</router-link></td>
                                            <td><router-link :to="/profile/+applicant.user.slug">{{ applicant.user.email }}</router-link></td>
                                            <td>{{ applicant.user.mobile }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
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
                editMode:false,
                jobs:{},
                applicants:{},
                job_applied_id:{},
                user_id:{},
                sl:0,
            }
        },
        methods: {
            print(){
                window.print()
            },
            applyJob(job_id){
                swal.fire({
                    title: 'Are you sure to apply this job?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Apply!'
                }).then((result) => {
                    if (result.value) {
                        //send to server
                        axios.get('/api/jobapply/'+job_id)
                        .then(()=>{
                            Fire.$emit('AfterDeleted');
                            swal.fire(
                            'Applied!',
                            'You applied successfully',
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
                    this.loadjobs();
                })
            },
            loadjobs(){
                 axios.get('/api/job/'+this.$route.params.id)
                 .then(response => {
                        this.jobs = response.data;
                    });
                axios.get('/api/jobapplyCheck/'+this.$route.params.id)
                 .then(response => {
                        this.job_applied_id = response.data;
                    });
                axios.get('/api/user-auth-id')
                 .then(response => {
                        this.user_id = response.data;
                    });
            },
            loadApplicants(){
                axios.get('/api/jobapplicants/'+this.$route.params.id)
                 .then(response => {
                        this.applicants = response.data;
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
            this.loadApplicants();
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
