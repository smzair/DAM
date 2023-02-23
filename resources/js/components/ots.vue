<template>
   

<div class="pr-pl-3">
        <div class="card">
            <div class="card-header ui-sortable-handle " style="cursor: move;">
                <h3 class="card-title ">
                    <i class="fas fa-users mr-1"></i>
                    Users
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item mt-1 mr-1">
                            <button class="btn btn-sm btn-primary"  @click="createMode"><i class="fas fa-plus-circle" ></i> Add New</button>
                        </li>
                    
                        <li class="nav-item">
                            <div class="input-group mt-1 input-group-sm" style="width: 350px;">
                                <input type="text" name="table_search" v-model="searchWord" class="form-control float-right" placeholder="Search by name, email">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default" @click="search"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div></div>

</template>

<script >


  $('.itemName').select2({
    placeholder: 'Select an item',
    ajax: {
      url: '/select2-autocomplete-ajax',
      dataType: 'json',
      delay: 250,
      processResults: function (user) {
        return {
          results:  $.map(user, function (item) {
                return {
                    text: user.Company,
                    id: user.id
                }
            })
        };
      },
      cache: true
    }
  });


</script>



 







