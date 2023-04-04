<template>
    <div>
        <form @submit.prevent="assignUsers"> 
        <alert-error :form="updateData"></alert-error> 
            <div class="row">
                <div class="col-md-12">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Department</label>
                        <select class="form-control" id="department_id" name="department_id" placeholder="Enter Street Desc" v-model="updateData.department_id" :class="{'is-invalid' : updateData.errors.has('department_id') }" @change="updateUsers">
                            <option value="">---Select Department---</option>
                            <option value="1000">All Users</option>
                            <option v-for="(dept, index) in departments" :value="index" :key="dept.id">{{dept.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Users <span><small>You can choose multiple</small></span></label>
                        <select class="form-control" id="user_id" name="user_id" v-model="updateData.user_id" :class="{'is-invalid' : updateData.errors.has('user_id') }">
                            <option value="">--Select Users--</option>
                            <option v-for="user in users" :value="user.id" :key="user.id">{{user.first_name}} {{user.middle_name}} {{user.last_name}}</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-12">
                    <input v-show="!editMode" type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                    <input v-show="editMode" type="submit" name="submit" class="submit btn btn-success" value="Update" />
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {    
    data(){
        return {   
            updateData: new Form({
                content: '',
                department_id: '', 
                dept_id: '',
                status_id: '',
                ticket_id: '',
                user_id: '',
            }),
            departments: [],
            route: '',
            users: [],
        }
    },
    methods:{
        assignUsers(){
            this.$Progress.start();
            this.updateData.ticket_id = this.ticket.id;
            this.updateData.type_id = 3;
            this.updateData.status_id = 3;
            this.updateData.post('/api/tickets/comments')
            .then(response=>{
                Fire.$emit('updateUsers', response.data.assignees);
                Fire.$emit('ticketReload', response);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            })
        },
        getInitials(){
            axios.get('/api/lms/assign_users').then(response =>{
                this.departments = response.data.departments;
                this.users = response.data.users;
            })
            .catch(()=>{
                toast.fire({
                    icon: 'error',
                    title: 'Departments were not loaded successfully',
                })
            });
        },
        updateList(){
            if (in_array(-1, this.updateData.user_id)){
                console.log('Yue');

            }
            else{

            }
            console.log(this.updateData.user_id);
            
        },
        updateUsers(){
            this.updateData.dept_id = this.departments[this.updateData.department_id].id;
            if (this.updateData.department_id != 1000){
                this.updateData.user_id = [];
                this.users = this.departments[this.updateData.department_id].users;
            }
            console.log(this.updateData.department_id); 
            console.log(this.updateData.dept_id);
        },
         
    },
    mounted() {
        this.getInitials();
    },
    props: {
        'editMode': Boolean,
        'reference': Object,
        'aspire': String,
        'ticket': Object,
    },
}
</script>