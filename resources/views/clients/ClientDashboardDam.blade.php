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
			stroke: #FFF866;
			stroke-width: 10;
			stroke-dasharray: 283;
			stroke-dashoffset: 0;
			transition: stroke-dashoffset 0.5s ease;
		}
		
		.progress-bar-filled {
			stroke: #4CAF50;
			color: #4CAF50 !important;
		}
		
		.progress-value {
			font-size: 14px;
			font-weight: 800;
			color: #FFF866;
			text-align: center;
			display: flex;
			justify-content: center;
			align-items: center;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}

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

<div class="row">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			Track Lots - {{$lot_status_val}}
		</h4>
		<div class="dropdown mt-2">
          <a class="btn rounded-0 sort-by-button  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sort &nbsp;&nbsp;&nbsp;&nbsp;
          </a>

            <ul class="dropdown-menu dropdown-menu-show-sortby">
							<li><a class="dropdown-item dropdown-menu-show-sortby-item {{$sortBy == 'latest' ? 'active' : ''}}" href="{{route('TrackLots', ['lotStatus' => $lot_status_is, 'sortBy' => 'latest' ])}}">Latest</a></li>
							<li><a class="dropdown-item dropdown-menu-show-sortby-item {{($sortBy == 'oldest' || $sortBy == 'old')  ? 'active' : ''}}" href="{{route('TrackLots', ['lotStatus' => $lot_status_is, 'sortBy' => 'oldest' ] )}}">Oldest</a></li>
							{{-- <li><a class="dropdown-item dropdown-menu-show-sortby-item" href="#"></a></li> --}}
            </ul>
        </div>
	</div>
</div>
<div class="row" style="margin-top: 12px;">
	<div class="col-12">
		<p class="underheadingF">
			Currently, you are seeing {{$lot_status_val}} lots.
		</p>
	</div>
</div>
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
@endphp

