<template>
    <div>
    <div class="card">
        <div class="card-header">
              <h3 class="card-title">STUDENTS</h3>

                    <input class="form-control col-md-6  d-inline " style="margin-left:200px" type="search" placeholder="Search" v-model="search" aria-label="Search">

              <span class="btn btn-primary float-right " data-toggle="modal" data-target="#addStudent"><i class="far fa-address-card mr-3" @click="resetStudent()"></i>ADD DETAILS</span>
          </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="dt" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Adm No</th>
                  <th>Email</th>
                  <th>Parents Name</th>
                  <th>Contact</th>
                  <th>Class</th>
                  <th>Address</th>
                  <th>Town</th>
                  <th>County</th>
                  <th>Joined On</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                 <tr v-for="student in searchedStudents" :key="student.id">
                  <td data-toggle="modal" data-target="#StudentClasses" @click="setStudent(student)">{{ student.name}}</td>
                  <td>{{ student.admission_no}}</td>
                  <td>{{ student.email }}</td>
                  <td>{{ student.parents_fname}} {{ student.parents_sname}}</td>
                  <td>{{ student.parents_tel }}</td>
                  <td> {{ student.class_name }}</td>
                  <td>{{ student.address}}</td>
                  <td>{{ student.town }}</td>
                  <td>{{ student.county}}</td>
                  <td>{{ student.joined}}</td>
                  <td><i class="fas fa-pencil-alt mr-1" data-toggle="modal" data-target="#editStudent" @click="setStudent(student)"></i> <i class="ml-1 far fa-trash-alt" @click="deleteStudent(student.id)"></i></td>
                </tr>


                </tbody>

              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->



            <div class="modal fade" id="StudentClasses" tabindex="-1" role="dialog" aria-labelledby="StudentClasses" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title ml-2" id="TeacherDetailsTitle">{{ student.name }}'s Subjects</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <!-- Modal -->          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row ml-2">
                                <div class="col-md-6">
                                    <label for="" class="mb-0 pb-0">Choosen Subjects <span class="ml-1 badge-primary badge-pill">{{ student.subjects_taken.length }}</span></label>
                                    <hr>
                                    <p v-for="st in student.subjects_taken" :key="st.id">
                                        {{ st.unit.duty.subject.title }}
                                        <span class="ml-2 mr-2 text-bold"> By </span>
                                        <span class="text-blue text-bold">{{ st.unit.duty.teacher.name }}</span>
                                        <i class="ml-2 far fa-trash-alt" @click="deleteStudy(st.id)"></i>
                                    </p>
                                </div>
                            <div class="col-md-6">
                                <label  class="mb-0 pb-0">Available Subjects <span class="ml-1 badge-dark badge-pill">{{ student.availableSubjects.length }}</span></label>
                                <hr>
                                <p v-for="sb in student.availableSubjects" :key="sb.id" :class="{ 'text-muted': !sTaken(sb.id) , 'choosen-sub': !sTaken(sb.id) }">
                                        {{ sb.duty.subject.title }}
                                        <span class="ml-2 mr-2 text-bold"> By </span>
                                        <span class="text-bold" :class="{ 'text-blue': sTaken(sb.id) }">{{ sb.duty.teacher.name }}</span>
                                        <i class="ml-2 fa fa-check" @click="addStudy(sb.id)" v-if="sTaken(sb.id)"></i>
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-muted blue">Joined on {{ student.joined }}</div>
                    </div>
                </div>
            </div>
            </div>

