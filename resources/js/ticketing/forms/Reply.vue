<template>
    <div>
        <form> 
        <alert-error :form="updateData"></alert-error> 
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status_id" name="status_id" v-model="updateData.status_id" :class="{'is-invalid' : updateData.errors.has('status_id') }">
                        <option value="">---Select Status---</option>
                        <option v-for="status in statuses" :value="status.id" :key="status.id">{{status.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Update</label>
                    <textarea rows="6" class="form-control" v-model="updateData.content"></textarea>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <input type="submit" name="submit" class="submit btn btn-success" value="Update" @click.prevent="updateTicket"/>
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
                department_id: '', 
                agent_id:'', 
                ticket_id:'', 
                content: '',
            }), 
            course:{},
            updateData: new Form({
                status_id: '',
                ticket_id: '',
                user_id: '',
                content: '',
                close: false,
                ticket_status: '',
            }),
            departments: [],
            route: '',
            users: [],
        }
    },
    methods:{
        submitUpdate(){
            
        },
        closeTicket(){
            this.$Progress.start();
            this.submitUpdate();
            Swal.fire({icon: 'success',title: 'Ticket has been updated',});
        },
        updateTicket(){
            this.$Progress.start();
            this.updateData.ticket_id = this.ticket.id;
            this.updateData.post('/api/tickets/comments')
            .then(response=>{
                Fire.$emit('ticketReload', response);
                Swal.fire({icon: 'success',title: 'Ticket has been updated',});
                this.updateData.clear();
                this.updateData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            })
            
            this.$Progress.finish();
        },    
        assignUsers(){
            this.$Progress.start();
            this.AssignData.post('/api/lms/assign_users')
            .then(response=>{
                Fire.$emit('AssignUsers', response.data.assignees);
                Fire.$emit('CourseUpdate', response.data.course );
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
            if (in_array(-1, this.AssignData.user_id)){
                console.log('Yue');

            }
            else{

            }
            console.log(this.AssignData.user_id);
            
        },
        updateUsers(){
            this.AssignData.dept_id = this.departments[this.AssignData.department_id].id;
            if (this.AssignData.department_id != 1000){
                this.AssignData.user_id = [];
                this.users = this.departments[this.AssignData.department_id].users;
            }
            console.log(this.AssignData.department_id); 
        },
         
    },
    mounted() {
        this.getInitials();
        Fire.$on('AssignData', () =>{
            this.AssignData.type = this.aspire;
            this.AssignData.ref_id = this.reference.id;        
            });
        Fire.$on('CourseRefresh', course =>{this.course = course;});
        Fire.$on('ExamDataFill', exam =>{
            this.ExamData.reset();
            this.ExamData.fill(exam)
            //this.examData.course_id = typeof exam.course != 'undefined' ? exam.course.id : this.course.id;
        });
    },
    props: {
        'editMode': Boolean,
        'statuses': Array,
        'ticket': Object,
    },
}
</script>