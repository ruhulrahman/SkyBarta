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
              <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
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
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">New Post</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="bio">Privacy</label>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="getProfilePhoto()" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ this.form.name }}</h3>

                <p v-if="this.form.quote!=null" class="orange text-center"><q><i>{{ this.form.quote }}</i></q></p>

                <ul class="list-group mb-3">                  
                  <!-- <li class="list-group-item">
                    <b>Friends</b> <a href="" class="float-right">13,287</a>
                  </li> -->
                  <li class="list-group-item">
                    <b>Followers</b> <a href="" class="float-right">{{ followerCount.length }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a href="" class="float-right">{{ followingCount.length }}</a>
                  </li>
                </ul>
                
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b class="text-green">Date of Birth <i class="fas fa-calendar-day"></i></b> <a class="float-right">{{ this.form.dob }}</a>
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
                  <li class="list-group-item" v-for="(user, index) in users" :key="index">
                    <b>Gender</b> 
                    <a class="float-right"> 
                      <span>{{ user.gender.name }}</span>
                    </a>
                  </li>
                  <li class="list-group-item" v-for="(user, index) in users" :key="index">
                    <b>Religion</b> 
                    <a class="float-right"> 
                      <span>{{ user.religion.name }}</span>
                    </a>
                  </li>
                  <li class="list-group-item" v-for="(user, index) in users" :key="index">
                    <b>Relation <i class="fa fa-heart pink"></i></b>
                    <a class="float-right" v-if="user.relation_id != null"> 
                      <span>{{ user.relation.name }}</span>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Hobby</b> 
                    <a class="float-right">{{ this.form.hobby }}</a>
                  </li>

                  <li class="list-group-item" v-for="(user, index) in users" :key="index">
                    <b>Blood <i class="nav-icon fas fa-tint red"></i></b>
                    <a class="float-right"  v-if="user.blood_id != null">{{ user.blood.name }}</a>
                  </li>

                  <li class="list-group-item" v-for="(user, index) in users" :key="index">
                    <b>Profession</b>
                    <a class="float-right" v-if="user.profession_id != null">{{ user.profession.name }}</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
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
                  {{ this.form.aboutme }}
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
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">My Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profile Settings</a></li>
                  <li class="nav-item"><a class="nav-link" href="#location" data-toggle="tab">My Location</a></li>
                  <li class="nav-item"><a class="nav-link" href="#education" data-toggle="tab">Education</a></li>
                </ul>
              </div><!-- /.card-header -->

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

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" v-model="form.name" class="form-control" id="inputName2" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputslug" class="col-sm-2 col-form-label">ID/Slug</label>
                        <div class="col-sm-10">
                          <input type="email" v-model="form.slug" class="form-control" id="inputslug" placeholder="slug" :class="{ 'is-invalid': form.errors.has('slug') }">
                          <has-error :form="form" field="slug"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputmobile" class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                          <input type="text" v-model="form.mobile" class="form-control" id="inputmobile" placeholder="mobile" :class="{ 'is-invalid': form.errors.has('mobile') }">
                          <has-error :form="form" field="mobile"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputdob" class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-10">
                          <input type="date" v-model="form.dob" class="form-control" id="inputdob" placeholder="date of birth" :class="{ 'is-invalid': form.errors.has('dob') }">
                          <has-error :form="form" field="dob"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputdob" class="col-sm-2 col-form-label">Monthly Income</label>
                        <div class="col-sm-10">
                          <input type="number" v-model="form.m_income" class="form-control" id="inputm_income" placeholder="Monthly Income" :class="{ 'is-invalid': form.errors.has('m_income') }">
                          <has-error :form="form" field="m_income"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputdob" class="col-sm-2 col-form-label">Family Members</label>
                        <div class="col-sm-10">
                          <input type="number" v-model="form.fam_members" class="form-control" id="inputfam_members" placeholder="Family Members quantity" :class="{ 'is-invalid': form.errors.has('fam_members') }">
                          <has-error :form="form" field="fam_members"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputdob" class="col-sm-2 col-form-label">Hobby</label>
                        <div class="col-sm-10">
                          <input type="text" v-model="form.hobby" class="form-control" id="inputhobby" placeholder="Hobby like travel, singing" :class="{ 'is-invalid': form.errors.has('hobby') }">
                          <has-error :form="form" field="hobby"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="aboutme" class="col-sm-2 col-form-label">About Me</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" v-model="form.aboutme" id="aboutme" placeholder="About Me here"></textarea>
                          <has-error :form="form" field="aboutme"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="quote" class="col-sm-2 col-form-label">Quote</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" v-model="form.quote" id="quote" placeholder="Your favorite quote"></textarea>
                          <has-error :form="form" field="quote"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputProfilePhoto" class="col-sm-2 col-form-label">Profile Photo</label>
                        <div class="col-sm-10">
                          <input type="file" @change="previewProfilePhoto" class="form-control-file" id="inputProfilePhoto">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Change Password (Leave empty if not changing)</label>
                        <div class="col-sm-10">
                          <input type="text" v-model="form.password" class="form-control" id="inputPassword" placeholder="Change Password" :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>

                      <div class="form-group row">
                          <label for="gender_id" class="col-sm-2 col-form-label">Gender</label>
                          <div class="col-sm-10">
                            <span v-for="(gender, index) in genders" :key="index">
                              <input v-model="form.gender_id" type="radio" :value="gender.id"
                              :class="{ 'is-invalid': form.errors.has('gender_id') }">{{ gender.name }}
                            </span>
                            <has-error :form="form" field="gender_id"></has-error>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="religion_id" class="col-sm-2 col-form-label">Religion</label>
                          <div class="col-sm-10">
                            <span v-for="(religion, index) in religions" :key="index">
                              <input v-model="form.religion_id" type="radio" :value="religion.id" :class="{ 'is-invalid': form.errors.has('religion_id') }">{{ religion.name }}
                            </span>
                            <has-error :form="form" field="religion_id"></has-error>
                          </div>
                      </div>
 
                      <div class="form-group row">
                          <label for="relation_id" class="col-sm-2 col-form-label">Relational Status</label>
                          <div class="col-sm-10">                            
                            <select name="type" class="form-control" id="relation_id" v-model="form.relation_id" :class="{ 'is-invalid': form.errors.has('relation_id') }">
                                <option value="" disabled="disabled">Select Relational Status</option>
                                <option v-for="(relation, index) in relations" :key="index" :value="relation.id" v-text="relation.name"></option>
                            </select>
                            <has-error :form="form" field="relation_id"></has-error>
                          </div>
                      </div>


                      <div class="form-group row">
                          <label for="blood_id" class="col-sm-2 col-form-label">Blood Group</label>
                          <div class="col-sm-10">                            
                            <select class="form-control" id="blood_id" v-model="form.blood_id" :class="{ 'is-invalid': form.errors.has('blood_id') }">
                                <option value="" selected="selected" disabled="disabled">Select Blood Group</option>
                                <option v-for="(blood, index) in bloods" :key="index" :selected="form.blood_id===blood.id" :value="blood.id" v-text="blood.name"></option>
                            </select>
                            <has-error :form="form" field="blood_id"></has-error>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="profession_id" class="col-sm-2 col-form-label">Profession</label>
                          <div class="col-sm-10">                            
                            <select class="form-control" id="profession_id" v-model="form.profession_id" :class="{ 'is-invalid': form.errors.has('profession_id') }">
                                <option value="" selected="selected" disabled="disabled">Select Profession</option>
                                <option v-for="(profession, index) in professions" :key="index" :selected="form.profession_id===profession.id" :value="profession.id" v-text="profession.name"></option>
                            </select>
                            <has-error :form="form" field="profession_id"></has-error>
                          </div>
                      </div>


                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" @click.prevent="updateProfile" class="btn btn-primary">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="location">

                      <div class="card-tools pull-right mb-2">
                          <button type="button" class="btn btn-success" @click="addNewUserLocationModalOpen"> Add New Location <b>+</b>
                          </button>
                      </div>

                    <table id="example2" class="table table-bordered table-striped dataTable table-head-fixed" role="grid" aria-describedby="example2_info">
                      <thead>
                          <tr role="row" class="purple">
                              <th>Address Type: </th>
                              <th>Village: </th>
                              <th>Union</th>
                              <th>Thana</th>
                              <th>District</th>
                              <th>Division</th>
                              <th>Modify</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr role="row" class="odd" v-for="(usrloc, index) in userlocations" :key="index">
                              <td>{{ usrloc.type }}</td>
                              <td>{{ usrloc.village_name }}</td>
                              <td>{{ usrloc.union_name }}</td>
                              <td>{{ usrloc.thana.name }}</td>
                              <td>{{ usrloc.district.name }}</td>
                              <td>{{ usrloc.division.name }}</td>
                              <td>
                                  <a href="#" @click="editUserLocation(usrloc)" class="btn btn-primary"><i class="fas fa-edit"></i></a> ||
                                  <a href="#" @click.prevent="deleteUserLocation(usrloc.id)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                              </td>

                          </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="education">
                      <div class="card-tools mb-2">
                          <button type="button" class="btn btn-success" @click="addNewUserEducationModalOpen"> Add New Degree
                              <i class="fas fa-book mr-1"></i> 
                          </button>
                      </div>

              <table id="example1" class="table table-bordered table-striped dataTable table-head-fixed" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr role="row" class="purple">
                        <th>Degree Name</th>
                        <th>Major</th>
                        <th>Passing Year</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd" v-for="(ursedu, index) in userEducations" :key="index">
                        <td>{{ ursedu.degree.name }}</td>
                        <td>{{ ursedu.major.name }}</td>
                        <td>{{ ursedu.passing_year }}</td>
                        <td>
                            <a href="#" @click="editUserEducation(ursedu)" class="btn btn-primary"><i class="fas fa-edit"></i></a> ||
                            <a href="#" @click.prevent="deleteUserEducation(ursedu.id)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>

                    </tr>
                </tbody>
              </table>
                  </div>
                  <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>



            <div class="card" v-for="(post, post_id) in posts" :key="post_id">
              <div class="card-body">
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

                          <div class="dropdown float-right btn-tool">
                            <a href="#" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                              <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="#" @click.prevent="editPost(post)">Edit Post</a>
                              <a class="dropdown-item" href="#" @click.prevent="deleteposts(post.id)">Delete Post</a>
                            </div>
                          </div>


                        </span>
                        <span class="description">Shared {{ post.privacy.name }} - {{ post.created_at | localDate }}</span>






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
                          <a href="" @click.prevent="getCommnets(post_id)" class="link-black text-sm">
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


                <!-- Modal -->
        <div class="modal fade" id="addNewUserLocationModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

            <form @submit.prevent="editMode ? updateUserLocation() : createUserLocation()" @keydown="form.onKeydown($event)">
            <div class="modal-header  bg-success">
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">Add User Location</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit User Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">                  
                    <label>Select Address Type</label>
                    <select v-show="editMode===true" v-model="form3.type" class="form-control" :class="{ 'is-invalid': form3.errors.has('type') }">
                        
                        <option v-if="form3.type==='lives'" selected="selected" value="lives">Lives</option>                        
                        <option v-if="form3.type==='hometown'" selected="selected" value="hometown">Home Town</option>
                        <option v-if="form3.type==='office'" selected="selected" value="office">Office Address</option>

                        <option :value="'lives'">Lives</option>
                        <option :value="'office'">Office Address</option>
                        <option :value="'hometown'">Home Town</option>
                    </select>

                    <select v-show="editMode===false" v-model="form3.type" class="form-control" :class="{ 'is-invalid': form3.errors.has('type') }">
                        <option :value="'lives'">Lives</option>
                        <option :value="'hometown'">Home Town</option>
                        <option :value="'office'">Office Address</option>
                    </select>
                    <has-error :form="form3" field="type"></has-error>
                </div>
                <div class="form-group">                  
                    <label>Select Division Name</label>
                    <select @change='getDistrict()' v-show="editMode===true" v-model="form3.division_id" class="form-control" :class="{ 'is-invalid': form3.errors.has('division_id') }">
                        <option v-for="(division, index) in divisions" :key="index" :selected="form3.division_id===division.id" :value="division.id" v-text="division.name">
                        </option>
                    </select>

                    <select @change='getDistrict()' v-show="editMode===false" v-model="form3.division_id" class="form-control" :class="{ 'is-invalid': form3.errors.has('division_id') }">
                        <option v-for="(division, index) in divisions" :key="index" :value="division.id" v-text="division.name">
                        </option>
                    </select>
                    <has-error :form="form3" field="division_id"></has-error>
                </div>
                <div class="form-group">
                    <label>Select District Name</label>
                    <select @change='getThana()' v-show="editMode===true" v-model="form3.district_id" class="form-control" :class="{ 'is-invalid': form3.errors.has('district_id') }">
                        <option v-for="(district, index) in districts" :key="index" :selected="form3.district_id===district.id" :value="district.id" v-text="district.name">
                        </option>
                    </select>

                    <select @change='getThana()' v-show="editMode===false" v-model="form3.district_id" class="form-control" :class="{ 'is-invalid': form3.errors.has('district_id') }">
                        <option v-for="(district, index) in districts" :key="index" :value="district.id" v-text="district.name">
                        </option>
                    </select>
                    <has-error :form="form3" field="district_id"></has-error>
                </div>
                <div class="form-group">
                  <label>Select Thana Name</label>
                  <select v-show="editMode===true" v-model="form3.thana_id" class="form-control" :class="{ 'is-invalid': form3.errors.has('thana_id') }">
                      <option v-for="(thana, index) in thanas" :key="index" :selected="form3.thana_id===thana.id" :value="thana.id" v-text="thana.name">
                      </option>
                  </select>
                  <select v-show="editMode===false" v-model="form3.thana_id" class="form-control" :class="{ 'is-invalid': form3.errors.has('thana_id') }">
                      <option v-for="(thana, index) in thanas" :key="index" :value="thana.id" v-text="thana.name">
                      </option>
                  </select>
                  <has-error :form="form3" field="thana_id"></has-error>
                </div>
                <div class="form-group">
                    <label>Union Name</label>
                    <input type="text" v-model="form3.union_name" class="form-control" id="union_name" placeholder="union name" :class="{ 'is-invalid': form3.errors.has('union_name') }">
                    <has-error :form="form3" field="union_name"></has-error>
                </div>
                <div class="form-group">
                    <label>Village Name</label>
                    <input type="text" v-model="form3.village_name" class="form-control" id="village_name" placeholder="village name" :class="{ 'is-invalid': form3.errors.has('village_name') }">
                    <has-error :form="form3" field="village_name"></has-error>
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

            <!-- Modal -->
        <div class="modal fade" id="addNewUserEducationModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

            <form @submit.prevent="editMode ? updateUserEducation() : createUserEducation()" @keydown="form.onKeydown($event)">
            <div class="modal-header  bg-success">
                <h5 v-show="!editMode" class="modal-title" id="addNewModalTitle">New User Education</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewModalTitle">Edit User Education</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Select Degree Name</label>
                    <select v-show="editMode===true" v-model="form4.degree_id" class="form-control" :class="{ 'is-invalid': form4.errors.has('degree_id') }">
                        <option v-for="(degree, index) in degrees" :key="index" :selected="form4.degree_id===degree.id" :value="degree.id" v-text="degree.name">
                        </option>
                    </select>

                    <select v-show="editMode===false" v-model="form4.degree_id" class="form-control" :class="{ 'is-invalid': form4.errors.has('degree_id') }">
                        <option selected="selected" disabled="disabled">Select Degree</option>
                        <option v-for="(degree, index) in degrees" :key="index" :value="degree.id" v-text="degree.name">
                        </option>
                    </select>
                    <has-error :form="form" field="degree_id"></has-error>
                </div>
                <div class="form-group">
                    <label>Select Major Name</label>
                    <select v-show="editMode===true" v-model="form4.major_id" class="form-control" :class="{ 'is-invalid': form4.errors.has('major_id') }">
                        <option v-for="(major, index) in majors" :key="index" :selected="form4.major_id===major.id" :value="major.id" v-text="major.name">
                        </option>
                    </select>

                    <select v-show="editMode===false" v-model="form4.major_id" class="form-control" :class="{ 'is-invalid': form4.errors.has('major_id') }">
                        <option selected="selected" disabled="disabled">Select Major</option>
                        <option v-for="(major, index) in majors" :key="index" :value="major.id" v-text="major.name">
                        </option>
                    </select>
                    <has-error :form="form" field="major_id"></has-error>
                </div>
                <div class="form-group">
                    <label>Passing Year</label>
                    <input v-model="form4.passing_year" type="number"
                        class="form-control" :class="{ 'is-invalid': form4.errors.has('passing_year') }">
                    <has-error :form="form4" field="passing_year"></has-error>
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
              editMode:false,
              userlocations:{},
              userEducations:{},
              posts:{},
              privacies:{},
              bloods:{},
              users:{},
              divisions:{},
              districts:{},
              thanas:{},
              degrees:{},
              comments:{},
              majors:{},
              professions:{},
              likes:{},
              genders:{},
              religions:{},
              relations:{},
              comments:{},
              likesCount: 0,
              CommentCount: 0,
              commentfield: '',
              form: new Form({
                  id: '',
                  name: '',
                  slug: '',
                  email: '',
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
                  followingCount: '',
                  followerCount: '',
              }),
              postform: new Form({
                  id: '',
                  desc: '',
                  privacy_id: '',
              }),
              form3: new Form({
                  id: '',
                  type: '',
                  s_id: '',
                  village_name: '',
                  union_name: '',
                  thana_id: '',
                  district_id: '',
                  division_id: '',
              }),
              form4: new Form({
                  id: '',
                  user_id: '',
                  degree_id: '',
                  major_id: '',
                  passing_year: '',
              })
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
                })
                this.commentfield = '';
            },
            getLike(postId){
                axios.get('api/getLikeCountByPost/' + postId)
                    .then(response => {
                        this.likesCount = response.data;
                    });
            },
            getProfilePhoto(){
              let photo = this.form.photo;
              if(photo){
                    let pt = "/img/profile/"+photo;
                    return pt;
                }else{               
                    let pt = "img/boy.png";
                    return pt;
                }
              //  let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+this.form.photo;
              //   return photo;
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
            CurrectAuth(){
              return this.form.id;
            },
            resetData(){
                this.form.reset();
                this.postform.reset();
                this.form3.reset();
                this.form4.reset();
            },
            addNewUserEducationModalOpen(){
                this.editMode = false;
                this.form4.reset()
                $('#addNewUserEducationModal').modal('show')
            },
            editUserEducation(education){
                this.editMode = true;
                this.form4.reset()
                $('#addNewUserEducationModal').modal('show')
                this.form4.fill(education)
            },
            addNewUserLocationModalOpen(){
                this.editMode = false;
                this.form3.reset()
                $('#addNewUserLocationModal').modal('show')
            },
            editUserLocation(location){
                this.editMode = true;
                this.form3.reset()
                $('#addNewUserLocationModal').modal('show')
                this.form3.fill(location)
            },
            getDistrict(){
                axios.get('api/districtByDivision/' + this.form3.division_id)
                    .then(response => {
                        this.districts = response.data;
                    });
            },
            getThana(){
                axios.get('api/thanaByDistrict/' + this.form3.district_id)
                    .then(response => {
                        this.thanas = response.data;
                    });
            },
            getCommnets(postId){
                axios.get('api/getCommentByPost/' + postId)
                    .then(response => {
                        this.comments = response.data;
                    });
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
                this.$Progress.start()
                this.postform.post('api/post')
                .then(()=>{
                    // Fire.$emit('AfterCreatedPost');
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
            createUserEducation(){                
                this.$Progress.start()
                this.form4.post('api/userEducation')
                .then(()=>{
                    // Fire.$emit('AfterCreated');
                    this.loadUserEducation();
                    $('#addNewUserEducationModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Education created successfully'
                    })
                    this.$Progress.finish()
                    this.form4.reset()
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'warning',
                        title: 'Education didn\'t Completed'
                    })
                })
                
            },
            createUserLocation(){                
                this.$Progress.start()
                this.form3.post("api/location")
                .then(()=>{
                    Fire.$emit('AfterCreatedUserLocation');
                    $('#addNewUserLocationModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Location added successfully'
                    })
                    this.$Progress.finish()
                    this.form3.reset()
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'warning',
                        title: 'Location didn\'t Completed'
                    })
                })
                
            },
            updatePost(){
                this.$Progress.start()
                //Server request
                this.postform.put('api/post/'+this.postform.id)
                .then(() => {
                    // Fire.$emit('AfterCreated')
                    this.loadPosts();
                    $('#addNewModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })

                //Server request
                this.form.put('api/location/'+this.form3.id)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    toast.fire({
                        icon: 'success',
                        title: 'User Location updated successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
            },
            updateUserEducation(){
                this.$Progress.start()
                //Server request
                this.form4.put('api/userEducation/'+this.form4.id)
                .then(() => {
                    // Fire.$emit('AfterCreated')
                    this.loadUserEducation();
                    $('#addNewUserEducationModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Education updated successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
            },
            updateProfile(){
              this.$Progress.start()
                this.form.put("api/updateProfile")
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
                      swal.fire(
                                'Profile update failed!',
                                'Something wrong here.',
                                'error'
                                )
                    });                
            },
            updateUserLocation(){
              this.$Progress.start()
                this.form3.put("api/location/"+this.form3.id)
                    .then(()=>{
                      Fire.$emit('AfterCreatedUserLocation');
                      $('#addNewUserLocationModal').modal('hide')
                      toast.fire({
                        icon: 'success',
                        title: 'Location updated successfully'
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
            deleteUserEducation(id){
                swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //send to server
                        axios.delete('api/userEducation/'+id)
                        .then(()=>{
                            // Fire.$emit('AfterDeleted');
                            this.loadUserEducation();
                            swal.fire(
                            'Deleted!',
                            'Your education has been deleted.',
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
            deleteUserLocation(id){
                swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //send to server
                        axios.delete('api/location/'+id)
                        .then(()=>{
                            // Fire.$emit('AfterCreated');
                            this.loadUserLocation();
                            swal.fire(
                            'Deleted!',
                            'Your Location has been deleted.',
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
              axios.get('api/postByAuth')
              .then(response => {
                    this.posts = response.data;
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
              axios.get('api/userTimeInfo')
              .then(response => {
                    this.users = response.data;
                });
                
              axios.get('api/blood')
              .then(response => {
                    this.bloods = response.data;
                });
              axios.get('api/profession')
              .then(response => {
                    this.professions = response.data;
                });
              axios.get('api/gender')
              .then(response => {
                    this.genders = response.data;
                });
              axios.get('api/relation')
              .then(response => {
                    this.relations = response.data;
                });
              axios.get('api/religion')
              .then(response => {
                    this.religions = response.data;
                }); 
              axios.get('api/location')
              .then(response => {
                    this.userlocations = response.data;
                });
              axios.get('api/division')
              .then(response => {
                    this.divisions = response.data;
                });
              axios.get('api/district')
              .then(response => {
                    this.districts = response.data;
                });
              axios.get('api/thana')
              .then(response => {
                    this.thanas = response.data;
                });
            },
            loadUserLocation(){
              // axios.get('api/getUserlocation').then(({ data }) => { this.form3.fill(data) });
              axios.get('api/location')
              .then(response => {
                    this.userlocations = response.data;
                });
            },
            loadUserEducation(){              
              axios.get('api/userEducation')
              .then(response => {
                    this.userEducations = response.data;
                });
            },
            loadDegree(){
              axios.get('api/degree')
              .then(response => {
                    this.degrees = response.data;
                });
              axios.get('api/major')
              .then(response => {
                    this.majors = response.data;
                });            
            },
            loadLikes(){
              axios.get('api/like')
              .then(response => {
                    this.likes = response.data;
                });
            },
            followerCount(){
              axios.get('api/followerCountInTimeline')
              .then(response => {
                    this.followerCount = response.data;
                });
            },
            followingCount(){
              axios.get('api/followingCountInTimeline')
              .then(response => {
                    this.followingCount = response.data;
                });
            }
        },
        created() {
          // setInterval(() => { this.loadPosts(); }, 500);
          
            this.followerCount();
            this.followingCount();
            this.loadProfileData();
            this.loadPosts();
            this.loadUserLocation();
            this.loadDegree();
            this.loadUserEducation();
            this.loadLikes();
            this.loadprivacies();


            Fire.$on('AfterCreated', ()=> {
                this.loadPosts();
                this.loadProfileData();
                this.loadDegree();
                this.loadUserEducation();
            });

            Fire.$on('AfterCreatedPost', ()=> {
                this.loadPosts();
            });
            Fire.$on('AfterCreatedUserLocation', ()=> {
                this.loadUserLocation();
            });

            Fire.$on('AfterDeleted', ()=> {
                this.loadPosts();
                this.loadUserLocation();
                this.loadUserEducation();
            });

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
