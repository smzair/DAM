Hello {{$user->name}}, 

<br><br>
Welcome To ODN Digital 
<br><br>
Client - id => {{$user->client_id}}
<br>
Your Login Credential are :
<br><br/>
Email : {{$user->email}}
<br>

password : {{$user->readable_password}}
<br>

Please Click The Link Below To Veirfy Your Email & Activate Your Account Before Signing In!
<br>
<a class="btn btn-warning"  href="{{route('sendEmailDone',["email"=> $user->email,"verifyToken"=>$user->verifyToken])}}">Verify Your Account</a>
<br><br>
<h4>Recommended:</h4> <p>Kindly Change Your Password After Verification is Done</p> 

<br><br>
Thank You!
<br>
ODN.Connect | Innovative Content Creators