<div class="row" style="margin-top: 40px;padding: 0px 11px;">
    <!--<div class="">-->
	 <div class="col-lg-12 d-flex services-modal">
		<ul class="nav nav-pills mb-3 nav-fill tabs" id="pills-tab" role="tablist" style="padding:16px 4px 0px 4px;width: 100%;">
			{{-----lot status Shoot start---}}
			@if (count($shoot_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['shoot']))
			<li class="nav-item tab active" role="presentation" onclick="activateTab(1)">
				<button class="nav-link svg-container btn-lg tab-button border border-dark border-start-0 border-top-0 border-bottom-0 tab-text" id="pills-home-tab" data-bs-toggle="pill"
					data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" >
					<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1673_8418)">
                    <path class="tab-icon" d="M8.48801 14.5888C6.81041 14.5888 5.13281 14.5912 3.45521 14.5888C2.21601 14.5864 1.19841 13.756 0.95041 12.5432C0.91601 12.3744 0.90321 12.1976 0.90241 12.0248C0.89921 10.02 0.89841 8.01597 0.90081 6.01117C0.90241 4.56077 2.01681 3.45037 3.47041 3.44637C3.65521 3.44637 3.84001 3.45357 4.02401 3.44157C4.07761 3.43837 4.15041 3.39437 4.17681 3.34797C4.29041 3.14637 4.38081 2.93117 4.49601 2.73037C4.97681 1.89517 5.70401 1.44317 6.66481 1.42557C7.88321 1.40397 9.10241 1.40477 10.32 1.42557C11.2944 1.44157 12.028 1.90077 12.5112 2.74877C12.6152 2.93197 12.7088 3.12157 12.7952 3.31357C12.8408 3.41437 12.8976 3.44717 13.0088 3.45037C13.3768 3.46077 13.752 3.44557 14.1104 3.51517C15.2424 3.73597 16.0872 4.76637 16.0928 5.92157C16.1016 7.98397 16.1032 10.0464 16.0928 12.1096C16.0856 13.464 14.9584 14.5808 13.5992 14.5872C11.8952 14.596 10.1912 14.5896 8.48801 14.5896V14.5888ZM8.49841 4.45837C6.84241 4.45837 5.18641 4.45837 3.52961 4.45837C2.55921 4.45837 1.91361 5.10397 1.91361 6.07437C1.91361 8.03677 1.91361 9.99837 1.91361 11.9608C1.91361 12.9304 2.56001 13.576 3.53041 13.576C6.84241 13.576 10.1552 13.576 13.4672 13.576C14.4368 13.576 15.0824 12.9304 15.0832 11.96C15.0832 9.99757 15.0832 8.03597 15.0832 6.07357C15.0832 5.10397 14.4368 4.45917 13.4664 4.45837C11.8104 4.45837 10.1544 4.45837 8.49761 4.45837H8.49841ZM5.29281 3.43197H11.7216C11.4512 2.82637 11.0128 2.45277 10.3592 2.44077C9.12081 2.41757 7.88161 2.42717 6.64321 2.43677C6.04081 2.44157 5.46961 2.87597 5.29281 3.43277V3.43197Z" fill="#808080"/>
                    <path class="tab-icon" d="M8.50002 5.47217C10.4528 5.47217 12.0424 7.06257 12.044 9.01537C12.0448 10.9738 10.448 12.5674 8.48882 12.5634C6.53762 12.5586 4.95042 10.9642 4.95282 9.01217C4.95522 7.06017 6.54722 5.47217 8.50002 5.47297V5.47217ZM11.0304 9.02497C11.0336 7.62497 9.90002 6.48577 8.50162 6.48497C7.10802 6.48337 5.97042 7.61217 5.96562 9.00177C5.96002 10.4034 7.09042 11.5458 8.48642 11.5506C9.88722 11.5546 11.028 10.4226 11.0312 9.02577L11.0304 9.02497Z" fill="#808080"/>
                    <path class="tab-icon" d="M13.0648 5.47213C13.228 5.47213 13.392 5.46973 13.5552 5.47213C13.8488 5.47853 14.072 5.70092 14.0696 5.98172C14.0672 6.25612 13.848 6.47853 13.5632 6.48253C13.2256 6.48733 12.8888 6.48733 12.5512 6.48253C12.2664 6.47853 12.0464 6.25532 12.0448 5.98172C12.0424 5.70092 12.2664 5.47773 12.5592 5.47213C12.728 5.46893 12.8968 5.47213 13.0648 5.47213Z" fill="#808080"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_1673_8418">
                    <rect width="16" height="16" fill="white" transform="translate(0.5)"/>
                    </clipPath>
                    </defs>
                    </svg>    
                    &nbsp; Shoot Lots
				</button>
			</li>
			@endif

			{{-----lot status Creative start---}}
			@if (count($creative_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['Creative']))
			<li class="nav-item tab" role="presentation" onclick="activateTab(2)">
				<button class="nav-link btn-lg tab-button border border-dark border-start-0 border-top-0 border-bottom-0 tab-text" id="pills-profile-tab" data-bs-toggle="pill"
					data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
					aria-selected="false">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1673_8383)">
                    <path class="tab-icon" d="M1.48716 8.85763C1.55676 8.79283 1.60156 8.75363 1.64316 8.71203C2.16716 8.18883 2.68956 7.66563 3.21356 7.14243C3.52156 6.83523 3.79516 6.83683 4.10476 7.14643C4.49196 7.53363 4.87916 7.92163 5.27916 8.32323C5.32796 8.27683 5.37276 8.23763 5.41516 8.19523C6.30636 7.30483 7.19676 6.41363 8.08796 5.52323C8.40396 5.20723 8.67436 5.20723 8.99196 5.52323C9.32796 5.85843 9.66796 6.18963 9.99676 6.53203C10.3016 6.84883 10.1664 7.33043 9.74876 7.44163C9.54956 7.49443 9.37996 7.42963 9.23916 7.28883C9.01196 7.06163 8.78796 6.83043 8.54956 6.58803C8.49356 6.64163 8.44956 6.68163 8.40716 6.72403C7.51596 7.61443 6.62556 8.50563 5.73436 9.39603C5.41916 9.71123 5.14956 9.70963 4.83116 9.39203C4.44396 9.00563 4.05756 8.61843 3.66396 8.22403C3.61836 8.26563 3.57996 8.29683 3.54476 8.33203C2.89356 8.98323 2.24076 9.63203 1.59436 10.2888C1.53596 10.348 1.49436 10.4512 1.49196 10.5344C1.48156 10.9408 1.48636 11.348 1.48796 11.7544C1.48956 12.1416 1.68556 12.34 2.07116 12.3408C2.95836 12.3424 3.84476 12.3384 4.73196 12.3424C5.14156 12.344 5.38076 12.6856 5.25356 13.0744C5.18556 13.2832 5.01676 13.4208 4.78316 13.4224C3.82316 13.4264 2.86156 13.4456 1.90236 13.4152C1.05516 13.3888 0.414358 12.6896 0.405558 11.8312C0.395958 10.8368 0.403158 9.84243 0.402358 8.84803C0.402358 6.61683 0.402358 4.38483 0.402358 2.15363C0.402358 1.06963 1.06076 0.407227 2.13996 0.407227C5.33756 0.407227 8.53516 0.407227 11.7328 0.407227C12.5616 0.407227 13.1864 0.873627 13.3704 1.63043C13.4008 1.75523 13.4176 1.88723 13.4184 2.01523C13.4232 2.73843 13.4232 3.46163 13.42 4.18483C13.4184 4.60483 13.0736 4.84723 12.6792 4.71363C12.4584 4.63843 12.3376 4.45683 12.3368 4.18563C12.3352 3.49603 12.3368 2.80723 12.3368 2.11763C12.3368 1.67443 12.152 1.49123 11.708 1.49123C8.51036 1.49123 5.31276 1.49123 2.11516 1.49123C1.67196 1.49123 1.48796 1.67523 1.48796 2.11923C1.48796 4.30003 1.48796 6.48083 1.48796 8.66163V8.85763H1.48716Z" fill="#808080"/>
                    <path class="tab-icon" d="M15.6 8.00732C15.5944 8.48652 15.372 8.98092 14.9568 9.39612C13.1776 11.1729 11.3968 12.9481 9.62717 14.7345C9.42237 14.9417 9.21117 15.0625 8.92557 15.1137C8.13197 15.2561 7.34317 15.4273 6.55037 15.5801C6.30717 15.6273 6.07757 15.5593 5.92637 15.3641C5.85277 15.2689 5.80477 15.1089 5.82637 14.9929C5.99197 14.0945 6.17117 13.1977 6.36317 12.3041C6.39277 12.1641 6.48317 12.0185 6.58557 11.9161C8.41037 10.0817 10.24 8.25052 12.0728 6.42412C12.6768 5.82252 13.5664 5.65692 14.3288 5.98092C15.1048 6.31052 15.6024 7.06092 15.6 8.00812V8.00732ZM13.1712 9.65532C12.6976 9.17532 12.2392 8.71132 11.7616 8.22812C11.728 8.26892 11.692 8.32012 11.648 8.36332C10.3672 9.64572 9.09197 10.9337 7.79837 12.2033C7.52077 12.4761 7.33437 12.7569 7.29037 13.1505C7.24637 13.5449 7.15197 13.9337 7.07757 14.3345C7.11757 14.3345 7.13997 14.3377 7.16077 14.3345C7.65997 14.2409 8.15997 14.1521 8.65677 14.0489C8.75357 14.0289 8.85597 13.9705 8.92637 13.9009C10.3112 12.5233 11.692 11.1409 13.0736 9.75932C13.1128 9.72012 13.1496 9.67852 13.1712 9.65612V9.65532ZM12.58 7.44172C13.0512 7.91452 13.512 8.37612 13.9872 8.85372C14.104 8.72572 14.2464 8.60252 14.348 8.45052C14.5696 8.11852 14.5824 7.75852 14.3952 7.40892C14.208 7.05932 13.896 6.90492 13.5024 6.90652C13.0864 6.90732 12.8224 7.16332 12.5808 7.44252L12.58 7.44172Z" fill="#808080"/>
                    <path class="tab-icon" d="M6.9112 4.20635C6.9104 5.12875 6.1968 5.83595 5.2728 5.83035C4.3584 5.82555 3.656 5.11675 3.6576 4.19995C3.6592 3.27755 4.3712 2.57115 5.296 2.57595C6.21119 2.58075 6.9128 3.28875 6.9112 4.20555V4.20635ZM5.2792 4.74555C5.6032 4.74795 5.824 4.53035 5.8264 4.20795C5.8288 3.88395 5.612 3.66315 5.2896 3.66075C4.9648 3.65835 4.7448 3.87515 4.7424 4.19755C4.74 4.52235 4.9568 4.74315 5.2792 4.74475V4.74555Z" fill="#808080"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_1673_8383">
                    <rect width="16" height="16" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>
                    &nbsp; Creative Lots
				</button>
			</li>
			@endif

			{{-----lot status Cataloging start---}}
			@if ( count($lots_catalog) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Cataloging']))
			<li class="nav-item tab" role="presentation" onclick="activateTab(3)">
				<button class="nav-link btn-lg tab-button border border-dark border-start-0 border-top-0 border-bottom-0 tab-text" id="pills-contact-tab" data-bs-toggle="pill"
					data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
					aria-selected="false">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1673_8407)">
                    <path class="tab-icon" d="M0.400024 13.3432V2.65603C0.500024 2.45603 0.643224 2.33203 0.878424 2.28883C2.45762 2.00083 4.03522 1.70083 5.61282 1.40483C6.52082 1.23443 7.42882 1.06403 8.33682 0.89363C8.69122 0.82723 8.94402 1.02963 8.94962 1.38643C8.95122 1.51523 8.94962 1.64403 8.94962 1.77203C8.94962 2.10163 8.94962 2.43203 8.94962 2.77443C9.02322 2.77443 9.08162 2.77443 9.14002 2.77443C11.0984 2.77443 13.0576 2.77443 15.016 2.77443C15.4296 2.77443 15.5992 2.94563 15.5992 3.36083C15.5992 6.45203 15.5992 9.54403 15.5992 12.6352C15.5992 13.0568 15.4296 13.224 15.0032 13.224C13.0448 13.224 11.0856 13.224 9.12722 13.224C9.07042 13.224 9.01362 13.224 8.94962 13.224C8.94962 13.7056 8.95282 14.1656 8.94882 14.6248C8.94562 14.9616 8.68402 15.1688 8.35202 15.1072C5.88562 14.6456 3.41922 14.1824 0.952024 13.7248C0.701624 13.6784 0.504024 13.5864 0.400024 13.3424V13.3432ZM7.99122 14.0744V1.92323C5.77362 2.33923 3.56642 2.75283 1.36002 3.16643V12.832C3.57442 13.2464 5.77762 13.66 7.99122 14.0744ZM8.95682 6.57523C9.43922 6.57523 9.90482 6.57203 10.3696 6.57683C10.6416 6.58003 10.8448 6.78323 10.8488 7.04243C10.8528 7.30723 10.6488 7.51443 10.3696 7.52403C10.2608 7.52803 10.152 7.52483 10.0432 7.52483C9.68322 7.52483 9.32402 7.52483 8.95922 7.52483V8.47523C9.42242 8.47523 9.87682 8.47363 10.3312 8.47523C10.636 8.47683 10.848 8.67283 10.8488 8.94803C10.8496 9.22323 10.6376 9.42243 10.3336 9.42403C9.92802 9.42643 9.52242 9.42403 9.11682 9.42403C9.06402 9.42403 9.01202 9.42403 8.96162 9.42403V10.3744C9.41762 10.3744 9.86322 10.3744 10.308 10.3744C10.6352 10.3744 10.852 10.568 10.8488 10.8536C10.8464 11.1336 10.632 11.3224 10.3128 11.324C9.91202 11.3256 9.51122 11.324 9.11042 11.324C9.05842 11.324 9.00642 11.324 8.95842 11.324V12.264H14.6384V3.73283H8.96002V4.67443C9.42002 4.67443 9.86963 4.67363 10.3192 4.67443C10.6352 4.67523 10.8496 4.86963 10.8496 5.14963C10.8496 5.43043 10.6344 5.62243 10.3176 5.62323C9.91682 5.62483 9.51602 5.62323 9.11522 5.62323C9.06322 5.62323 9.01122 5.62323 8.95762 5.62323V6.57363L8.95682 6.57523Z" fill="#808080"/>
                    <path class="tab-icon" d="M5.43202 7.87109C5.80402 8.29589 6.16802 8.71269 6.53202 9.12869C6.65922 9.27349 6.78802 9.41749 6.91202 9.56469C7.10402 9.79269 7.09282 10.0735 6.88882 10.2535C6.68402 10.4335 6.40002 10.4143 6.20322 10.1927C5.77922 9.71589 5.36162 9.23349 4.94162 8.75429C4.90962 8.71749 4.87522 8.68309 4.83362 8.63749C4.54882 9.00389 4.26962 9.36229 3.99042 9.72069C3.88082 9.86149 3.77282 10.0023 3.66242 10.1423C3.46002 10.3991 3.18322 10.4463 2.95042 10.2655C2.73602 10.0991 2.71682 9.81509 2.90882 9.56629C3.30722 9.04949 3.70962 8.53589 4.10962 8.01989C4.13682 7.98469 4.16242 7.94949 4.19682 7.90309C3.90002 7.56309 3.60482 7.22629 3.31042 6.88869C3.18322 6.74309 3.05522 6.59909 2.92962 6.45269C2.72162 6.20949 2.72642 5.92789 2.94082 5.74149C3.15282 5.55749 3.43362 5.59029 3.64642 5.83109C4.00962 6.24229 4.37042 6.65669 4.73122 7.06949C4.74722 7.08789 4.76002 7.10869 4.78562 7.14389C4.83122 7.08789 4.86482 7.04789 4.89682 7.00629C5.32162 6.45989 5.74642 5.91349 6.17122 5.36709C6.30002 5.20149 6.46402 5.11429 6.67602 5.16229C6.86562 5.20549 6.98722 5.32869 7.03522 5.51829C7.07762 5.68629 7.01762 5.82789 6.91522 5.95829C6.44722 6.55909 5.98002 7.15989 5.51282 7.76149C5.48882 7.79269 5.46562 7.82469 5.43122 7.87029L5.43202 7.87109Z" fill="#808080"/>
                    <path class="tab-icon" d="M12.7496 5.6239C12.5968 5.6239 12.4432 5.6271 12.2904 5.6239C12.0088 5.6167 11.8032 5.4167 11.8016 5.1527C11.8 4.8879 12.0056 4.6807 12.284 4.6767C12.5952 4.6719 12.9064 4.6719 13.2176 4.6767C13.496 4.6815 13.7008 4.8895 13.6992 5.1543C13.6968 5.4127 13.496 5.6143 13.224 5.6239C13.0664 5.6295 12.908 5.6247 12.7496 5.6255V5.6239Z" fill="#808080"/>
                    <path class="tab-icon" d="M12.7505 6.57512C12.9089 6.57512 13.0665 6.57112 13.2249 6.57592C13.4953 6.58392 13.6969 6.78712 13.6993 7.04552C13.7017 7.30472 13.5017 7.51512 13.2321 7.52152C12.9113 7.52872 12.5897 7.52872 12.2689 7.52152C11.9993 7.51512 11.7993 7.30392 11.8017 7.04472C11.8041 6.78632 12.0057 6.58392 12.2769 6.57512C12.4345 6.57032 12.5929 6.57432 12.7513 6.57432L12.7505 6.57512Z" fill="#808080"/>
                    <path class="tab-icon" d="M12.7567 8.47517C12.9095 8.47517 13.0631 8.47197 13.2159 8.47517C13.4943 8.48237 13.6999 8.68797 13.6983 8.95197C13.6967 9.21037 13.4959 9.41597 13.2239 9.42157C12.9079 9.42797 12.5911 9.42797 12.2751 9.42157C12.0031 9.41597 11.8023 9.21117 11.7999 8.95277C11.7975 8.68797 12.0031 8.48237 12.2815 8.47517C12.4399 8.47117 12.5975 8.47517 12.7559 8.47517H12.7567Z" fill="#808080"/>
                    <path class="tab-icon" d="M12.7512 10.3751C12.9096 10.3751 13.0672 10.3711 13.2256 10.3759C13.4952 10.3847 13.6976 10.5879 13.6984 10.8471C13.7 11.1055 13.4992 11.3159 13.2296 11.3223C12.9088 11.3295 12.5872 11.3295 12.2664 11.3223C11.9976 11.3159 11.7976 11.1031 11.8008 10.8447C11.804 10.5863 12.0056 10.3847 12.2768 10.3767C12.4344 10.3719 12.5928 10.3759 12.7512 10.3767V10.3751Z" fill="#808080"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_1673_8407">
                    <rect width="16" height="16" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>
                    &nbsp; Catalog Lots
				</button>
			</li>
			@endif

			{{-----lot status editor start---}}
			@if ( count($editor_lots) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Editing']))
			<li class="nav-item tab" role="presentation" onclick="activateTab(4)">
				<button class="nav-link btn-lg tab-button tab-text" id="pills-editing-tab" data-bs-toggle="pill"
					data-bs-target="#pills-editing" type="button" role="tab" aria-controls="pills-editing"
					aria-selected="false">
				    <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1673_8415)">
                    <path class="tab-icon" d="M0.89997 0.764755C1.07277 0.398355 1.27997 0.327155 1.65197 0.507155C2.79517 1.05996 3.93917 1.61036 5.07997 2.16796C5.20157 2.22716 5.31757 2.31276 5.41357 2.40796C6.39677 3.38396 7.37517 4.36555 8.35437 5.34475C8.39197 5.38235 8.43197 5.41835 8.47597 5.45996C8.75357 5.21115 9.01277 4.95116 9.29997 4.72716C9.91597 4.24715 10.548 3.78875 11.1696 3.31516C11.2464 3.25675 11.3088 3.16876 11.3544 3.08156C11.512 2.77996 11.6384 2.46076 11.8136 2.17116C12.1472 1.62156 12.6648 1.29356 13.264 1.10316C14.0072 0.866355 14.7584 0.652755 15.5088 0.439155C15.8656 0.337555 16.1824 0.619955 16.08 0.958355C15.8352 1.76636 15.5808 2.57116 15.3048 3.36876C15.0448 4.12156 14.4872 4.59915 13.776 4.91596C13.6992 4.95036 13.6248 4.99436 13.544 5.01275C13.2896 5.07035 13.1376 5.23675 13 5.44876C12.4624 6.27596 11.8424 7.03996 11.168 7.75996C11.1072 7.82476 11.0488 7.89116 10.9488 8.00236C11.0032 8.03516 11.0632 8.05676 11.1048 8.09756C12.6176 9.60716 14.1288 11.1192 15.6408 12.6304C16.0544 13.044 16.212 13.528 16.012 14.0904C15.9528 14.2576 15.8488 14.42 15.7304 14.5544C15.5184 14.7952 15.2816 15.0144 15.0528 15.24C14.5544 15.732 13.6416 15.6928 13.1288 15.1648C12.1256 14.132 11.0968 13.124 10.0792 12.1064C9.56477 11.592 9.05037 11.0784 8.53677 10.5624C8.50237 10.528 8.47837 10.4816 8.44397 10.4328C8.10557 10.7368 7.79597 11.02 7.48157 11.2976C6.16077 12.4632 4.82957 13.6168 3.39117 14.6368C2.96957 14.936 2.51277 15.1864 2.06877 15.4544C1.84317 15.5904 1.58797 15.6024 1.33517 15.5744C1.15517 15.5544 1.03997 15.4248 0.96237 15.2664C0.93677 15.2144 0.91997 15.1584 0.89917 15.104C0.89917 15.0344 0.89917 14.9656 0.89917 14.896C0.95117 14.7424 0.98077 14.5768 1.05917 14.4384C1.31677 13.9832 1.56717 13.5208 1.86637 13.0936C3.04717 11.4048 4.38477 9.84156 5.75357 8.30396C5.83437 8.21276 5.91437 8.12076 6.01197 8.00956C5.95917 7.96716 5.91197 7.93756 5.87357 7.89916C4.87597 6.90316 3.87837 5.90635 2.88397 4.90795C2.80797 4.83195 2.73517 4.74475 2.68877 4.64955C2.08957 3.41515 1.49517 2.17836 0.89917 0.941555C0.89917 0.882355 0.89917 0.823155 0.89917 0.763155L0.89997 0.764755ZM9.07037 8.62716C8.64557 8.20316 8.23437 7.79276 7.82237 7.38076C7.82477 7.37836 7.81277 7.38716 7.80237 7.39756C6.37597 8.90876 4.99357 10.4592 3.72237 12.1056C3.17037 12.8208 2.66077 13.5696 2.13277 14.3032C2.10477 14.3424 2.08557 14.3872 2.06237 14.4296C2.07437 14.4384 2.08557 14.448 2.09757 14.4568C4.61917 12.74 6.86317 10.6912 9.07117 8.62636L9.07037 8.62716ZM3.77917 4.51436C4.71677 5.45116 5.66397 6.39756 6.61757 7.35116C7.01437 6.93756 7.42077 6.51516 7.81757 6.10236C6.87117 5.15596 5.93277 4.21755 5.00317 3.28796C4.59757 3.69436 4.18317 4.10956 3.77917 4.51515V4.51436ZM9.73677 7.95916C10.5032 7.27196 11.8928 5.60475 12.3408 4.83995C12.0944 4.59355 11.8512 4.35035 11.604 4.10396C10.464 4.84235 9.43597 5.73756 8.48237 6.70876C8.90397 7.12956 9.31677 7.54156 9.73597 7.95996L9.73677 7.95916ZM12.2064 10.4976C11.588 9.87996 10.9632 9.25595 10.3344 8.62796C9.92477 9.02476 9.50397 9.43196 9.08877 9.83436C9.73197 10.4768 10.3608 11.1048 10.9808 11.7248C11.388 11.3176 11.8024 10.9024 12.2072 10.4984L12.2064 10.4976ZM14.9832 1.56396C14.9704 1.54796 14.9576 1.53276 14.9448 1.51676C14.388 1.69516 13.8264 1.86076 13.276 2.05836C12.98 2.16476 12.7296 2.36476 12.5656 2.63996C12.4376 2.85516 12.3328 3.08555 12.2296 3.31356C12.2128 3.35035 12.2392 3.42716 12.272 3.46156C12.452 3.65196 12.64 3.83436 12.8248 4.01916C13.0568 4.25116 13.0552 4.24796 13.3664 4.12396C13.908 3.90795 14.308 3.55116 14.504 2.99196C14.6696 2.51756 14.8248 2.03916 14.9848 1.56316L14.9832 1.56396ZM14.1408 12.4264C13.7352 12.832 13.3216 13.2456 12.9104 13.6568C13.2168 13.9688 13.5288 14.2984 13.856 14.6128C14.0176 14.768 14.2568 14.7616 14.4232 14.6072C14.6584 14.3888 14.8856 14.1616 15.104 13.9264C15.2496 13.7696 15.264 13.5344 15.1192 13.384C14.7984 13.0496 14.4584 12.7344 14.1416 12.4264H14.1408ZM11.6592 12.3736C11.8592 12.5744 12.064 12.7792 12.2432 12.9592C12.6448 12.5576 13.0584 12.144 13.468 11.7344C13.28 11.5464 13.0784 11.3448 12.8832 11.1496C12.4728 11.56 12.0584 11.9752 11.6592 12.3744V12.3736ZM2.30397 1.81196C2.62797 2.48236 2.93197 3.11116 3.22637 3.71995C3.56077 3.38556 3.88317 3.06316 4.21197 2.73516C3.59837 2.43836 2.97197 2.13516 2.30397 1.81196Z" fill="#808080"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_1673_8415">
                    <rect width="16" height="16" fill="white" transform="translate(0.5)"/>
                    </clipPath>
                    </defs>
                    </svg>
                    &nbsp; Editing Lots
				</button>
			</li>
			@endif

		</ul>
	  </div>
	<!--</div>-->
