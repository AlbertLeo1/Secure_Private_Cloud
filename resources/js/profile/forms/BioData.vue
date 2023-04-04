<template>
<div>
<form>
    <alert-error :form="BioData"></alert-error> 
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="BioData.first_name" :class="{'is-invalid' : BioData.errors.has('first_name') }">
                <has-error :form="BioData" field="first_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="BioData.middle_name" :class="{'is-invalid' : BioData.errors.has('middle_name') }"/>
                <has-error :form="BioData" field="middle_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="BioData.last_name" :class="{'is-invalid' : BioData.errors.has('last_name') }" />
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Get Address -->
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address*</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Enter Address *" required v-model="BioData.street" :class="{'is-invalid' : BioData.errors.has('street') }" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address2</label>
                <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Street Desc" v-model="BioData.street2" :class="{'is-invalid' : BioData.errors.has('street2') }">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
                <label>City*</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="BioData.city" :class="{'is-invalid' : BioData.errors.has('city') }">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="BioData.state_id" :class="{'is-invalid' : BioData.errors.has('state_id') }">
                    <option value="">--Select State--</option>
                    <option v-for="state in states" v-bind:key="state.id" :value="state.id" >{{state.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
                <label>LGA</label>
                <select class="form-control" id="area_id" name="area_id" required v-model="BioData.area_id" :class="{'is-invalid' : BioData.errors.has('area_id') }">
                    <option value="">--Select area--</option>
                    <option v-for="area in areas" v-bind:key="area.id" :value="area.id" >{{area.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
                <label>Country</label>
                <select class="form-control" id="nation_id" name="nation_id" required v-model="BioData.nation_id" :class="{'is-invalid' : BioData.errors.has('nation_id') }">
                    <option value="">--Select nation--</option>
                    <option v-for="nation in nations" v-bind:key="nation.id" :value="nation.id" >{{nation.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="BioData.phone" :class="{'is-invalid' : BioData.errors.has('phone') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Alternate Phone</label>
                <input type="text" class="form-control" id="alt_phone" name="alt_phone" placeholder="Alternate Phone Number" v-model="BioData.alt_phone" :class="{'is-invalid' : BioData.errors.has('alt_phone') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="BioData.email" :class="{'is-invalid' : BioData.errors.has('email') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Alternate Email Address</label>
                <input type="email" class="form-control" id="personal_email" name="personal_email" placeholder="Enter Email Address *" required v-model="BioData.personal_email" :class="{'is-invalid' : BioData.errors.has('personal_email') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" id="sex" name="sex" required v-model="BioData.sex" :class="{'is-invalid' : BioData.errors.has('sex') }">
                    <option value="">---Select Sex---</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="BioData.dob" :class="{'is-invalid' : BioData.errors.has('dob') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Profile Picture</label>
            <div class="form-group">
                <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="BioData.id">
    </div>
    <button @click.prevent="updateBioData" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            BioData: new Form({
                alt_phone:'', 
                area_id:'', 
                city:'', 
                dob:'', 
                email:'',
                first_name: '', 
                id:'', 
                image:'', 
                last_name:'', 
                middle_name:'', 
                password:'', 
                personal_email: '', 
                phone:'', 
                roles:'',
                sex:'', 
                state_id:'', 
                street:'', 
                street2:'',
            }),
        }
    },
    mounted() {
        Fire.$on('BioDataFill', user =>{
            this.BioData.fill(user);
            console.log("Get Here");
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.BioData.fill(data)));
        });
    },
    methods:{
        updateBioData(){
            console.log("Tested");
            this.$Progress.start();
            this.BioData.post('/api/ums/bios')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Profile details has been updated',
                    showConfirmButton: false,
                    timer: 1500
                    });
                })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
                });  
                    
        },
        getProfilePic(){
            let photo = (this.BioData.image.length >= 150) ? this.BioData.image : "./"+this.BioData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {this.BioData.image = reader.result}
                reader.readAsDataURL(file)
            }
            else{
                Swal.fire({type: 'error', title: 'File is too large'});
            }
        },
    },
    props:{
        areas: Array,
        states: Array,
        nations: Array,
        user: Object,
        editMode: Boolean,
    }
}
</script>
