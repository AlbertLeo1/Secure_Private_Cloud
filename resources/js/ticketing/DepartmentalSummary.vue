<template>
<div class="row justify-content-center">
    <div class="col-md-12">
        <TicketPersonalSummary />
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#created" data-toggle="tab">Created Tickets</a></li>
                <li class="nav-item"><a class="nav-link" href="#assigned" data-toggle="tab">Assigned Tickets</a></li>
                <!--<li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>-->
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="created">
                        <div class="card">
                            <div class="card-header"><h3 class="card-title">My Created Tickets</h3></div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table m-b-0">
                                        <thead>
                                            <tr>
                                                <th>S/N</th><th>Subject</th><th>Created By</th><th>Priority</th><th>Category</th><th>Assigned To</th><th>Status</th><th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(ticket, index) in by_tickets.data" :key="ticket.id">
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
                            <div class="card-footer">
                                <div class="text-right">
                                    <pagination :data="by_tickets" @pagination-change-page="getByTickets">
                                        <span slot="prev-nav">&lt; Previous </span>
                                        <span slot="next-nav">Next &gt;</span>
                                    </pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="assigned">
                        <div class="card">
                            <div class="card-header"><h3 class="card-title">My Assigned Tickets</h3></div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table m-b-0">
                                        <thead>
                                            <tr>
                                                <th>S/N</th><th>Subject</th><th>Created By</th><th>Priority</th><th>Category</th><th>Assigned To</th><th>Status</th><th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(ticket, index) in my_tickets.data" :key="ticket.id">
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
                            <div class="card-footer">
                                <div class="text-right">
                                    <pagination :data="by_tickets" @pagination-change-page="getMyTickets">
                                        <span slot="prev-nav">&lt; Previous </span>
                                        <span slot="next-nav">Next &gt;</span>
                                    </pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="password">
                        <PMFormPassword />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h3 class="card-title">My Created Tickets</h3></div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>S/N</th><th>Subject</th><th>Created By</th><th>Priority</th><th>Category</th><th>Assigned To</th><th>Status</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ticket, index) in by_tickets.data" :key="ticket.id">
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
            <div class="card-footer">
                <div class="text-right">
                    <pagination :data="by_tickets" @pagination-change-page="getByTickets">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h3 class="card-title">My Assigned Tickets</h3></div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>S/N</th><th>Subject</th><th>Created By</th><th>Priority</th><th>Category</th><th>Assigned To</th><th>Status</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ticket, index) in my_tickets.data" :key="ticket.id">
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
            <div class="card-footer">
                <div class="text-right">
                    <pagination :data="by_tickets" @pagination-change-page="getMyTickets">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
</div>-->
</template>
<script>
    export default {
        data(){
            return {
                by_tickets: {},
                my_tickets: {},
                areas:[],
                branches:[],
                departments:[],
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
                axios.get('/api/tickets/ticket/personal').then(response =>{
                    this.by_tickets = response.data.by_tickets;
                    this.my_tickets = response.data.my_tickets;
                    
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Tickets loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Tickets were not loaded successfully',
                    })
                });
            },
            getByTickets(page=1){
                axios.get('/api/tickets/ticket/personal?page='+page)
                .then(response=>{
                    this.by_tickets = response.data.by_tickets;   
                });
            },
            getMyTickets(page=1){
                axios.get('/api/tickets/ticket/personal?page='+page)
                .then(response=>{
                    this.my_tickets = response.data.my_tickets;   
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