</div>
<div class="row" style="margin-top: 40px;">
	
</div>

<div class="row">
	<div class="tab-content" id="pills-tabContent">

		{{-----lot status Shoot start---}}
		@if ($user_role == 'Client' || $your_assets_permissions['shoot'])
		<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				<div class="col-lg-12">
					<p class="totallotF">Total Lots: {{ count($shoot_lots) }}</p>
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
						      <p class="lot-date" style="font-weight: 500;font-size: 14px;">
								   <svg width="14" height="20" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.66667 1.16675V2.91675M9.33333 1.16675V2.91675M2.04167 5.30258H11.9583M12.25 4.95841V9.91675C12.25 11.6667 11.375 12.8334 9.33333 12.8334H4.66667C2.625 12.8334 1.75 11.6667 1.75 9.91675V4.95841C1.75 3.20841 2.625 2.04175 4.66667 2.04175H9.33333C11.375 2.04175 12.25 3.20841 12.25 4.95841Z" stroke="#808080" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.15545 7.9917H9.1607M9.15545 9.7417H9.1607M6.99711 7.9917H7.00295M6.99711 9.7417H7.00295M4.8382 7.9917H4.84403M4.8382 9.7417H4.84403" stroke="#808080" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
								 {{ date('d-m-Y' , strtotime($val['created_at']))}}
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
		@if ($user_role == 'Client' || $your_assets_permissions['Creative'])		
		<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				<div class="col-lg-11">
					<p class="totallotF ms-2">Total Lots: {{ count($creative_lots) }}</p>
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
						          	<p class="lot-date" style="font-weight: 500;font-size: 14px;">
										<svg width="14" height="20" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                         <path d="M4.66667 1.16675V2.91675M9.33333 1.16675V2.91675M2.04167 5.30258H11.9583M12.25 4.95841V9.91675C12.25 11.6667 11.375 12.8334 9.33333 12.8334H4.66667C2.625 12.8334 1.75 11.6667 1.75 9.91675V4.95841C1.75 3.20841 2.625 2.04175 4.66667 2.04175H9.33333C11.375 2.04175 12.25 3.20841 12.25 4.95841Z" stroke="#808080" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                         <path d="M9.15545 7.9917H9.1607M9.15545 9.7417H9.1607M6.99711 7.9917H7.00295M6.99711 9.7417H7.00295M4.8382 7.9917H4.84403M4.8382 9.7417H4.84403" stroke="#808080" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
										
										 {{ date('d-m-Y' , strtotime($val['created_at']))}}
									</p>
						      </div>
						      
							    <div class="col-12">
						           <p class="lot-no-heading" >Lot no</p>
						            <h3 class="status" style="font-size: 16px;">
										 {{ $val['lot_number'] }}
									</h3>
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
		@if ($user_role == 'Client' || $your_assets_permissions['Cataloging'])
		<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
			tabindex="0">
			<div class="row box-container-responsive">

				<div class="col-lg-11">
					<p class="totallotF ms-2">Total Lots: {{ count($lots_catalog) }}</p>
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
						          <p class="lot-date" style="font-weight: 500;font-size: 14px;">
								   <svg width="14" height="20" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                         <path d="M4.66667 1.16675V2.91675M9.33333 1.16675V2.91675M2.04167 5.30258H11.9583M12.25 4.95841V9.91675C12.25 11.6667 11.375 12.8334 9.33333 12.8334H4.66667C2.625 12.8334 1.75 11.6667 1.75 9.91675V4.95841C1.75 3.20841 2.625 2.04175 4.66667 2.04175H9.33333C11.375 2.04175 12.25 3.20841 12.25 4.95841Z" stroke="#808080" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                         <path d="M9.15545 7.9917H9.1607M9.15545 9.7417H9.1607M6.99711 7.9917H7.00295M6.99711 9.7417H7.00295M4.8382 7.9917H4.84403M4.8382 9.7417H4.84403" stroke="#808080" stroke-linecap="round" stroke-linejoin="round"/>
                                   </svg>
								   
								   {{ date('d-m-Y' , strtotime($val['created_at']))}}
								</p>
						    </div>
						    <div class="col-12">
						        <p class="lot-no-heading">Lot no</p>
						        <h3 class="status" style="font-size: 16px;">
									 {{ $val['lot_number'] }}
								</h3>
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
		@if ($user_role == 'Client' || $your_assets_permissions['Editing'])
		<div class="tab-pane fade" id="pills-editing" role="tabpanel" aria-labelledby="pills-editing-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				<div class="col-12">
					<p class="totallotF ms-2">Total Lots: {{ count($editor_lots) }}</p>
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
						          <p class="lot-date" style="font-weight: 500;font-size: 14px;">
									  <svg width="14" height="20" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                         <path d="M4.66667 1.16675V2.91675M9.33333 1.16675V2.91675M2.04167 5.30258H11.9583M12.25 4.95841V9.91675C12.25 11.6667 11.375 12.8334 9.33333 12.8334H4.66667C2.625 12.8334 1.75 11.6667 1.75 9.91675V4.95841C1.75 3.20841 2.625 2.04175 4.66667 2.04175H9.33333C11.375 2.04175 12.25 3.20841 12.25 4.95841Z" stroke="#808080" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                         <path d="M9.15545 7.9917H9.1607M9.15545 9.7417H9.1607M6.99711 7.9917H7.00295M6.99711 9.7417H7.00295M4.8382 7.9917H4.84403M4.8382 9.7417H4.84403" stroke="#808080" stroke-linecap="round" stroke-linejoin="round"/>
                                      </svg>
									
									 {{ date('d-m-Y' , strtotime($val['created_at']))}}
								</p>
						    </div>
						    
						    <div class="col-12">
						        <p class="lot-no-heading">Lot no</p>
						        <h3 class="status" style="font-size: 16px;">
									 {{$val['lot_number']}}
								</h3>
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
	
@endsection