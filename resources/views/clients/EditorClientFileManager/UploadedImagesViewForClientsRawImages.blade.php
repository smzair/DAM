<div class="content custom-dashboard-content">
		<div class="container-fluid">
            <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-transparent card-info mt-3">
                            <div class="card-header">
                                <h6 class="card-title">All Images</h6>
                            </div>
                            <div class="row">
                                @foreach($file_data as $object)
                                    @php
                                        $img_created_at = $object->created_at;
                                        $wrc_created_at  = $object->wrc_created_at;
                                        $file_name  = $object->filename;
                                        $wrc_no  = $object->wrc_id;
                                        $lot_no  = $object->lot_id;
                                        $year = date('Y',strtotime($wrc_created_at));
                                        $month = date('M',strtotime($wrc_created_at));
                                        $sku_code = $object->sku_code;
                                        $sourcePath =  "raw_img_directory/".  $year . "/" . $month . "/" . $lot_no . "/" . $wrc_no . "/" . $sku_code."/".$file_name;
                                        // echo $file_name;
                                        // Check if the file exists
                                        $file_exists = file_exists(public_path($sourcePath));
                                    @endphp
                            
                                    @if ($file_exists)
                                        <div class="col-md-2">
                                            <div class="justify-content-between align-content-center">
                                                <div class="text-center">
                                                    <a ondblclick="navigateToLink('client-all-images/{{$object->id}}')">
                                                        <img style="cursor: pointer" class="justify-content-between align-content-center" src="{{asset($sourcePath)}}" width="100" height="150"/>
                                                        <span>{{ $object->filename }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
		</div>
</div>