<!--            STUDENT CLASSES BEGINN-->
<!--                ADD STUDENT DETAILS-->
                <div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudent" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title ml-2" id="addSudentDetailsTitle">ADD STUDENT DETAILS</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <!-- Modal -->          <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="p-2" @submit.prevent="addDetails">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">For</label>
                                            <select v-model="student.id" class="form-control">
                                                <option v-for="stu in logged" :key="stu.id" :value="stu.id">{{ stu.name }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="classroom">Class</label>
                                            <select v-model="student.class_id" class="form-control">
                                                <option v-for="cl in classes" :key="cl.id" :value="cl.id"> {{ cl.form.name + " " + cl.stream.name }}</option>
                                            </select>
                                            <span v-if="validationErrors.class_id" class="text-danger">@{{ validationErrors.class_id[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group  col-md-6">
                                            <label for="pfirstname">Parent / Guardian First Name</label>
                                            <input type="text" class="form-control" v-model="student.parents_fname" id="pfirstname" placeholder="Parent or Guardian First Name">
                                            <span v-if="validationErrors.parents_fname" class="text-danger">@The parents first name field is required</span>
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="psecname">Parent / Guardian Second Name</label>
                                            <input type="text" class="form-control" v-model="student.parents_sname" id="psecname" placeholder="Parent or Guardian Second Name">
                                            <span v-if="validationErrors.parents_sname" class="text-danger">@The parents second name field is required.</span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="address">Address</label>
                                            <input type="text" v-model="student.address" class="form-control" id="address">
                                            <span v-if="validationErrors.address" class="text-danger">@{{ validationErrors.address[0] }}</span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="tel">Telephone (Parent)</label>
                                            <input type="text" v-model="student.parents_tel" class="form-control" id="tel">
                                            <span v-if="validationErrors.parents_tel" class="text-danger">@{{ validationErrors.parents_tel[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group  col-md-6">
                                            <label for="town">Town</label>
                                            <input type="text" v-model="student.town" class="form-control" id="town">
                                            <span v-if="validationErrors.town" class="text-danger">@{{ validationErrors.town[0] }}</span>
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="county">County</label>
                                            <select id="county" v-model="student.county" class="form-control" >
                                                <option selected disabled>Choose...</option>
                                                 <option v-for="(county , index) in counties" :key="index" :value="county.name"> {{ county.name }}</option>
                                            </select>
                                            <span v-if="validationErrors.county" class="text-danger">@{{ validationErrors.county[0] }}</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                    <!--        STUDENT CLASSES END-->

            <div class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-labelledby="editStudent" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-2" id="addSudentDetailsTitle">EDIT STUDENT DETAILS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <!-- Modal -->          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="p-2" @submit.prevent="updateStudent">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="name">For</label>
                                <label for="name" class="form-control">{{ student.name }}</label>
                               </div>
                                <div class="form-group col-md-6">
                                <label for="classroom">Class</label>
                                <select v-model="student.class_id" class="form-control">
                                    <option :value="student.class_id">{{ student.className }}</option>
                                    <option v-for="cl in classes" :key="cl.id" :value="cl.id"> {{ cl.form.name + " " + cl.stream.name }}</option>
                                </select>
                                <span v-if="validationErrors.class_id" class="text-danger">@{{ validationErrors.class_id[0] }}</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group  col-md-6">
                                    <label for="pfirstname">Parent / Guardian First Name</label>
                                    <input type="text" class="form-control" v-model="student.parents_fname" id="pfirstname" placeholder="Parent or Guardian First Name">
                                    <span v-if="validationErrors.parents_fname" class="text-danger">@The parents first name field is required</span>
                                </div>
                                <div class="form-group  col-md-6">
                                    <label for="psecname">Parent / Guardian Second Name</label>
                                    <input type="text" class="form-control" v-model="student.parents_sname" id="psecname" placeholder="Parent or Guardian Second Name">
                                    <span v-if="validationErrors.parents_sname" class="text-danger">@The parents second name field is required.</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <input type="text" v-model="student.address" class="form-control" id="address">
                                    <span v-if="validationErrors.address" class="text-danger">@{{ validationErrors.address[0] }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tel">Telephone (Parent)</label>
                                    <input type="text" v-model="student.parents_tel" class="form-control" id="tel">
                                    <span v-if="validationErrors.parents_tel" class="text-danger">@{{ validationErrors.parents_tel[0] }}</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group  col-md-6">
                                    <label for="town">Town</label>
                                    <input type="text" v-model="student.town" class="form-control" id="town">
                                    <span v-if="validationErrors.town" class="text-danger">@{{ validationErrors.town[0] }}</span>
                                </div>
                                <div class="form-group  col-md-6">
                                    <label for="county">County</label>
                                    <select id="county" v-model="student.county" class="form-control" >
                                        <option selected >{{ student.county }}</option>
                                        <option v-for="(county , index) in counties" :key="index" :value="county.name"> {{ county.name }}</option>
                                    </select>
                                    <span v-if="validationErrors.county" class="text-danger">@{{ validationErrors.county[0] }}</span>
                                </div>
                            </div>
                            <span class="text-primary" @click="openClasses('#editStudent','#StudentClasses')">Edit {{ student.name }}'s Subjects</span>
                            <button type="submit" class="btn btn-primary float-right">UPDATE</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

    </div>
</template>

<script>
    export default {
        name: 'Students',
        data(){
            return{
                logged : [],
                students : [],
                classes: [],
                counties: window.Counties,
                student: {
                    id: '',
                    name: '',
                    parents_fname: '',
                    parents_sname: '',
                    parents_tel:'',
                    class_id : '',
                    className: '',
                    address: '',
                    county: '',
                    town : '',
                    subjects_taken: [],
                    availableSubjects: [],
                },
                search: '',
                validationErrors: [],
            }
        },
        props:[],
        methods:{
            sTaken(id){
                let visible = true
                this.student.subjects_taken.forEach((st) =>{
                    if(st.unit.duty.id == id){

                       visible = false;
                    }
                })

                return visible;
            },
            resetStudent(){
                     this.student.id = ''
                    this.student.name = ''
                    this.student.parents_fname = ''
                    this.student.parents_sname = ''
                    this.student.parents_tel = ''
                    this.student.class_id  = ''
                    this.student.className  = ''
                    this.student.address = ''
                    this.student.county =''
                    this.student.town  = ''
                    this.student.joined  = ''
                    this.student.subjects_taken = []
            },
            setStudent(student){
                    this.student.id = student.id,
                    this.student.name = student.name,
                    this.student.parents_fname = student.parents_fname,
                    this.student.parents_sname = student.parents_sname,
                    this.student.parents_tel = student.parents_tel,
                    this.student.class_id  = student.class_id,
                    this.student.className  = student.class_name,
                    this.student.address = student.address,
                    this.student.county = student.county,
                    this.student.town  = student.town,
                    this.student.joined  = student.joined,
                    this.student.subjects_taken  = student.subjects_taken,

                    axios.get('/api/timetables/'+ this.student.class_id+'/'+student.id)
                        .then(response =>{
                            this.student.availableSubjects = response.data.data;
                        })
                        .catch(err =>{
                            console.log(err);
                        });

             },
            openClasses(close,open){
                $(close).modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                $(open).modal('show');
            },
            addStudy(id){
                axios.post('/api/add-study/',
                    {
                        student_id:this.student.id,
                        timetable_id: id,
                    }
                ).then(response =>{
                    Fire.$emit('UpdateStudents');

                        axios.get('/api/reload-study/'+this.student.id)
                            .then(response =>{
                                this.student.subjects_taken  = response.data.data;
                            })
                            .catch(err =>{
                                console.log("Error from Reload --- " + err)
                            });

                        axios.get('/api/timetables/'+ this.student.class_id+"/"+this.student.id)
                            .then(response =>{
                                this.student.availableSubjects = response.data.data;
                            })
                            .catch(err =>{
                                console.log(err);
                            });

                })
                    .catch(err =>{
                    });
            },
            deleteStudy(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/delete-study/'+id)
                            .then(response =>{
                                axios.get('/api/reload-study/'+this.student.id)
                                    .then(response =>{
                                        this.student.subjects_taken = response.data.data;
                                    })
                                    .catch(err =>{
                                    });
                                Fire.$emit('UpdateStudents');
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Study Deleted Successfully'
                                })
                            })
                            .catch(err =>{
                                // Swal.fire(
                                //     'Error!',
                                //     err,
                                //     'warning'
                                //     )
                            });


                    }
                })
            },
            deleteStudent(id){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                        if (result.value) {
                            axios.delete('/api/delete-student/'+id)
                            .then(response =>{
                                Fire.$emit('UpdateStudents');
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Student Deleted Successfully'
                                    })
                            })
                            .catch(err =>{
                                   Swal.fire(
                                    'Error!',
                                    err,
                                    'warning'
                                    )
                            });


                        }
                    })

                },

               fetchStudents(){
                  axios.get('/api/students')
                            .then(response =>{
                            this.students = response.data.data;
                            })
                            .catch(err =>{
                                    console.log(err);

                });

                axios.get('/api/classes')
                            .then(response =>{
                            this.classes = response.data.data;

                            })
                            .catch(err =>{
                                    console.log(err);

                            });

                axios.get('/api/loggedstudents')
                            .then(response =>{
                            this.logged = response.data.data;
                            })
                            .catch(err =>{
                                    console.log(err);

                });
            },
            updateStudent(){
                axios.post('/api/add-student-info', {
                    id: this.student.id,
                    parents_fname:this.student.parents_fname,
                    parents_sname:this.student.parents_sname,
                    parents_tel:this.student.parents_tel,
                    class_id :this.student.class_id,
                    address:this.student.address,
                    county:this.student.county,
                    town :this.student.town,
                }).then(function (response) {
                        Fire.$emit('UpdateStudents');
                         $('#editStudent').modal('hide');
                         $('body').removeClass('modal-open');
                         $('.modal-backdrop').remove();
                        Toast.fire({
                            icon: 'success',
                            title: 'Student Updated successfully'
                            })
                    })
                    .catch(error =>{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            timer:3500,
                            showConfirmButton:false,
                            text: error.response.data.message,
                            })
                           this.validationErrors = error.response.data.errors;
                    });

            },
            addDetails(){

                axios.post('/api/add-student-info', {
                    user_id: this.student.id,
                    parents_fname:this.student.parents_fname,
                    parents_sname:this.student.parents_sname,
                    parents_tel:this.student.parents_tel,
                    class_id :this.student.class_id,
                    address:this.student.address,
                    county:this.student.county,
                    town :this.student.town,
                }).then(function (response) {
                        Fire.$emit('UpdateStudents');
                         $('#addStudent').modal('hide');
                         $('body').removeClass('modal-open');
                         $('.modal-backdrop').remove();
                         this.resetStudent()

                        Toast.fire({
                            icon: 'success',
                            title: 'Student Added successfully'
                            })
                    })
                    .catch(error =>{
                           this.validationErrors = error.response.data.errors;
                    });
            }
        },
        computed:{
             searchedStudents:function (){
                     return this.students.filter(stdnt => {
                        return stdnt.name.toLowerCase().match(this.search.toLowerCase());
                    });
             }

        },
        mounted() {

               this.fetchStudents();
               Fire.$on('UpdateStudents',()=>{
                   this.fetchStudents();
               });

        }
    }


</script>
<style>
    .choosen-sub{
        text-decoration: line-through;
    }
</style>
