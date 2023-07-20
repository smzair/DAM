@extends('layouts.DamNewMain')
@section('title')
  Your Assets - Favorites
@endsection

{{-- other css --}}
@section('other_css')
<style>
	.markk-all-read-para {
		margin-bottom: 39px;
		font-weight: 500;
		font-size: 16px;
		line-height: 24px;
		letter-spacing: 0.15px;
		/* color: #FFFFFF;
		border: 1px solid #FFFFFF; */
		color: black;
		border: 1px solid black;
		margin-top: 39px;
	}

	.headingF-notification {
		font-style: normal;
		font-weight: 600;
		font-size: 28px;
		color: #FFFFFF;
		/* color: #0F0F0F; */
		margin-top: 40px;
		margin-bottom: 0px;
	}

	.notification-horizontal-line {
		margin-top: 0px;
		margin-bottom: 0px;
	}

	.active-notification-for-page {
		font-weight: 500;
		font-size: 14px;
		letter-spacing: 0.1px;
		color: #FFFFFF;
		/* color: #0F0F0F; */
		/* margin-top: 16px; */
		margin-bottom: 0px;
		cursor: pointer;
	}

	.Inactive-notification-for-page {
		font-weight: 400;
		font-size: 14px;
		letter-spacing: 0.25px;
		color: #808080;
		margin-bottom: 0px;
		cursor: pointer;
		/* margin-top: 16px; */
	}

	.notification-time {
		font-weight: 500;
		font-size: 11px;
		letter-spacing: 0.5px;
		color: #4D4D4D;
		margin-top: 4px;
		margin-bottom: 0px;
	}

	.notification-today-yester-older {
		font-weight: 500;
		font-size: 16px;
		line-height: 24px;
		letter-spacing: 0.15px;
		color: #FFFFFF;
		/* color: #0F0F0F; */
		margin-top: 24px;
		margin-bottom: 0px;
	}

	.notification-three-dots {
		margin-top: 8px;
		color: #808080;
	}

	.popovernotification {
		position: absolute;
		top: auto;
		right: 50px;
		background-color: #0F0F0F;
		padding: 10px;
		display: none;
	}

	.notifi-remove-button {
		text-decoration: none;
		color: #FFFFFF;
		font-size: 14px;
		font-weight: 400;
	}

	.notifi-remove-button:hover {
		color: #e4dcdc;
	}

	.show-popover {
		display: block;
	}

	.all-notification-details {
		/* background: #1A1A1A; */
		padding: 16px;
	}

	hr{
		margin: 0px;
		margin-top: 1rem;
	}
</style>
@endsection

{{-- Main Contents --}}
@section('main_content')

@php
	$printedToday = false;
	$printedYesterday = false;
	$printedOlder = false;
	$total_notification = count($ClientNotification);
	$ids = json_encode(array_column($ClientNotification, 'id'),true);
	// dd($ClientNotification);
