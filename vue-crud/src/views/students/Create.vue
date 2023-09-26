<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Add students</h4>
            </div>
            <div class="card-body">
                <ul class="alert alert-warning" v-if="Object.keys(errorList).length>0">
                    <li class="mb-0 ms-3"  v-for="(error,index) in errorList" :key="index">
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
                        @click="saveStudent"
                        class="btn btn-success"
                    >
                        Save
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
    name: "StudentCreate",
    data() {
        return {
            errorList:'',
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
    methods: {
        saveStudent() {
            var url = "http://127.0.0.1:8000/api/students";
            var myThis=this;
            axios
                .post(url, this.model.student)
                .then((res) => {
                    console.log(res.data);
                    this.model.student = {
                        name: "",
                        email: "",
                        phone: "",
                        course: "",
                    };
                    this.errorList='';
                    swal("Good job!", "Your Data is Saved !", "success");
                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 422) {
                            myThis.errorList = error.response.data.errors;
                        }
                        /*                         console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers); */
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log("Error", error.message);
                    }
                });
        },
    },
};
</script>
