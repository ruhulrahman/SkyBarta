<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Site info</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
              <li class="breadcrumb-item active">Site info</li>
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
                <h3 class="card-title green">Site info Update</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                          <div class="row">
                             <div class="col-sm-12">
          <form @submit.prevent="udpatesite_info()" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                <div class="form-group">
                    <label>Site Title</label>
                    <input v-model="form.title" type="text" name="title"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                    <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                    <label>Site Short Name</label>
                    <input v-model="form.short_name" type="text" name="short_name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('short_name') }">
                    <has-error :form="form" field="short_name"></has-error>
                </div>
                <div class="form-group">
                    <label>Site Description</label>
                    <input v-model="form.description" type="text" name="description"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                    <has-error :form="form" field="description"></has-error>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
            </form>


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

            <form @submit.prevent="udpatesite_info()" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                <div class="form-group">
                    <label>site_info Name</label>
                    <input v-model="form.name" type="text" name="name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
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
                siteinfo:{},
                form: new Form({
                    id: '',
                    title: '',
                    short_name: '',
                    description: '',
                })
            }
        },
        methods: {
            udpatesite_info(){
                this.$Progress.start()
                //Server request
                this.form.put('api/siteinfo/'+this.form.id)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Site info updated successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
            },
            loadsite_infos(){
                axios.get('api/siteinfo').then(({ data }) => { this.form.fill(data) });
                // axios.get('api/siteinfo')
                // .then(response => {
                //     this.siteinfo = response.data;
                // });
            }
        },
        created() {
            this.loadsite_infos();
            //setInterval(() => { this.loadsite_infos(); }, 500);
            Fire.$on('AfterCreated', ()=> {
                this.loadsite_infos();
            });
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
