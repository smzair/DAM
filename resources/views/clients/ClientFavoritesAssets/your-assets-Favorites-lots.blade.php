<div class="row">

    <div class="col-sm-12 col-md-12 col-lg-12">
      <p class="fovourites-img-lot-sku-wrc-section">Shoot & Post-production Lots</p>
    </div>

    @php
      // dd($files_lots , $link_lots);
    @endphp

    @if (count($files_lots) > 0)
      @foreach ($files_lots as $lot_index_is => $item)
        @php
        $lot_index = $item['id'].$lot_index_is;
          $service = $item['service'];
          $tbl_id = $item['id'];
          if($service == 'SHOOT'){
            $route_is = 'your_assets_shoot_wrcs';
            $download_route_is = "download_Shoot_Lot_edited";
          }elseif($service == 'EDITING'){
            $route_is = 'your_assets_editing_wrcs';
            $download_route_is = "download_Editing_Lot_edited";
          }

          $row = $item['lots_data_is'];
          if($service == 'SHOOT' || $service == 'EDITING'){
            $file_path = $row['file_path'];
            $shoot_image_src = 'IMG/group_10.png';
            $shoot_image_src1 = 'IMG/no_preview_available.jpg';
            if($file_path != ''){
              $shoot_image_src = $file_path;
              $shoot_image_src1 = $file_path;
            }
          }
        @endphp

        {{-- Shoot Lots --}}
        @if ($service == 'SHOOT')
          <div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;" id="div_{{$tbl_id}}">
            <div class="row">
              <div class="under-content-div">
                <div class="col-12">
                  <a href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">
                    <img  style="width: 100%; min-height: 393px;"  src="{{ asset($shoot_image_src1)}}" alt="" class="img-fluid">
                  </a>
                </div>
                <div class="col-12 d-flex justify-content-between">
                  <div>
                    <p class="lot-no-heading">Lot no</p>
                    <span class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$lot_index}}">{{$row['lot_number']}}</span>&nbsp;&nbsp;
                    <div class="myPopover" style="display: none;">
                      @php
                        $lot_id_is = base64_encode($row['lot_id']);
                      @endphp
                      {{-- Download --}}
                      <a href="{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>&nbsp;
                        Download
                      </a>

                      {{-- View Details --}}
                      <a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['lot_id'].$lot_index}}, 'shoot');lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g clip-path="url(#clip0_1069_2515)">
                            <path d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.0042 6.66699L9.99665 6.66699" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </g>
                          <defs>
                            <clipPath id="clip0_1069_2515">
                              <rect width="20" height="20" fill="white"/>
                            </clipPath>
                          </defs>
                        </svg>&nbsp;
                        View Details
                      </a>

                      <div class="d-none">
                        <span id="lot_date{{$row['lot_id'].$lot_index}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
                        <span id="lot_time{{$row['lot_id'].$lot_index}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
                        <span id="image_src{{$row['lot_id'].$lot_index}}">{{asset($shoot_image_src1)}}</span>
                        <span id="skus_count{{$row['lot_id'].$lot_index}}">{{ $row['skus_count'] }}</span>
                        <span id="raw_images{{$row['lot_id'].$lot_index}}">{{ $row['raw_images'] }}</span>
                        <span id="edited_images{{$row['lot_id'].$lot_index}}">{{ $row['edited_images'] }}</span>
                        <span id="s_type{{$row['lot_id'].$lot_index}}">{{ $row['s_type'] }}</span>
                        <span id="wrc_numbers{{$row['lot_id'].$lot_index}}">{{ $row['wrc_numbers'] }}</span>
                      </div>
                      {{-- Share --}}
                      {{-- Click btn --}}
                      <a href="javascript:void(0)" data-id="{{$row['lot_id'].$lot_index}}" data-url="{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}" class="share_popover_trigger">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>&nbsp;
                        Share
                      </a>

                      {{-- copy btn --}}
                      <a class="d-none" id="{{$row['lot_id'].$lot_index}}" href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['lot_id'].$lot_index}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>&nbsp;
                        Share
                      </a>
                      <p class="d-none" id="url_{{$row['lot_id'].$lot_index}}">{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}</p>

                      @php
                        $service = base64_encode('SHOOT');
                        $module = base64_encode('lot');
                        $lot_id_is = base64_encode($row['lot_id']);
                        $data_array = array(
                          'user_id' => '', 
                          'brand_id' => '', 
                          'lot_id' => $lot_id_is, 
                          'wrc_id' => '',
                          'service' => $service, 
                          'module' => $module 
                        );

                        $data_obj = json_encode($data_array,true);
                      @endphp
                      {{-- Add to favorites --}}
                      {{-- <a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g clip-path="url(#clip0_1069_2524)">
                          <path d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          </g>
                          <defs>
                          <clipPath id="clip0_1069_2524">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                          </defs>
                        </svg>&nbsp;
                        Add to favorites
                      </a> --}}

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

                  <div type="button" class="btn border-0 rounded-circle myButton">
                    <i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
                    </i>
                  </div>
                </div>
                <div class="col-12">
                    <span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}}</span>
                </div>
                <div class="col-12 d-flex justify-content-between">
                  <div>
                    <p class="inward-qty">Inward Quantity : </p>
                    <p class="inward-qty-num">
                      {{$row['inward_qty']}}
                    </p>
                  </div>
                  <div>
                    <p class="inward-qty">Submission</p>
                    <p class="inward-qty-num">{{dateFormet_dmy($row['submission_date'])}}</p>
                  </div>
                </div>
                <div class="col-12 d-grid gap-2">
                  <a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">
                    View images
                  </a>
                </div>
              </div>
            </div>
          </div>

        {{-- Editting Lots --}}
        @elseif($service == 'EDITING')
          <div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;" id="div_{{$tbl_id}}">
            <div class="row">
              <div class="under-content-div">
                <div class="col-12">
                  <a href="{{route('your_assets_editing_wrcs' , [$row['lot_id']])}}">
                    <img  style="width: 100%; min-height: 393px;"  src="{{ asset($shoot_image_src1)}}" alt="" class="img-fluid">
                  </a>
                </div>
                <div class="col-12 d-flex d-flex justify-content-between">
                    <div>
                    <p class="lot-no-heading">Lot no</p>
                    <span class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$lot_index}}">{{$row['lot_number']}}</span>
                    <div class="myPopover" style="display: none;">
                      @php
                          $download_route_is = "download_Editing_Lot_edited";
                          $lot_id_is = base64_encode($row['lot_id']);
                      @endphp
                      {{-- Download --}}
                      <a href="{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id'])  ] )}}">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>&nbsp;
                        Download
                      </a>

                      {{-- View Details --}}
                      <a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['lot_id'].$lot_index}} , 'EDITING'); editing_lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g clip-path="url(#clip0_1069_2515)">
                            <path d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.0042 6.66699L9.99665 6.66699" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </g>
                          <defs>
                            <clipPath id="clip0_1069_2515">
                              <rect width="20" height="20" fill="white"/>
                            </clipPath>
                          </defs>
                        </svg>&nbsp;
                        View Details
                      </a>

                      <div class="d-none">
                        <span id="lot_date{{$row['lot_id'].$lot_index}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
                        <span id="lot_time{{$row['lot_id'].$lot_index}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
                        <span id="image_src{{$row['lot_id'].$lot_index}}">{{asset($shoot_image_src1)}}</span>
                        <span id="wrc_numbers{{$row['lot_id'].$lot_index}}">{{ $row['wrc_numbers'] }}</span>

                      </div>

                      {{-- Click btn --}}
                      
                      <a href="javascript:void(0)" data-id="{{$row['lot_id'].$lot_index}}" data-url="{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}" class="share_popover_trigger">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>&nbsp;
                        Share
                      </a>

                      {{-- copy btn --}}
                      <a class="d-none" id="{{$row['lot_id'].$lot_index}}" href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['lot_id'].$lot_index}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>&nbsp;
                        Share
                      </a>
                      <p class="d-none" id="url_{{$row['lot_id'].$lot_index}}">{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id']) ] )}}</p>
                      
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
                    
                    <div type="button" class="btn border-0 rounded-circle myButton">
                      <i class="bi bi-three-dots-vertical" style="color: #9F9F9F; line-height: 2.5;">
                      </i>
                    </div>
                </div>
                <div class="col-12">
                  <span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date"> {{dateFormet_dmy($row['lot_created_at'])}} </span>
                </div>
                <div class="col-12 d-flex justify-content-between">
                  <div>
                    <p class="inward-qty">Inward Quantity : </p>
                    <p class="inward-qty-num">
                      {{$row['inward_qty']}}
                    </p>
                  </div>
                  <div>
                    <p class="inward-qty">Submission</p>
                    <p class="inward-qty-num">{{dateFormet_dmy($row['submission_date'])}}</p>
                  </div>
                </div>
                <div class="col-12 d-grid gap-2">
                  <a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_editing_wrcs' , [$row['lot_id']])}}">
                    View images
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    @else
      <div class="col-sm-6 col-md-4 col-lg-3">
        <p class="underheadingF">No Lots</p>
      </div>
    @endif
    
</div>
<div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <p class="fovourites-img-lot-sku-wrc-section">Marketing Creative & Listing Lots</p>
  </div>

  @if (count($link_lots) > 0)
    @foreach ($link_lots as $lot_index_is => $item)
      @php
        $service = $item['service'];
        $row = $item['lots_data_is'];
        $lot_index = $item['id'].$item['lot_id'].$lot_index_is;
        $tbl_id = $item['id'];
      @endphp

      {{-- Cataloging Lots --}}
      @if ($service == 'CATALOGING')
        @php
          $lot_created_at = $row['lot_created_at'];
          $submission_date = $row['submission_date'];
          $lot_id_is = base64_encode($row['id']);
          $wrc_numbers = ($row['wrc_numbers'] != '' && $row['wrc_numbers'] != null) ? $row['wrc_numbers'] : 'Wrc not generated'; 
        @endphp

        <div class="col-lg-4 col-md-6 box border-0" style="position: relative;" id="div_{{$tbl_id}}">
          <div class="row">
            <div class="under-content-div">
              <div class="col-12 d-flex d-flex justify-content-between">
                  <div>
                      <p class="lot-no-heading">Lot no</p>
                      <span class="your-asset-lotno-underbox" id="lot_number{{$row['brand_id'].$lot_index}}">{{$row['lot_number']}}</span>
                    <div class="myPopover" style="display: none;">
                      {{-- View Details --}}
                      <a href="javascript:void(0)" onclick="toggleSidebar(); set_links_date_time('{{$row['brand_id'].$lot_index}}' , 'CATALOGING')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g clip-path="url(#clip0_1069_2515)">
                            <path d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.0042 6.66699L9.99665 6.66699" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </g>
                          <defs>
                            <clipPath id="clip0_1069_2515">
                              <rect width="20" height="20" fill="white"/>
                            </clipPath>
                          </defs>
                        </svg>&nbsp;
                        View Details
                      </a>

                      <div class="d-none">
                        <span id="lot_date{{$row['brand_id'].$lot_index}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
                        <span id="lot_time{{$row['brand_id'].$lot_index}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
                        <span id="wrc_numbers{{$row['brand_id'].$lot_index}}">{{ $wrc_numbers }}</span>
                      </div>
                    
                      @php
                        $service = base64_encode($service);
                        $module = base64_encode('lot');
                        $lot_id_is = base64_encode($row['id']);
                        $data_array = array(
                          'user_id' => base64_encode($row['user_id']), 
                          'brand_id' => base64_encode($row['brand_id']), 
                          'lot_id' => $lot_id_is, 
                          'wrc_id' => '',
                          'service' => $service, 
                          'module' => $module 
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
                  <div type="button" class="btn border-0 rounded-circle myButton">
                    <i class="bi bi-three-dots-vertical" style="color: #9F9F9F; line-height: 2.5;">
                    </i>
                  </div>
              </div>

              <div class="col-12">
                <span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}}</span>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <div>
                  <p class="inward-qty">Inward Quantity : </p>
                  <p class="inward-qty-num">
                    {{$row['inward_qty'] != '' ? $row['inward_qty'] : 0}}
                  </p>
                </div>
                <div>
                  <p class="inward-qty">Submission</p>
                  <p class="inward-qty-num">
                    {{$submission_date != '' ? dateFormet_dmy($submission_date) : $submission_date }}
                  </p>
                </div>
              </div>
              <div class="col-12 d-grid gap-2">
                <a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_cataloging_wrcs_links' , ['lot_id' => $lot_id_is])}}">
                  View Links
                </a>
              </div>
            </div>
          </div>
        </div>
      
      
      {{-- Creative Lots --}}
      @elseif($service == 'CREATIVE')
        @php
          $lot_created_at = $row['lot_created_at'];
          $submission_date = $row['submission_date'];
          $wrc_numbers = ($row['wrc_numbers'] != '' && $row['wrc_numbers'] != null) ? $row['wrc_numbers'] : 'Wrc not generated.'; 
          $lot_id_is = base64_encode($row['id']);
        @endphp

        <div class="col-lg-4 col-md-6 box border-0" style="position: relative;" id="div_{{$tbl_id}}">
          <div class="row">
            <div class="under-content-div">
              
              <div class="col-12 d-flex d-flex justify-content-between">
                  <div>
                  <p class="lot-no-heading">Lot no</p>
                  <span class="your-asset-lotno-underbox" id="lot_number{{$row['id'].$lot_index}}">{{$row['lot_number']}}</span>
                  <div class="myPopover" style="display: none;">
                    <a href="javascript:void(0)" onclick="toggleSidebar(); set_links_date_time('{{$row['id'].$lot_index}}' , 'CREATIVE') ">
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1069_2515)">
                          <path d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M10.0042 6.66699L9.99665 6.66699" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                          <clipPath id="clip0_1069_2515">
                            <rect width="20" height="20" fill="white"/>
                          </clipPath>
                        </defs>
                      </svg>&nbsp;
                      View Details
                    </a>

                    <div class="d-none">
                      <span id="lot_date{{$row['id'].$lot_index}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
                      <span id="lot_time{{$row['id'].$lot_index}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
                      <span id="wrc_numbers{{$row['id'].$lot_index}}">{{ $wrc_numbers }}</span>

                    </div>
                    
                    @php
                      $service = base64_encode('CREATIVE');
                      $module = base64_encode('lot');
                      $lot_id_is = base64_encode($row['id']);
                      $data_array = array(
                        'user_id' => base64_encode($row['user_id']), 
                        'brand_id' => base64_encode($row['brand_id']), 
                        'lot_id' => $lot_id_is, 
                        'wrc_id' => '',
                        'service' => $service, 
                        'module' => $module 
                      );

                      $data_obj = json_encode($data_array,true);
                    @endphp
                    
                    {{-- Add to favorites --}}

                    {{-- <a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
                    
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1069_2524)">
                        <path d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_1069_2524">
                        <rect width="20" height="20" fill="white"/>
                        </clipPath>
                        </defs>
                      </svg>&nbsp;
                      Add to favorites
                    </a> --}}

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
                <div type="button" class="btn border-0 rounded-circle myButton">
                    <i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
                    </i>
                </div>
              </div>
              <div class="col-12">
                <span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}} </span>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <div>
                  <p class="inward-qty">Inward Quantity : </p>
                  <p class="inward-qty-num">
                    {{$row['inward_qty'] != '' ? $row['inward_qty'] : 0}}
                  </p>
                </div>
                <div>
                  <p class="inward-qty">Submission</p>
                  <p class="inward-qty-num">
                    {{$submission_date != '' ? dateFormet_dmy($submission_date) : $submission_date }}
                  </p>
                </div>
              </div>
              <div class="col-12 d-grid gap-2">
                <a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_creative_wrcs_links' , ['lot_id' => $lot_id_is])}}">
                  View Links
                </a>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endforeach
  @else
    <div class="col-sm-6 col-md-4 col-lg-3">
      <p class="underheadingF">No Lots</p>
    </div>
  @endif
</div>