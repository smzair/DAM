   
   <style>.sku-number-ul {
            min-height: 500px;
            max-height: 600px;
            height: 100%;
            overflow-y: auto;
        }

        .sku-number-ul::-webkit-scrollbar {
            display: none;
        }
        .sku-head {
            position: sticky;
            top: 0;
            left: 0;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            color: #ffff;
            background-color: rgba(16 18 27 / 80%);
        }</style>
   <ul class="mega-dropdown" >
                               <h5 class="m-0 p-3">LOT Number</h5>
                            @foreach($skuList as $lotId => $wrcList)
                            <li class="mega-dropdown__list-item lot-number" data-parent="true" aria-expanded="false" data-expandable="true" style="cursor: pointer;">
                                <span class="lot_text">{{$lotId}}</span>
                                <i class="fas fa-angle-right arrow-right"></i>
                                <ul class="mega-dropdown mega-dropdown-inner wrc-number-ul">
                                    <h5 class="m-0 p-3 clearfix">
                                        WRC Number
                                    </h5>
                                    @foreach($wrcList as $wrcId => $skuList)
                                    <li class="mega-dropdown__list-item wrc-number" data-child="true" aria-expanded="false" data-expandable="true">
                                        <span class="wrc_text">{{$wrcId}}</span>
                                        <i class="fas fa-angle-right arrow-right"></i>
                                        <ul class="mega-dropdown mega-dropdown-inner  sku-number-ul">
                                            <h5 class="m-0 p-3 clearfix sku-head">
                                                SKU Number
                                            </h5>
                                            @foreach($skuList as $sku)
                                            <li class="mega-dropdown__list-item sku-number" aria-expanded="false" data-expandable="false">
                                                 
                                                <a href="javascript:void(0);" data-sku_id="{{$sku->sku_id}}" data-sku_status="{{$sku->sku_status}}">
                                                    {{$sku->sku_code}}&nbsp; 
                                                      
                                                     
                                                    @if($sku->sku_status == '1')
                                                    <span class="text-success db">
                                                        <i class="fas fa-check-circle"></i>
                                                       
                                                     
                                                    </span>
                                                   
                                                    
                                                    @endif
                                                    @if($sku->sku_status == '0')
                                                    <span class="text-danger db">
                                                        <i class="fas fa-times-circle"></i>
                                                    </span>
                                                    @endif
                                                    <span class="text-success d-none">
                                                        <i class="fas fa-check-circle"></i>
                                                    </span>
                                                    <span class="text-danger d-none">
                                                        <i class="fas fa-times-circle"></i>
                                                    </span>
                                                </a>
                                                
                                                         <?php echo DB::table('uploadraw')->where('sku_id','=',$sku->sku_id)->get()->count(); ?>  
                                                         
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                        