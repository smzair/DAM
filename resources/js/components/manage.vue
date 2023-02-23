<template>


<div class="px-3">
<div class="card">
<div class="card-header ui-sortable-handle" style="cursor: move;">
<h3 class="card-title md-2 ">
<i class="fas fa-users mr-1"></i>
Users 
</h3> 
<br>
<div>
<p style="font-size:12px;" class="card-title mt-1 md-1 d-none">
<i class="fas fa-info-circle mr-1"></i>
 To register a new client or a user, click on <strong>Add New</strong> | To tag a brand, click on the edit option and update  
</p>
</div>


<div class="card-tools">
<ul class="nav nav-pills ml-auto">
<li class="nav-item mt-2 mr-1">
<button class="btn btn-sm btn-primary"  @click="createMode"><i class="fas fa-plus-circle" ></i> Add New</button>
</li>

<li class="nav-item mt-2">
<div class="input-group mt-0 input-group-sm">
<input type="text" name="table_search" v-model="searchWord" class="form-control float-right" placeholder="Search by name or email">

<div class="input-group-append">
<button type="submit" class="btn serc-btn btn-default" @click="search"><i class="fas fa-search"></i></button>
</div>
</div>
</li>
</ul>
</div>
</div><!-- /.card-header -->
<div class="card-body table-responsive p-0">
<table class="table">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Role</th>
<th>Client id</th>
<th>Email</th>
<th>Account Manager</th>
<th>C Name</th>
<th>Brands</th>
<th>Address</th>
<th>GST No</th>
<th>Action</th>
<th>Date Posted</th>
</tr>
</thead>
<tbody>
<tr v-for="user in users" :key="user.id">
<td>{{user.id}}</td>
<td>{{user.name}}</td>
<td>{{user.role}}</td>
<td>{{user.client_id}}</td>
<td>{{user.email}}</td>
<td>{{user.am_email}}</td>
<td>{{user.Company}}</td>
<td> {{user.brands_name}}</td>
<td>{{user.Address}}</td>
<td>{{user.Gst_number}}</td>
<td>
<button class="btn-sm btn-info" @click="viewUser(user)"> <i class="fa fa-eye"></i> View</button>
<button class="btn-sm btn-warning"  @click="editUser(user)"> <i class="fa fa-edit"></i> Edit</button>

<button class="btn-sm btn-danger" @click="deleteUser(user)" > <i class="fa fa-trash"></i> Delete </button>
</td>
<td>
{{user.created_at | date}}
</td>
</tr>
</tbody>
</table>
</div>
<div class="text-center" v-if="loading">
<b-spinner variant="info" class="mt-5 mb-5" style="widht:15rem ; height :15rem " label="text-center"></b-spinner>
</div>
</div>

<div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class=modal-body> 
<div class="row">
<div class="col-md-6" id="bootstap-table">
<p><b>Name:</b> {{ user.name }}</p>
<p><b>Client Id:</b> {{ user.client_id }}</p>
<p><b>Email:</b> {{ user.email }}</p>
<p><b>Account Manager Email:</b> {{ user.am_email}}</p>
<p><b>Phone:</b> {{ user.phone}}</p>
<p><b>Company Name:</b> {{ user.Company}}</p>
<p><b>Brands:</b> {{ user.brands_name}}</p>
<p><b>Address:</b> {{ user.Address}}</p>
<p><b>GST_number:</b> {{ user.Gst_number}}</p>
<p><b>Last Updated:</b> {{ user.updated_at | date }}</p>
<p><b>Date Posted:</b> {{ user.created_at | date }}</p>
</div>

<div class="col-md-6">
<img :src="img" class="img-circle">
</div>
</div>

</div>
</div>
</div>
</div>

<div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="createUserModalLabel" v-show="!editMode" >Create User</h5>
<h5 class="modal-title" id="createUserModalLabel" v-show="editMode">Edit User</h5>

<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<form @submit.prevent="!editMode ? createUser():updateUser() ">

<div class="form-group">
<label  class="control-label required"> Select Role </label>
<b-form-select 
v-model="form.role"
:options="roles"
text-field="name"
value-field="id"

>
</b-form-select>
<has-error :form="form" field="role"></has-error>
</div>

<div class="form-group">
<label  class="control-label required"> Select Assigned AM </label>

<b-form-select 
placeholder=""
v-model="form.am"
:options="accountms"
text-field="name"
value-field="email"

>

</b-form-select>
<has-error :form="form" field="am"></has-error>

</div>
<div class="form-group">
<label  class="control-label required"> Name </label>
<input v-model="form.name" type="text" name="name" placeholder="Name"
class="form-control" :class="{'is-invaild': form.errors.has('name')}">
<has-error :form="form" field="name"></has-error>
</div>

<div class="form-group">
<label  class="control-label requiredu"> Email </label>
<input v-model="form.email" type="text" name="email" placeholder="Email"
class="form-control" :class="{'is-invaild': form.errors.has('email')}">
<has-error :form="form" field="email"></has-error>
</div>

<div class="form-group">
<label  class="control-label required requiredu"> Client ID </label><v-textfield class="required"></v-textfield>
<input v-model="form.client_id" type="text" name="client_id" placeholder="Client Id"
class="form-control" :class="{'is-invaild': form.errors.has('client_id')}">
<has-error :form="form" field="client_id"></has-error>
</div>

<div class="form-group">
<label  class="control-label required"> Address </label>
<input v-model="form.Address" type="text" name="Address" placeholder="Address"
class="form-control" :class="{'is-invaild': form.errors.has('Address')}">
<has-error :form="form" field="Address"></has-error>
</div>

