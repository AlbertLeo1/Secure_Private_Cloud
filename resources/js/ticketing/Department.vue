<template>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3 class="card-title">My Departmental Tickets</h3></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>S/N</th><th>Subject</th><th>Created By</th><th>Priority</th><th>Category</th><th>Assigned To</th><th>Status</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ticket, index) in dept_tickets.data" :key="ticket.id" :class="ticket.status_id == 1 ? 'bg-warning': (ticket.status_id == 2 ? 'bg-yellow' : (ticket.status_id == 3 ? 'bg-purple': 'bg-success'))">
                                    <td>{{index | addOne}}</td>
                                    <td :title="ticket.subject">{{ticket.subject | readMore(40, '...')}}</td>
                                    <td>{{ticket.creator.first_name}} {{ticket.creator.last_name}}</td>
                                    <td>{{ticket.priority !== null ? ticket.priority.name : 'No Priority Chosen'}}</td>
                                    <td>{{ticket.category !== null ? ticket.category.name : 'No Priority Chosen'}}</td>
                                    <td>{{ticket.agent != null ? ticket.agent.first_name+' '+ticket.agent.last_name : 'Not Yet Assigned'}}</td>
                                    <td>{{ticket.status != null ? ticket.status.name : 'No Status Assigned'}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="'/ticketing/'+ticket.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
                                            <button class="btn btn-sm btn-danger" @click="closeTicket(ticket.id)"><i class="fa fa-trash"></i></button>
                                        </div>         
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <pagination :data="policies" @pagination-change-page="getPolicy">
                            <span slot="prev-nav">&lt; Previous </span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            areas:[],
            branches:[],
            departments:[],
            dept_tickets: {},
            editMode: false,
            savings:{},
            states:[],
            policy:{},
            policies:{},
            form: new Form({}),
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/tickets/ticket/departmental').then(response =>{
                this.dept_tickets = response.data.dept_tickets;
                
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Departmental Tickets were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Departmental Tickets were not loaded successfully',
                })
            });
        },
        getPolicy(page=1){
            axios.get('/api/policies/all/department?page='+page)
            .then(response=>{
                this.Policys = response.data.Policys;   
            });
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/Policys/search?q='+query)
            .then((response ) => {
                this.Policys = response.data.Policys;
            })
            .catch(()=>{

            });
        });
        Fire.$on('Reload', response =>{
            $('#PolicyModal').modal('hide');
            this.Policys = response.data.Policys;
        });
    },
}
</script>