@endphp
	
	<div class="row">
		<div class="col-12">
			<a class="btn btn-light border-0 back-btn" href="#" role="button"><svg width="22" height="14"
					viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.69628 1.5L1 7L6.69628 12.5M21 7H1.15953" stroke="#9F9F9F" stroke-width="1.5"
						stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				&nbsp; back</a>
		</div>
		<div class=" col-12 d-flex justify-content-between">
			<div>
				<h4 class="headingF-notification">
					Notification
				</h4>
				<p class="underheadingF">
					You have <span id="notify-count" >{{$total_notification}}</span> new notifiations
				</p>
			</div>
			<p class="p-2 markk-all-read-para" style="cursor: pointer;" onclick="set_notifiction_to_seen({{$ids}})">Mark all read</p>
		</div>
	</div>
	<hr class="notification-horizontal-line">

	<!-- notification Start time wise -->
	
	@foreach ($ClientNotification as $key => $row)
		<?php
			$day_ago = timeBefore($row['created_at']);
			$is_seen = $row['is_seen'];
			$is_active_notification_class = $is_seen == 1 ? 'Inactive-notification-for-page' : 'active-notification-for-page';

			$created_at = date('Y-m-d', strtotime($row['created_at']));
			$today = date('Y-m-d');
			$yesterday = date('Y-m-d', strtotime('-1 day'));

			if (!$printedToday) {
				echo '<p class="notification-today-yester-older" style="margin-bottom:24px;">Today</p>';
				$printedToday = true;
			}
			if ($today > $created_at && !$printedYesterday) {
				echo '<p class="notification-today-yester-older" style="margin-bottom:24px;">Yesterday</p>';
				$printedYesterday = true;
			}
			if ($yesterday > $created_at && !$printedOlder) {
				echo '<p class="notification-today-yester-older" style="margin-bottom:24px;">Older</p>';
				$printedOlder = true;
			}
			$is_manual_notification = $row['is_manual_notification'];
		?>

		<div class="row notification_row notificationId{{$row['id']}}">
			<div class="all-notification-details">
				<div class="col-12 d-flex justify-content-between">
					<div>
						<p class="{{$is_active_notification_class}}">
							{{$row['discription']}}
						</p>
						<p class="notification-time">
							{{$day_ago}}
						</p>
					</div>
					<a href="javascript:;" class="notification-three-dots {{$is_manual_notification == 'No' ? '' : 'd-none'}}" role="button" id="popover-trigger-notification">
						<i class="bi bi-three-dots-vertical" style="font-size:20px">
						</i>
					</a>
					
					<!-- Delete Popover -->
					<div class="popovernotification" id="popover-content-notification">
						<input type="hidden" class="notificationId" name="notificationId" value="{{$row['id']}}" >
						<span>
							<a href="javascript:;" role="button" class="notifi-remove-button">Remove 
								<i class="bi bi-trash" style="color: red;"></i>
							</a>
						</span>
					</div>
				</div>
				<hr>
			</div>
		</div>
			
	@endforeach

	@php
		// dd($ClientNotification);
	@endphp

	{{-- <p class="notification-today-yester-older">Yesterday</p>
	<div class="row" style="margin-top:24px;">
		<div class="all-notification-details">
			<div class="col-12 d-flex justify-content-between">
				<div>
					<p class="Inactive-notification-for-page">
						Armani Exchange lot no. “ODN10032023BEUCBFZ76” status has changed to task started.
					</p>
					<p class="notification-time">
						3 Days ago
					</p>
				</div>
				<a href="#" class="notification-three-dots" role="button" id="popover-trigger-notification">
					<i class="bi bi-three-dots-vertical" style="font-size:20px">
					</i>
				</a>

				<!-- Delete Popover -->
				<div class="popovernotification" id="popover-content-notification">
					<span>
						<a href="#" role="button" class="notifi-remove-button">Remove</a>
					</span>
					<i class="bi bi-trash" style="color: red;"></i>
				</div>
			</div>
			<hr>
			<div class="col-12 d-flex justify-content-between">
				<div>
					<p class="Inactive-notification-for-page">
						Armani Exchange lot no. “ODN10032023BEUCBFZ76” status has changed to task started.
					</p>
					<p class="notification-time">
						5 Days ago
					</p>
				</div>
				<a href="#" class="notification-three-dots" role="button" id="popover-trigger-notification">
					<i class="bi bi-three-dots-vertical" style="font-size:20px">
					</i>
				</a>

				<!-- Delete Popover -->
				<div class="popovernotification" id="popover-content-notification">
					<span>
						<a href="#" role="button" class="notifi-remove-button">Remove</a>
					</span>
					<i class="bi bi-trash" style="color: red;"></i>
				</div>
			</div>
			<hr>
			<div class="col-12 d-flex justify-content-between">
				<div>
					<p class="Inactive-notification-for-page">
						Armani Exchange lot no. “ODN10032023BEUCBFZ76” status has changed to task started.
					</p>
					<p class="notification-time">
						6 Days ago
					</p>
				</div>
				<a href="#" class="notification-three-dots" role="button" id="popover-trigger-notification">
					<i class="bi bi-three-dots-vertical" style="font-size:20px">
					</i>
				</a>

				<!-- Delete Popover -->
				<div class="popovernotification" id="popover-content-notification">
					<span>
						<a href="#" role="button" class="notifi-remove-button">Remove</a>
					</span>
					<i class="bi bi-trash" style="color: red;"></i>
				</div>
			</div>
			<hr>
		</div>
	</div> --}}

	{{-- <p class="notification-today-yester-older">Older</p>
	<div class="row">
		<div class="all-notification-details">
			<div class="col-12 d-flex justify-content-between">
				<div>
					<p class="Inactive-notification-for-page">
						Armani Exchange lot no. “ODN10032023BEUCBFZ76” status has changed to task started.
					</p>
					<p class="notification-time">
						May ‘23
					</p>
				</div>
				<a href="#" class="notification-three-dots" role="button" id="popover-trigger-notification">
					<i class="bi bi-three-dots-vertical" style="font-size:20px">
					</i>
				</a>

				<!-- Delete Popover -->
				<div class="popovernotification" id="popover-content-notification">
					<span>
						<a href="#" role="button" class="notifi-remove-button">Remove</a>
					</span>
					<i class="bi bi-trash" style="color: red;"></i>
				</div>
			</div>
			<hr>
			<div class="col-12 d-flex justify-content-between">
				<div>
					<p class="Inactive-notification-for-page">
						Armani Exchange lot no. “ODN10032023BEUCBFZ76” status has changed to task started.
					</p>
					<p class="notification-time">
						Jun ‘23
					</p>
				</div>
				<a href="#" class="notification-three-dots" role="button" id="popover-trigger-notification">
					<i class="bi bi-three-dots-vertical" style="font-size:20px">
					</i>
				</a>

				<!-- Delete Popover -->
				<div class="popovernotification" id="popover-content-notification">
					<span>
						<a href="#" role="button" class="notifi-remove-button">Remove</a>
					</span>
					<i class="bi bi-trash" style="color: red;"></i>
				</div>
			</div>
			<hr>
			<div class="col-12 d-flex justify-content-between">
				<div>
					<p class="Inactive-notification-for-page">
						Armani Exchange lot no. “ODN10032023BEUCBFZ76” status has changed to task started.
					</p>
					<p class="notification-time">
						Jun ‘23
					</p>
				</div>
				<a href="#" class="notification-three-dots" role="button" id="popover-trigger-notification">
					<i class="bi bi-three-dots-vertical" style="font-size:20px">
					</i>
				</a>

				<!-- Delete Popover -->
				<div class="popovernotification" id="popover-content-notification">
					<span>
						<a href="#" role="button" class="notifi-remove-button">Remove</a>
					</span>
					<i class="bi bi-trash" style="color: red;"></i>
				</div>
			</div>
			<hr>
		</div>
	</div> --}}
	
