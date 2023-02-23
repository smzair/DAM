
<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-warning mt-5">
                    <div class="card-header">
                        <h3 class="card-title">Contact Us</h3>
                    </div>
                    <div class="card-body"> 
                        <form method="post" action="www.myform.com">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2 select2bs4 select2-hidden-accessible" aria-hidden="true" style="width: 100%;">
                                            <option disabled selected>Please Select</option>
                                          
                                            <option>Laptop</option>
                                            <option>Macbook</option>
                                            <option>Ipad</option>
                                            <option>Iphone</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Brands</label>
                                        <select class="form-control">
                                            <option disabled selected>Please Select</option>
                                            <option>Brand 1</option>
                                            <option>Brand 2</option>
                                            <option>Brand 3</option>
                                            <option>Brand 4</option>
                                            <option>Brand 5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" onclick="" class="btn btn-primary swalDefaultSuccess">Grenerate Lot No. </button>
                                </div>
                            </div>
                        </form>
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


          }

      }
}
</script>



   