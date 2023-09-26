<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit students</h4>
            </div>
            <div class="card-body">
                <ul
                    class="alert alert-warning"
                    v-if="Object.keys(errorList).length > 0"
                >
                    <li
                        class="mb-0 ms-3"
                        v-for="(error, index) in errorList"
                        :key="index"
                    >
                        {{ error[0] }}
                    </li>
                </ul>
                <div class="mb-3">
                    <label for="Name">Name</label>
                    <span class="text-danger ms-1">*</span>
                    <input
                        type="text"
                        v-model="model.student.name"
                        class="form-control"
                        id="Name"
                        autocomplete="false"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="Course">Course</label>
                    <span class="text-danger ms-1">*</span>
                    <input
                        type="text"
                        v-model="model.student.course"
                        class="form-control"
                        id="Course"
                        autocomplete="false"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="Email">Email</label>
                    <span class="text-danger ms-1">*</span>
                    <input
                        type="email"
                        v-model="model.student.email"
                        class="form-control"
                        id="Email"
                        autocomplete="false"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="Phone">Phone</label>
                    <input
                        type="tel"
                        v-model="model.student.phone"
                        class="form-control"
                        id="Phone"
                        autocomplete="false"
                    />
                </div>
                <div class="mb-3">
                    <button
                        type="button"
                        @click="updateStudent"
                        class="btn btn-success"
                    >
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios, { Axios } from "axios";
import swal from "sweetalert";
export default {
    name: "StudentEdit",
    data() {
        return {
            studentId:'',
            errorList: "",
            model: {
                student: {
                    name: "",
                    email: "",
                    phone: "",
                    course: "",
                },
            },
        };
    },
    mounted() {
        var id = console.log(this.$route.params.id);
        this.studentId=this.$route.params.id;
        this.getStudentData(this.$route.params.id);
    },
    methods: {
        getStudentData(studentId) {
            axios
                .get(`http://127.0.0.1:8000/api/students/${this.studentId}/edit`)
                .then((res) => {
                    console.log(res.data.student);
                    this.model.student = res.data.student;
                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 404) {
                            sweetAlert("Oops...",error.response.data.msg +'you will be redirect after 10 sec', "error");
                            setTimeout(() => {
                                window.location.replace("http://localhost:5173/"); 
                            }, 10000);  
                        }
                    } 
                });
        },
        updateStudent() {
            var myThis = this;
            axios
                .put(`http://127.0.0.1:8000/api/students/${this.studentId}/edit`, this.model.student)
                .then((res) => {
                    console.log(res.data);
                    this.errorList = "";
                    swal("Good job!", "Your Data is Updated !", "success");
                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 422) {
                            myThis.errorList = error.response.data.errors;
                        }
                        if (error.response.status == 404) {
                            sweetAlert("Oops...",error.response.data.msg , "error");
                        }

                    } 
                });
        },
    },
};
</script>