<div class="form-group">
<label  class="control-label requiredu"> GST Number </label>
<input v-model="form.Gst_number" type="text" name="Gst_number" placeholder="Gst number"
class="form-control" :class="{'is-invaild': form.errors.has('Gst_number')}">
<has-error :form="form" field="Gst_number"></has-error>
</div>

<div class="form-group">
<label  class="control-label required"> Phone Number </label><input v-model="form.phone" type="text" name="phone" placeholder="Phone Number"
class="form-control" :class="{'is-invaild': form.errors.has('phone')}">
<has-error :form="form" field="phone"></has-error>
</div>

<div class="form-group">
<label class="control-label required"> Company Name </label>
<input v-model="form.Company" type="text" name="Company" placeholder="Company Name"
class="form-control" :class="{'is-invaild': form.errors.has('Company')}">
<has-error :form="form" field="Company"></has-error>
</div>

<div class="form-group">
<label class="control-label requiredu"> Company Short Name </label>
<input v-model="form.c_short" type="text" name="c_short" placeholder="Any Two Prefix"
required  class="form-control" :class="{'is-invaild': form.errors.has('c_short')}" >
<has-error :form="form" field="c_short"></has-error>
</div>

<div class="form-group" v-if="load"  v-show="editMode">
<label for="tags-pills" class="control-label required">Brand</label>



<b-form-select 
multiple  
v-model="selectedBrands"
:options="brands"
text-field="name"
value-field="id"
>
</b-form-select>

</div>


</form>
</div>
<div class="modal-footer justify-content-between">
<button type="button"  class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
<b-button variant="primary" v-if="!load" class="btn-lg" disabled>
<b-spinner small></b-spinner>
{{action}}
</b-button>
<button type="submit"  v-if="load" v-show="!editMode" @click.prevent="createUser()" class="btn btn-lg btn-primary">Save User</button>
<button type="submit" v-if="load"  v-show="editMode" @click.prevent="updateUser()" class="btn btn-lg btn-success">Update User</button>
</div>

</div>
</div>
</div>
</div>



</template>

<script>
export default {
data(){
return{
action : '',
searchWord:'',
loading: false,
editMode:false, 
load:true,
img:"http://127.0.0.1:8000/dist/img/uploads/avatars/avatar.jpg"  ,
user:{},
users:[],
roles:[],
brand:[],
permissions:[],
brands: [],
accountms:[],
selectedBrands: [],
form: new Form({
'id':'',
'name':'',
'email':'',
'Company':'',
'brand':'',
'client_id':'',
'phone':'',
'Address':'',
'Gst_number':'',
'permissions': [],
'role':'12',
'c_short':'',
'am':'am@odndigital.com',

})
}
},
methods:{

search(){
this.loading = true;
axios.get('/search/user?s='+this.searchWord).then((response)=>{
this.loading=false ;
this.users= response.data.users       
}).catch(()=>{
this.loading=false;
toast.fire({
icon:'error',
title: "search failed"
})
})
},
createMode(){
this.editMode= false;
this.form.reset();
this.selectedBrands = [];
$('#createUser').modal('show')
},
editUser(user){
this.editMode= true;
this.form.reset();
this.form.fill(user);
this.form.role= user.roles[0].id;
this.form.am= user.am_email;
this.form.permissions= user.userPermissions;
this.selectedBrands = user.brand_ids;
$('#createUser').modal('show')

},
getUsers(){
this.loading=true;
axios.get('/getAllUsers').then((response)=>{
this.loading=false;
this.users = response.data.users
}).catch(()=>{
this.loading=false;
this.$toastr.e("Cannot load users", "Error");

})
},
viewUser(user){ 
$('#viewUser').modal('show'); 
this.img='http://127.0.0.1:8000/dist/img/uploads/avatars/'+ user.photo;
this.user = user;
},

getBrands(){
axios.get('/get-all-brands').then((response) =>{
this.brands = response.data.brands });
},

getAm(){
axios.get('/get-All-Am').then((response) =>{
this.accountms = response.data.accountms });
},

getRoles(){
axios.get('/getAllRoles').then((response) =>{
this.roles= response.data.roles });
},

getPermissions(){
axios.get('/getAllPermissions').then((response) =>{
this.permissions= response.data.permissions });

},
createUser(){
this.action ='creating user....'
this.load=false;
this.form.post("/account/store").then((response)=>{
this.load=true;
this.$toastr.s("User created Successfully", "Created");
Fire.$emit("loadUser");
$("#createUser").modal("hide");
this.form.reset();

}).catch(()=>{
this.load=true;
this.$toastr.e("Cannot create user, try again", "Error");
});
},
updateUser(){
this.action ='updating user....'
this.load=false;
let postData = this.form;
postData.brands = this.selectedBrands;
postData.put("/account/update/" +this.form.id).then((response)=>{
this.load=true;
this.$toastr.s("User info updated Successfully", "Created");
Fire.$emit("loadUser");
$("#createUser").modal("hide");
this.form.reset();

}).catch(()=>{
this.load=true;
this.$toastr.e("Cannot update user info, try again", "Error");
});
},
deleteUser(user)

{

swal.fire({
title: 'Are you sure?',
text: user.name + ' will be deleted permanently! ',
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.value) {
axios.delete('/delete/user/'+ user.id).then(()=>{

toast.fire({
icon:'success',
title: user.name+'Deleted Successfully'
})           
Fire.$emit("loadUser");
}).catch(()=>{
toast.fire({
icon:'error',
title: user.name+ "was unable to delete, try again later "
})
})

}
})
}

},
mounted(){
this.getBrands();
},
created(){
this.getAm();
this.getUsers();
this.getRoles();
this.getPermissions();
Fire.$on('loadUser',()=>{
this.getUsers();
});
}
}

</script>




