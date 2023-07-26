@extends('layouts.DamNewMain')
@section('title')
  Client Dashboard
@endsection

@section('other_css')
	<style>
		.progress-circle {
			position: relative;
			display: inline-block;
		}
		
		.progress {
			transform: rotate(-90deg);
			width: 80px;
			height: 61px;
			background: #1A1A1A;
		}
		
		.progress-bar-bg {
			fill: #1A1A1A;
			stroke: #333333;
			stroke-width: 2;
		}
		
		.progress-bar {
			fill: transparent;
			stroke: #FFF300;
			stroke-width: 10;
			stroke-dasharray: 283;
			stroke-dashoffset: 0;
			transition: stroke-dashoffset 0.5s ease;
		}
		
		.progress-bar-filled {
			stroke: #50AB64;
			color: #50AB64 !important;
		}
		
		.progress-value {
			font-size: 14px;
			font-weight: 800;
			color: #FFF300;
			text-align: center;
			display: flex;
			justify-content: center;
			align-items: center;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}
		
		.dropdown-item.active, .dropdown-item:active {
                color: #FFFFFF;
                text-decoration: none;
                background-color: #1A1A1A;
        }
        
        .dropdown-item:hover {
                color:#fffc;
                background:#1A1A1A !important;
        }
        
		.tracklot-allServices-and-sort{
		    gap:24px;
		}
		
		.tracklot-dropdown-tab-allService{
          font-weight: 500;
          font-size: 14px;
          line-height: 20px;
          color: var(--shades-0, #FFF);
          border: 1px solid #333333;
          background-color: #0F0F0F;
          padding: 16px;
          font-size: 14px;
          font-style: normal;
          letter-spacing: 0.1px;
          border-radius: 0px;
          display:flex;
          align-items:center;
          gap:24px;
    }
    .tracklot-dropdown-tab-allService:focus{
       box-shadow: none;
    }
    
    .tracklot-dropdown-tab-allService:hover{
       color:#fffc;
    }

    .tracklot-allServices-dropdown-Box{
      border: 1px solid var(--neutral-700, #333);
      background: var(--neutral-900-main, #0F0F0F);
      box-shadow: 4px 16px 40px 0px rgba(255, 255, 255, 0.06);
      inset: 0px auto auto -156px;
      width: 280px;
      border-radius:0px;
    }
    .tracklot-allService-text{
      color: #FFF;
      background-color: #1A1A1A;
    }
    .tracklot-allService-text:hover{
      color:#fffc;
      background:#1A1A1A !important;
      border-radius:0px;
    }
   .nav-pills .tracklot-allService-text.active{
      background: #1A1A1A;
    }
    
    .dropdown-toggle::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: none !important;
  }
  
/*  .dropdown-menu , .tracklot-allServices-dropdown-Box.show {*/
/*    padding: 0px;*/
/*}*/

	</style>
@endsection

@section('main_content')
<?php 
$lot_status_is = $sortBy = $lot_status_val = "" ;
	if(isset($other_data)){
		if(isset($other_data['lot_status'])){
			$lot_status_is = $other_data['lot_status'];
		}
		if(isset($other_data['sortBy'])){
			$sortBy = $other_data['sortBy'];
		}
	}
	$lot_status_arr = ['all' , 'active' , 'completed'];
	if (in_array($lot_status_is, $lot_status_arr)) {
		$lot_status_val = $lot_status_is;
	} 
?>

@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
	$change_tab = false;
	$active_tab_number = 0;
	$lot_is = "";
	$tab_number = 1;
@endphp

<div class="row">
	<div class=" col-12 d-flex justify-content-between">
	    <div>
	       <h4 class="headingF">
			Track Lots - {{$lot_status_val}}
	       </h4> 
	       <p class="underheadingF">
			  You are seeing - {{$lot_status_val}} <span id="lot_is"></span> lots.
		   </p>
	    </div>
		
		<div class="tracklot-allServices-and-sort d-flex">
		     <div class="dropdown">
                <button class="btn dropdown-toggle tracklot-dropdown-tab-allService" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="button-text">All</span>
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M4.62875 8.87122L11.1488 15.3912C11.9187 16.1612 13.1787 16.1612 13.9487 15.3912L20.4688 8.87122" stroke="#808080" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </button>
                <ul class=" dropdown-menu dropdown-menu-dark tracklot-allServices-dropdown-Box">
                  <ul class="nav nav-pills nav-fill tabs" id="pills-tab" role="tablist" >

										<li class="nav-item services-text-dropdown-item" role="presentation" onclick="active_lot('All')">
											<button class="nav-link  tab-text tracklot-allService-text" id="all-lots-tab" data-bs-toggle="pill"
												data-bs-target="#all-lots" type="button" role="tab" aria-controls="all-lots" aria-selected="true" >
												 All
											</button>
										</li>
                    {{-----lot status Shoot start---}}
                    @if (count($shoot_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['shoot']))
                      @php
                        $active_lot_is = "Shoot";
                        if (!$change_tab) {
                          $change_tab = true;
                          $lot_is = $active_lot_is;
                          $active_tab_number = $tab_number;
                        }
                      @endphp
                      <li class="nav-item services-text-dropdown-item" role="presentation" onclick="active_lot('{{$active_lot_is}}'), activateTab1({{$tab_number++}})">
                        <button class="nav-link  tab-text tracklot-allService-text" id="shoot-lots-tab" data-bs-toggle="pill"
                          data-bs-target="#shoot-lots" type="button" role="tab" aria-controls="shoot-lots" aria-selected="true" >
                           Shoot Lots
                        </button>
                      </li>
                    @endif
                    
                     {{-----lot status Cataloging start---}}
                    @if ( count($lots_catalog) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Cataloging']))
                      @php
                        $active_lot_is = "Listing";
                        if (!$change_tab) {
                          $change_tab = true;
                          $lot_is = $active_lot_is;
                          $active_tab_number = $tab_number;
                        }
                      @endphp
                      <li class="nav-item tab services-text-dropdown-item" role="presentation" onclick="active_lot('{{$active_lot_is}}'), activateTab1({{$tab_number++}})">
                        <button class="nav-link  tab-text tracklot-allService-text" id="listing-lots-tab" data-bs-toggle="pill"
                          data-bs-target="#listing-lots" type="button" role="tab" aria-controls="listing-lots"
                          aria-selected="false">
                           Listing Lots
                        </button>
                      </li>
                    @endif
              
                    {{-----lot status editor start---}}
                    @if ( count($editor_lots) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Editing']))
                      @php
                        $active_lot_is = "Post-production";
                        if (!$change_tab) {
                          $change_tab = true;
                          $lot_is = $active_lot_is;
                          $active_tab_number = $tab_number;
                        }
                      @endphp
                      <li class="nav-item services-text-dropdown-item" role="presentation" onclick="active_lot('{{$active_lot_is}}'), activateTab1({{$tab_number++}})">
                        <button class="nav-link  tab-text tracklot-allService-text" id="post-production-lots-tab" data-bs-toggle="pill"
                          data-bs-target="#post-production-lots" type="button" role="tab" aria-controls="post-production-lots"
                          aria-selected="false">
                             Post-production Lots
                        </button>
                      </li>
                    @endif
              
                    {{-----lot status Creative start---}}
                    @if (count($creative_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['Creative']))
                      @php
                        $active_lot_is = "Marketing Creative";
                        if (!$change_tab) {
                          $change_tab = true;
                          $lot_is = $active_lot_is;
                          $active_tab_number = $tab_number;
                        }
                      @endphp
              
                      <li class="nav-item tab services-text-dropdown-item" role="presentation" onclick="active_lot('{{$active_lot_is}}'), activateTab1({{$tab_number++}})">
                        <button class="nav-link tab-text tracklot-allService-text" id="creative-lots-tab" data-bs-toggle="pill"
                          data-bs-target="#creative-lots" type="button" role="tab" aria-controls="creative-lots"
                          aria-selected="false">
                           Marketing Creative Lots
                        </button>
                      </li>
                    @endif
                  </ul>
                </ul>
              </div>
		   <div class="dropdown">
             <a class="btn rounded-0 sort-by-button  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               <span>Sort</span>
               <span>
                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7H21M6 12H18M10 17H14" stroke="#808080" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>

               </span>
             </a>

            <ul class="dropdown-menu dropdown-menu-show-sortby">
				<li><a class="dropdown-item dropdown-menu-show-sortby-item {{$sortBy == 'latest' ? 'active' : ''}}" href="{{route('TrackLots', ['lotStatus' => $lot_status_is, 'sortBy' => 'latest' ])}}">Latest</a></li>
				<li><a class="dropdown-item dropdown-menu-show-sortby-item {{($sortBy == 'oldest' || $sortBy == 'old')  ? 'active' : ''}}" href="{{route('TrackLots', ['lotStatus' => $lot_status_is, 'sortBy' => 'oldest' ] )}}">Oldest</a></li>
				{{-- <li><a class="dropdown-item dropdown-menu-show-sortby-item" href="#"></a></li> --}}
            </ul>
         </div>
		</div>
	</div>
</div>


<div class="row" style="margin-top: 40px;">
	<div class="tab-content" id="pills-tabContent">

		<div class="col-lg-12 total_all_lots">
			<p class="totallotF total_all_lots">Total Lots: {{ count($shoot_lots) +  count($lots_catalog) +  count($editor_lots) +  count($creative_lots) }}</p>
		</div>
		{{-----lot status Shoot start---}}
		@if (count($shoot_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['shoot']))
		<div class="tab-pane fade show active" id="shoot-lots" role="tabpanel" aria-labelledby="shoot-lots-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				<div class="col-lg-12">
					<p class="totallotF d-none">Total Lots: {{ count($shoot_lots) }}</p>
				</div>
				@foreach ($shoot_lots as $key => $val)
				@php
					$overall_progress = $val['overall_progress'];
					$overall_progress = intval(str_replace('%', '', $overall_progress));
				@endphp	
				<div class="col-lg-4 box">
					<div class="row">
						<div class="under-content-div">
						    <div class="col-12">
						      <p class="lotnoF">{{$val['brand_name']}}</p>
						      <p class="lot-no-heading" style="font-weight: 400;font-size: 14px; margin-top:4px">
								 Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
							</p>
						    </div>
						    <div class="col-12">
						        <p class="lot-no-heading">Lot type</p>
						        <p class="status" style="font-size: 16px;">
									 Shoot Lot
								</p>
						    </div>
						    <div class="col-12">
						        <p class="lot-no-heading">Lot no</p>
						        <p class="status" style="font-size: 16px;">
									 {{$val['lot_number']}}
								</p>
						    </div>
							<div class="col-12 d-flex justify-content-between">
								<div>
									<p class="current-status" style="font-weight: 500;font-size: 14px;">
										Status
									</p>
									<p class="status"
										style="font-weight: 400;font-size: 16px; font-family: 'Poppins';">
										{{$val['lot_status']}}
									</p>
								</div>
								<!--<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100" style="--value:{{$overall_progress}}"></div>-->
								<div class="progress-circle">
										<svg class="progress" viewBox="0 0 100 100">
											<circle class="progress-bar-bg" cx="50" cy="50" r="45"></circle>
											<circle class="progress-bar" cx="50" cy="50" r="45"></circle>
										</svg>
										<div class="progress-value ">{{$overall_progress."%"}}</div>
									</div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a href={{route('clientsShootlotTimelineNew',$val['id'])}} class="btn border rounded-0 btn-secondary" type="button"
									style="font-weight: 500;font-size: 16px; font-family: 'Poppins', sans-serif; padding: 16px !important;">
									View full details
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach

			</div>
		</div>
		@endif

		{{-----lot status Creative start---}}
		@if (count($creative_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['Creative']))	
		<div class="tab-pane fade show active" id="creative-lots" role="tabpanel" aria-labelledby="creative-lots-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				<div class="col-lg-11">
					<p class="totallotF d-none ms-2">Total Lots: {{ count($creative_lots) }}</p>
				</div>

				@foreach ($creative_lots as $key => $val)
				@php
					$overall_progress = $val['overall_progress'];
					$overall_progress = intval(str_replace('%', '', $overall_progress));
				@endphp	
					<div class="col-lg-4 box">
						<div class="row">
							<div class="under-content-div">
							  <div class="col-12">
						          <p class="lotnoF">{{$val['brand_name']}}</p>
						          	<p class="lot-no-heading" style="font-weight: 400;font-size: 14px; margin-top:4px">
								        Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
						        	</p>
						      </div>
						        <div class="col-12">
						           <p class="lot-no-heading" >Lot type</p>
						            <p class="status" style="font-size: 16px;">
										 Marketing Creative Lots
									</p>
						        </div>
							    <div class="col-12">
						           <p class="lot-no-heading" >Lot no</p>
						            <p class="status" style="font-size: 16px;">
										 {{ $val['lot_number'] }}
									</p>
						        </div>
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p class="current-status" style="font-weight: 500;font-size: 14px;">
											Status
										</p>
										<p class="status"
											style="font-weight: 400;font-size: 16px; font-family: 'Poppins', sans-serif;">
											{{$val['lot_status']}}
										</p>
									</div>
								<!--<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100" style="--value:{{$overall_progress}}"></div>-->
								<div class="progress-circle">
										<svg class="progress" viewBox="0 0 100 100">
											<circle class="progress-bar-bg" cx="50" cy="50" r="45"></circle>
											<circle class="progress-bar" cx="50" cy="50" r="45"></circle>
										</svg>
										<div class="progress-value ">{{$overall_progress."%"}}</div>
									</div>
								</div>
								<div class="col-12 d-grid gap-2">
									<a href={{route('clientsCreativelotTimelineNew',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
										style="font-weight: 500;font-size: 16px; font-family: 'Poppins', sans-serif; padding: 16px !important;">
										View full details
									</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
		@endif

		{{-----lot status catlog start---}}
		@if ( count($lots_catalog) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Cataloging']))
		<div class="tab-pane fade show active" id="listing-lots" role="tabpanel" aria-labelledby="listing-lots-tab"
			tabindex="0">
			<div class="row box-container-responsive">

				<div class="col-lg-11">
					<p class="totallotF d-none ms-2">Total Lots: {{ count($lots_catalog) }}</p>
				</div>
				@foreach ($lots_catalog as $key => $val)
				@php
					$overall_progress = $val['overall_progress'];
					$overall_progress = intval(str_replace('%', '', $overall_progress));
				@endphp	
				<div class="col-lg-4 box">
					<div class="row">
						<div class="under-content-div">
						    <div class="col-12">
						          <p class="lotnoF">{{$val['brand_name']}}</p>
						          <p class="lot-no-heading" style="font-weight: 400;font-size: 14px; margin-top:4px">
								     Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
							     </p>
						    </div>
						    <div class="col-12">
						        <p class="lot-no-heading">Lot type</p>
						        <p class="status" style="font-size: 16px;">
									 Listing Lot
								</p>
						    </div>
						    <div class="col-12">
						        <p class="lot-no-heading">Lot no</p>
						        <p class="status" style="font-size: 16px;">
									 {{ $val['lot_number'] }}
								</p>
						    </div>
							<div class="col-12 d-flex justify-content-between" >
								<div>
									<p class="current-status" style="font-weight: 500;font-size: 14px;">
										Status
									</p>
									<p class="status"
										style="font-weight: 400;font-size: 16px; font-family: 'Poppins', sans-serif;">
										{{$val['lot_status']}}
									</p>
								</div>
								<!--<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100" style="--value:{{$overall_progress}}"></div>-->
								<div class="progress-circle">
										<svg class="progress" viewBox="0 0 100 100">
											<circle class="progress-bar-bg" cx="50" cy="50" r="45"></circle>
											<circle class="progress-bar" cx="50" cy="50" r="45"></circle>
										</svg>
										<div class="progress-value ">{{$overall_progress."%"}}</div>
									</div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a href={{route('clientsCatloglotTimelineNew',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
									style="font-weight: 500;font-size: 16px; font-family: 'Poppins', sans-serif; padding: 16px !important;">
									View full details
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif

		{{-----lot status Editing start---}}
		@if ( count($editor_lots) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Editing']))
		<div class="tab-pane fade show active" id="post-production-lots" role="tabpanel" aria-labelledby="post-production-lots-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				<div class="col-12">
					<p class="totallotF d-none ms-2">Total Lots: {{ count($editor_lots) }}</p>
				</div>
				@foreach ($editor_lots as $key => $val)
				@php
						$overall_progress = $val['overall_progress'];
						$overall_progress = intval(str_replace('%', '', $overall_progress));
					@endphp	
				<div class="col-lg-4 box">
					<div class="row">
						<div class="under-content-div">
						    <div class="col-12">
						          <p class="lotnoF">{{$val['brand_name']}}</p>
						          <p class="lot-no-heading" style="font-weight: 400;font-size: 14px; margin-top:4px">
								     Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
							     </p>
						    </div>
						    <div class="col-12">
						        <p class="lot-no-heading">Lot type</p>
						        <p class="status" style="font-size: 16px;">
									Post-production Lots
								</p>
						    </div>
						    <div class="col-12">
						        <p class="lot-no-heading">Lot no</p>
						        <p class="status" style="font-size: 16px;">
									 {{$val['lot_number']}}
								</p>
						    </div>
							<div class="col-12 d-flex justify-content-between">
								<div>
									<p class="current-status" style="font-weight: 500;font-size: 14px;">
								     	Status
									</p>
									<p class="status"
										style="font-weight: 400;font-size: 16px; font-family: 'Poppins', sans-serif;">
										{{$val['lot_status']}}
									</p>
								</div>
								<!--<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100"-->
								<!--	style="--value:{{$overall_progress}}"></div>-->
								<div class="progress-circle">
                                    <svg class="progress" viewBox="0 0 100 100">
                                      <circle class="progress-bar-bg" cx="50" cy="50" r="45"></circle>
                                      <circle class="progress-bar" cx="50" cy="50" r="45"></circle>
                                    </svg>
                                    <div class="progress-value ">{{$overall_progress."%"}}</div>
                                 </div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a href={{route('clientsEditorLotTimelineNew',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
									style="font-weight: 500;font-size: 16px; font-family: 'Poppins', sans-serif; padding: 16px !important;">
									View full details
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
	</div>
</div>
@endsection

@section('js_scripts')
	
{{-- animateProgressBars --}}
	<script>
		function animateProgressBars() {
			var progressCircles = document.querySelectorAll('.progress-circle');
		
			progressCircles.forEach(function(circle) {
				var progressValue = circle.querySelector('.progress-value');
				var progress = circle.querySelector('.progress-bar');
		
				var percentage = parseInt(progressValue.textContent);
		
				var circumference = 2 * Math.PI * progress.getAttribute('r');
				var offset = circumference * (100 - percentage) / 100;
		
				progress.style.strokeDashoffset = circumference;
		
				progress.classList.remove('progress-bar-filled');
				progress.getBoundingClientRect();
		
				progress.style.transition = 'stroke-dashoffset 1s ease-in-out';
				progress.style.strokeDashoffset = offset + 'px';
		
				if (percentage === 100) {
					progress.classList.add('progress-bar-filled');
						progressValue.classList.add('progress-bar-filled');
				}
			});
		}
		animateProgressBars();
	</script>

{{-- Change top heading --}}
	<script>
		function active_lot(active_lot_is){
			const btn_id = event.target.id
			console.log('Button ID:', btn_id);

			$('.totallotF').addClass('d-none')
			$('.total_all_lots').addClass('d-none')
			
			if(active_lot_is == 'All'){
				$('#lot_is').html('')
				$('.tab-pane').addClass('show active')
				$('.total_all_lots').removeClass('d-none')
			}else{
				$('#lot_is').html(active_lot_is)
				$('.tab-pane').removeClass('show active')
				$('#'+btn_id).addClass('show active')
				$('.totallotF').removeClass('d-none')
			}
		}
	</script>

	{{-- activate Tab  --}}
<script>
	function activateTab1(number){
	
	}
</script>

	<script>
		const change_tab = '{{$change_tab}}'
		const lot_is = '{{$lot_is}}'
		const active_tab_number = {{$active_tab_number}}
		if((change_tab == true || change_tab == 1) && active_tab_number > 0){
			// active_lot(lot_is)
		}
	</script>	

<!--All Services Drodown active script-->

	<script>
    //   const dropdownItems = document.querySelectorAll('.dropdown-menu .nav-link');
    //   const dropdownHeading = document.querySelector('.dropdown button');
    
    //   dropdownItems.forEach(item => {
    //     item.addEventListener('click', (e) => {
    //       e.preventDefault();
    //       const itemName = e.target.textContent;
    //       dropdownHeading.textContent = itemName;
    //     });
    //   });
    
    
     const dropdownItems = document.querySelectorAll(".services-text-dropdown-item");
        const buttonText = document.querySelector(".button-text");

        dropdownItems.forEach((item) => {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            const selectedItemText = item.textContent;     
            buttonText.textContent = selectedItemText;
            buttonText.style.color = "#FFFFFF";
            dropdownItems.forEach((item) => {
            item.classList.remove("selected");
            });
            item.classList.add("selected");
        });
        });
  </script>
@endsection