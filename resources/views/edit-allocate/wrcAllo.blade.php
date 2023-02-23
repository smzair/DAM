<div class="allocation-wrc-main">
    <div class="container-fluid" >
       <div class="row">
        <div class="col-12">
            <div class="card card-transparent wrapper-transparent">
                <div class="card-header">
                    <h3 class="card-title">
                        LOT Number: <b>{{$lot_id}}</b>
                    </h3>
                    <span class="close"><i class="fas fa-times"></i></span>
                    <div class="mailbox-controls float-right">
                        <!-- Check all button -->
                        <div class="btn-group check-pop">
                            <a href="javaScript:void(0)" id="wrcalo" onclick="getWrcdata()" class="btn btn-default btn-sm checkbox-toggle-popup wrc-toggle-check" style="display: none;" >
                                Click To Allocate
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-transparent">
                                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                                    <table class="table text-nowrap">
                                        <thead>
                                            <tr>

                                                <th class="border-0 align-top shadow-none">WRC Number</th>
                                                <th class="border-0 align-top shadow-none">Total Image Count</th>
                                                <th class="border-0 align-top shadow-none">Type Of Shoot</th>
                                                <th class="border-0 align-top shadow-none">Type Of Clothing</th>
                                                <th class="border-0 align-top shadow-none">Adaptations List</th>
                                                <th class="border-0 align-top shadow-none">More</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allo as $wrc)
                                            <tr class="pt-0 border-0 pb-0">
                                                <td class="align-top shadow-none">{{$wrc['wrc_id']}}</td>
                                                <td class="align-top shadow-none">{{$wrc['inward_count']}}</td>
                                                <td class="align-top shadow-none">{{$wrc['type_of_shoot']}}</td>
                                                <td class="align-top shadow-none">{{$wrc['type_of_clothing']}}</td>
                                                <td class="align-top shadow-none">{{$wrc['adaptation_1']}}</br>{{$wrc['adaptation_2']}}</br>{{$wrc['adaptation_3']}}</br>{{$wrc['adaptation_4']}}</br>{{$wrc['adaptation_5']}}
                                                </td>
                                                <!--<input type="hidden" name="wrc_id" value="{{$wrc['wrc_Id']}}">-->
                                                <td class="align-top shadow-none">
                                                    <button href="javascript:void(0);" type="button" class="btn btn-warning"  data-wrc_id="{{$wrc['wrc_Id']}}" id="allocateBTn" onclick="getWrcdata(this)">Click to Allocate</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

   function toggleAllocateWRCBtn(){
    var checked_countWRC = 0;
    $('.check-wrc').each(function(){
        if($(this).prop('checked')){
            checked_countWRC++;
        }
    });
    $('.allocation-wrc-main').removeClass('show-wrc-alloc-btn');
    if(checked_countWRC > 0){
        $('.allocation-wrc-main').addClass('show-wrc-alloc-btn');
    }
}

$(".check-wrc").click(function () {
    toggleAllocateWRCBtn();
});

function getWrcdata(obj){
  
    var wrc_id = $(obj).data('wrc_id');
    alert (wrc_id);
    $.ajax({
        url: "/allocation-ajax",
        method: 'GET',
        dataType: "html",
        data: { wrc_id: wrc_id },
        success: function(htmlData) {
            $('#allo-dynamic').html(htmlData);
            select2();
            $('#allocation').modal();
            $(".loader").hide();
        } 

    });
};

// function skuAllo(obj) {

//     $.ajax({
//         url: "/allocation-ajax",
//         method: 'GET',
//         dataType: "html",
//         data: {wrc_id: wrc_id},
//         success: function (htmlData) {
//             $('#dynamic_timline').html(htmlData);
//             $('#wrcStatus').modal();

//         }

//     });

// }

</script>



