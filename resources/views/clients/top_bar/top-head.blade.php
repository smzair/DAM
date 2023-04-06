<nav class="main-header navbar navbar-expand navbar-white navbar-light custom-dashboard-header">
    <!-- Left navbar links -->
    <div class="navbar-nav">
        <div class="dash-mobile-trigger">
            <img src="{{ asset('assets-images\Mob-Assets\images\line_img.png')}}" alt="Mobile Trigger">
        </div>
        <div class="welcome-user-title">
            <?php 
            $user_data = Auth::user();         
            $ClientNotification = getNotificationList($user_data);
            $tot_notification = count($ClientNotification);
            // dd($tot_notification , $ClientNotification);
            ?>
            <h4>Hello, {{ ucwords($user_data->name) }}</h4>
            <p>Welcome back!</p>
            
            <!-- Notification HTML -->
            <div class="notification-bell">
                <span class="bell-drop">
                  <img src="assets-images\Desktop-Assets\main-dashboard_Icons\notification.svg" class="bell-normal" alt="Notification Bell">
                  <img src="assets-images\Desktop-Assets\main-dashboard_Icons\notification-active.svg" class="bell-active" alt="Notification Bell">
                  <i id="notify-count">{{$tot_notification}}</i>
                </span>
                <div class="notification-dropdown">
                  <div class="notification-inner">
                    <div class="notification-header">
                      <div class="notification-title">
                        <h6>Notifications</h6>
                      </div>
                      {{-- <div class="read-mark-link">
                        <a href="#" id="markReadlink">
                          <img src="assets-images\Desktop-Assets\dashboard home\markread.svg" alt="Read">
                          <span>Mark as read</span>
                        </a>
                      </div> --}}
                    </div>
                    <div class="notification-body">
                        @if ($tot_notification > 0)
                            @foreach ($ClientNotification as $row)

                                <?php 
                                    $create_date_is = date('Y-m-d H:i:s',strtotime($row['created_at']));										
                                    $cur_date = date("Y-m-d H:i:s") ;
                                    $date1=date_create($create_date_is);
                                    $date2=date_create($cur_date);
                                    $diff=date_diff($date1,$date2);
                                    $day_ago = $diff->format("%m month %a days %H hour %i minyu %s sec ago \n");

                                    if ($diff->format("%Y") != 0) {
                                        $day_ago = $diff->format("%Y Year ago");										 	
                                    }else  if ($diff->format("%m") > 0) {
                                        $day_ago = $diff->format("%m Month ago");
                                    }else  if ($diff->format("%a") != 0) {
                                        $day_ago = $diff->format("%a day ago");
                                    }else  if ($diff->format("%H") != 0) {
                                        $day_ago = $diff->format("%H hour ago");
                                    }else{
                                        $day_ago = $diff->format("%i minute %s second ago");
                                    }
										
                                ?>
                                <div class="notification-item noread-notification-item">
                                    <div class="notify-item-details">
                                        <p class="notify-alert" id="notifyalert">{{$row['subject']}}</p>
                                        <span class="notify-date" id="notifydate">{{$day_ago}}</span>
                                    </div>
                                    <div class="notify-close">
                                        <a href="javascript:;" class="close-link-notify">
                                            <input type="hidden" name="notificationId" value="{{base64_encode($row['id'])}}">
                                            <img id="{{base64_encode($row['id'])}}" src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            {{-- 
                            <div class="notification-item noread-notification-item">
                                <div class="notify-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                                    <defs>
                                        <clipPath id="clip-path">
                                        <rect id="Rectangle_2689" data-name="Rectangle 2689" width="14" height="14" transform="translate(0.285 0.285)" fill="#fff"/>
                                        </clipPath>
                                    </defs>
                                    <g id="Mask_Group_74" data-name="Mask Group 74" transform="translate(-0.285 -0.285)" clip-path="url(#clip-path)">
                                        <path id="send" d="M13.682.823a.56.56,0,0,0-.595-.077L1.543,6.165V7.213L6.392,9.153,9.5,13.937h1.049L13.864,1.394a.56.56,0,0,0-.182-.571ZM9.9,12.937,7.23,8.825l4.113-4.506-.651-.594L6.547,8.265l-4-1.6L12.835,1.838Z" transform="translate(-0.74 0.148)" fill="#fff"/>
                                    </g>
                                    </svg>                      
                                </div>
                                <div class="notify-item-details">
                                    <p class="notify-alert" id="notifyalert">Your email has been changed</p>
                                    <span class="notify-date" id="notifydate">10 MIN. AGO</span>
                                </div>
                                <div class="notify-close">
                                    <a href="javascript:;" class="close-link-notify">
                                    <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                                    </a>
                                </div>
                            </div>

                            <div class="notification-item noread-notification-item">
                                <div class="notify-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
                                    <path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
                                    </svg>
                                </div>

                                <div class="notify-item-details">
                                    <p class="notify-alert" id="notifyalert">Your order has been placed</p>
                                    <span class="notify-date" id="notifydate">FEB 04, 2022 AT 5:55 PM</span>
                                    <a href="#" class="btn notify-btn" id="notifyBTN">
                                    Track order
                                    </a>
                                </div>

                                <div class="notify-close">
                                    <a href="javascript:;" class="close-link-notify">
                                    <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                                    </a>
                                </div>
                            </div>

                            <div class="notification-item">
                                <div class="notify-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
                                    <path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
                                    </svg>
                                </div>
                                <div class="notify-item-details">
                                    <p class="notify-alert" id="notifyalert">Your order has been successfully completed</p>
                                    <span class="notify-date" id="notifydate">JAN 15, 2022 AT 3:15 PM</span>
                                    <a href="#" class="btn notify-btn" id="notifyBTN">
                                    Write a review
                                    </a>
                                </div>
                                <div class="notify-close">
                                    <a href="javascript:;" class="close-link-notify">
                                    <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                                    </a>
                                </div>
                            </div>

                            <div class="notification-item">
                                <div class="notify-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                                    <defs>
                                        <clipPath id="clip-path">
                                        <rect id="Rectangle_2689" data-name="Rectangle 2689" width="14" height="14" transform="translate(0.285 0.285)" fill="#fff"/>
                                        </clipPath>
                                    </defs>
                                    <g id="Mask_Group_74" data-name="Mask Group 74" transform="translate(-0.285 -0.285)" clip-path="url(#clip-path)">
                                        <path id="send" d="M13.682.823a.56.56,0,0,0-.595-.077L1.543,6.165V7.213L6.392,9.153,9.5,13.937h1.049L13.864,1.394a.56.56,0,0,0-.182-.571ZM9.9,12.937,7.23,8.825l4.113-4.506-.651-.594L6.547,8.265l-4-1.6L12.835,1.838Z" transform="translate(-0.74 0.148)" fill="#fff"/>
                                    </g>
                                    </svg>  
                                </div>
                                <div class="notify-item-details">
                                    <p class="notify-alert" id="notifyalert">Your order was cancelled</p>
                                    <span class="notify-date" id="notifydate">JAN 10, 2022 AT 4:17 PM</span>
                                </div>
                                <div class="notify-close">
                                    <a href="javascript:;" class="close-link-notify">
                                    <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                                    </a>
                                </div>
                            </div> 
                            --}}
                        @else
                            <div>
                                <p>No unseen new notification.</p>
                            </div>                            
                        @endif
                    </div>
                    <div class="notification-footer">
                      <a href="{{route('allnotification')}}" class="all-notify-link" id="allnotifyLink">
                        See all notifications
                      </a>
                    </div>
                  </div>
                </div>
            </div>
            <!-- End of Notification HTML -->
        </div>
    </div>
</nav>