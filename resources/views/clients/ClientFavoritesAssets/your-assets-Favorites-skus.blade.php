<div class="row">
  <p class="fovourites-img-lot-sku-wrc-section">SKUs</p>

  @if (count($skus_data) > 0)
    @foreach ($skus_data as $key => $item)
      @php
      // dd($skus_data);
        $type = $item['type'];
        $other_data = json_decode($item['other_data'],true);
        $row = $item['raw_skus_data'];
        $file_path = $row['file_path'];
        $shoot_image_src = 'IMG/no_preview_available.jpg';
        if($file_path != ''){
          $shoot_image_src = $file_path;
        }
        if($type == 'Raw'){
          $sku_files_images_image_route = 'your_assets_files_shoot_raw_images';
          $download_route_is = "download_Shoot_lot_raw_sku";
          $sku_img_type = $type;
        }else{
          // dd($item,$other_data);
          $adaptation = base64_encode($other_data['adaptation']);
          $sku_img_type = $adaptation;


          $sku_files_images_image_route = 'your_assets_shoot_edited_images';
          $download_route_is = "download_Shoot_lot_Edited_adaptation";
        }
        $sku_id_is = base64_encode($row['sku_id']);
        $tbl_id = $item['id'];

      @endphp

      <div class="col-lg-3 col-md-6 SKU-BOX-STYLE" id="div_{{$tbl_id}}">
        <div class="row brand-div" style="position: relative;">

          <div class="col-2">
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M23.5735 13.0404C23.5407 13.194 23.4783 13.3428 23.4167 13.486C23.2951 13.7676 23.1695 14.0476 23.0335 14.322C22.0167 16.3748 20.9847 18.4204 19.9703 20.4748C19.5743 21.2772 18.9519 21.6556 18.0567 21.6548C12.7055 21.6476 7.35429 21.65 2.00309 21.6524C1.42469 21.6524 0.829492 21.4044 0.559893 20.8636C0.411093 20.5652 0.562292 20.3028 0.692692 20.0308C0.796692 19.8132 0.900692 19.5964 1.00549 19.3788C1.21349 18.9444 1.42149 18.51 1.62949 18.0748C1.83749 17.6404 2.04549 17.2052 2.25269 16.7708C2.46069 16.3356 2.66789 15.9012 2.87509 15.466C3.08229 15.0308 3.28949 14.5956 3.49669 14.1604C3.70389 13.7252 3.91029 13.29 4.11749 12.8548C4.22629 12.626 4.33429 12.398 4.44309 12.1692C4.83429 11.3452 5.47589 10.9356 6.37909 10.9348C11.4439 10.9324 16.5079 10.9308 21.5727 10.9364C22.0591 10.9364 22.5511 11.0556 22.9239 11.382C23.2063 11.6292 23.4223 11.9604 23.5303 12.3204C23.5847 12.502 23.6103 12.6924 23.5975 12.882C23.5943 12.9356 23.5863 12.9884 23.5743 13.0404H23.5735Z" fill="white"/>
              <path d="M0.408809 17.4766C0.400009 17.4646 0.399209 17.447 0.400809 17.4326C0.406409 17.3726 0.405609 17.3126 0.405609 17.2526C0.405609 13.2534 0.405609 9.25342 0.405609 5.25422C0.405609 4.23902 0.973609 3.67102 1.99041 3.67022C3.71841 3.67022 5.44641 3.67582 7.17441 3.66702C7.79921 3.66382 8.27521 3.90222 8.62961 4.41902C9.03921 5.01582 9.47361 5.59582 9.88721 6.19022C9.98721 6.33422 10.092 6.39262 10.272 6.39182C12.9736 6.38542 15.6752 6.38862 18.3768 6.38622C18.9816 6.38622 19.4728 6.59742 19.764 7.14702C19.856 7.32062 19.9128 7.53182 19.92 7.72782C19.9408 8.31582 19.9288 8.90462 19.9288 9.49342C19.9288 9.52942 19.9192 9.56542 19.9112 9.62302C19.8 9.62302 19.696 9.62302 19.592 9.62302C14.936 9.62302 10.28 9.62462 5.62401 9.62142C4.91121 9.62142 4.30321 9.83262 3.86801 10.423C3.76641 10.5614 3.68801 10.719 3.61361 10.875C2.59281 13.0094 1.57441 15.1446 0.555209 17.2798C0.540009 17.3118 0.524009 17.343 0.508809 17.375C0.494409 17.4046 0.483209 17.439 0.464009 17.467C0.452009 17.4846 0.425609 17.499 0.408809 17.4774V17.4766Z" fill="white"/>
            </svg>
          </div>

          <div class="col-8">
            <a style="text-decoration: none;" href="{{route($sku_files_images_image_route , [ $sku_id_is ] )}}">
              <p class="brand-text" id="lot_number{{$row['sku_id'].$key}}">{{$row['sku_code']}}</p>
            </a>
          </div>

          <div class="col-2">
            <i class="bi bi-three-dots-vertical test myButton" style="font-size:20px;color: #808080;" role="button"></i>
              <div class="myPopover" style="display: none;">
                
                @if ($type == 'Raw')
                  <a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($row['wrc_id']) , 'sku_id' => base64_encode($row['sku_code']) ] )}}">
                @else
                  <a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($item['wrc_id']) , 'adaptation' => $adaptation , 'sku_id' => base64_encode($row['sku_code']) ] )}}">
                    
                @endif
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  &nbsp;&nbsp;
                  Download
                </a>
                
                {{-- View Details --}}
                <a class="view_details" href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['sku_id'].$key}}); lots_details('{{ $sku_id_is  }}' , 'sku' , '{{$sku_img_type}}') ">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1043_2491)">
                      <path d="M9.99992 13.334L9.99992 9.16732M9.99992 1.66732C5.41658 1.66732 1.66658 5.41732 1.66658 10.0007C1.66659 14.584 5.41659 18.334 9.99992 18.334C14.5833 18.334 18.3333 14.584 18.3333 10.0007C18.3333 5.41732 14.5833 1.66732 9.99992 1.66732Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M10.0042 6.66602L9.99665 6.66602" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_1043_2491">
                      <rect width="20" height="20" fill="white"/>
                      </clipPath>
                    </defs>
                  </svg>
                  &nbsp;&nbsp;
                  View Details
                </a>

                <div class="d-none">
                  <span id="lot_date{{$row['sku_id'].$key}}">{{dateFormet_dmy($row['sku_created_at'])}}</span>
                  <span id="lot_time{{$row['sku_id'].$key}}">{{date('h:i A', strtotime($row['sku_created_at']))}}</span>
                  <span id="image_src{{$row['sku_id'].$key}}">{{asset($shoot_image_src)}}</span>
                </div>


                {{-- Share --}}

                {{-- Click btn --}}
                @if ($type == 'Raw')
                  <a data-id="{{$row['sku_id'].$key}}" data-url="{{route($download_route_is , [ 'wrc_id' => base64_encode($row['wrc_id']) , 'sku_id' => base64_encode($row['sku_code'])])}}"  href="javascript:void(0)" class="share_popover_trigger">
                @else
                  <a data-id="{{$row['sku_id'].$key}}" data-url="{{route($download_route_is , [ 'wrc_id' => base64_encode($item['wrc_id']) , 'adaptation' => $adaptation, 'sku_id' => base64_encode($row['sku_code']) ] )}}"  href="javascript:void(0)" class="share_popover_trigger">
                @endif
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  &nbsp;&nbsp;
                  Share
                </a>

                {{-- copy btn --}}
                <a class="d-none" id="{{$row['sku_id'].$key}}" href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['sku_id'].$key}}' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')" >
                  Share
                </a>


                @if ($type == 'Raw')
                <p class="d-none" id="url_{{$row['sku_id'].$key}}">{{route($download_route_is , [ 'wrc_id' => base64_encode($row['wrc_id']) , 'sku_id' => base64_encode($row['sku_code'])])}}</p>
                @else
                <p class="d-none" id="url_{{$row['sku_id'].$key}}">{{route($download_route_is , [ 'wrc_id' => base64_encode($item['wrc_id']) , 'adaptation' => $adaptation, 'sku_id' => base64_encode($row['sku_code']) ] )}}</p>
                @endif
                
                @php
                  $service = base64_encode('SHOOT');
                  $module = base64_encode('sku');
                  $lot_id_is = base64_encode($item['lot_id']);
                  $wrc_id_is = base64_encode($item['wrc_id']);
                  $sku_code_is = base64_encode($row['sku_code']);
                  $data_array = array(
                    'user_id' => '', 
                    'brand_id' => '', 
                    'lot_id' => $lot_id_is, 
                    'wrc_id' => $wrc_id_is,
                    'service' => $service, 
                    'module' => $module,
                    'other_data' => [
                      'sku_id' => $sku_id_is,
                      'sku_code' => $sku_code_is,
                      'type' => 'Raw'
                    ]
                  );

                  $data_obj = json_encode($data_array,true);
                @endphp

                {{-- Remove from Favorites --}}
                <a href="javascript:void(0)" onclick="remove_favorites('{{base64_encode($tbl_id)}}')">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1043_2500)">
                      <path d="M11.4416 2.92422L12.9083 5.85755C13.1083 6.26589 13.6416 6.65755 14.0916 6.73255L16.7499 7.17422C18.4499 7.45755 18.8499 8.69089 17.6249 9.90755L15.5583 11.9742C15.2083 12.3242 15.0166 12.9992 15.1249 13.4826L15.7166 16.0409C16.1833 18.0659 15.1083 18.8492 13.3166 17.7909L10.8249 16.3159C10.3749 16.0492 9.63326 16.0492 9.17492 16.3159L6.68326 17.7909C4.89992 18.8492 3.81659 18.0576 4.28326 16.0409L4.87492 13.4826C4.98326 12.9992 4.79159 12.3242 4.44159 11.9742L2.37492 9.90755C1.15826 8.69089 1.54992 7.45755 3.24992 7.17422L5.90826 6.73255C6.34992 6.65755 6.88326 6.26589 7.08326 5.85755L8.54992 2.92422C9.34992 1.33255 10.6499 1.33255 11.4416 2.92422Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_1043_2500">
                        <rect width="20" height="20" fill="white"/>
                      </clipPath>
                    </defs>
                  </svg>
                  &nbsp;&nbsp;
                  Remove from favorites
                </a>
              </div>
          </div>
        </div>
      </div>
        
    @endforeach
      
  @else
    <div class="col-sm-6 col-md-4 col-lg-3">
      <p class="underheadingF">No Skus</p>
    </div>
  @endif
</div>