@endsection

{{-- js scripts --}}
@section('js_scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		var triggers = document.getElementsByClassName("notification-three-dots");
		var popovers = document.getElementsByClassName("popovernotification");

		for (var i = 0; i < triggers.length; i++) {
			triggers[i].addEventListener("click", function (e) {
				e.stopPropagation();
				var popovernotification = this.nextElementSibling;
				popovernotification.classList.toggle("show-popover");
			});
		}

		document.addEventListener("click", function () {
			for (var i = 0; i < popovers.length; i++) {
				// popovers[i].classList.remove("show-popover");
			}
		});
	});

</script>

{{-- Remove Notification --}}
<script>
	$(document).ready(function() {
    $('.notifi-remove-button').click(function() {
			let notificationId = $(this).closest('.popovernotification').find('.notificationId').val();
			let n_count = +$('#notify-count').text();
			
			const csrfToken = '{{ csrf_token() }}'
			$.ajax({
				url: "remove_notifiction",
				type: "POST",
				dataType: 'json',
				data: {
					notificationId: notificationId,
				},
				headers: {
					'X-CSRF-Token': csrfToken
				},
				success: function(res) {
					if(res.status){
						notificationId_id = 'notificationId'+notificationId
						$('.'+notificationId_id).addClass('d-none');
						$('.'+notificationId_id).remove();
						$('#notify-count').text(n_count-1)
					}
				},
				error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
			});

    });
	});
</script>
	
@endsection
