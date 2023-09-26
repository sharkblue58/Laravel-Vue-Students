<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Students</h4>
                <RouterLink
                    to="/students/create"
                    class="btn btn-success float-end"
                    >Add Student</RouterLink
                >
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="students.length > 0">
                        <tr v-for="student in students">
                            <td>{{ student.id }}</td>
                            <td>{{ student.name }}</td>
                            <td>{{ student.course }}</td>
                            <td>{{ student.email }}</td>
                            <td>{{ student.phone }}</td>
                            <td>{{ student.created_at }}</td>
                            <td>
                                <RouterLink
                                    :to="{
                                        path:
                                            '/students/' + student.id + '/edit',
                                    }"
                                    class="btn btn-primary me-2"
                                    style="width: 70px"
                                    >Edit</RouterLink
                                >
                                <button
                                    type="button"
                                    @click="deleteStudent(student.id)"
                                    class="btn btn-danger ms-2"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7">No Records Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import axios, { Axios } from "axios";
import swal from "sweetalert";
export default {
    name: "students",
    data() {
        return {
            students: [],
        };
    },
    mounted() {
        console.log("mounted() called ....");
        this.getStudents();
        console.log("getStudents() called ....");
    },
    methods: {
        getStudents() {
            var url = "http://127.0.0.1:8000/api/students";
            axios.get(url).then((res) => {
                console.log(res.data.data);
                this.students = res.data.data;
            });
        },
        deleteStudent(studentID) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.delete(`http://127.0.0.1:8000/api/students/${studentID}/delete`).then(res=>{
                        this.getStudents();
                        swal("Poof! Your record has been deleted!", {
                        icon: "success",
                    });
                    })
                } else {
                    swal("Your record is safe!");
                }
            });
        },
    },
};
</script>
