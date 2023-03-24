<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <p>Hello <strong> {{$user->name}}, </strong> </p>
    <p>
        <strong> Welcome To ODN Digital</strong>
    </p>
    <p>Client - id <strong> {{$user->client_id}}, </strong> </p>
    <p>Email : <strong> {{$user->email}}</strong></p> 
    <p>Phone : <strong> {{$user->phone}}</strong></p> 
    <p>
        <?php if($other_data['otpfor'] == 1){ ?>
            Your Email Varification Otp is : 
        <?php }else{ ?>
            Your Phone Varification Otp is : 
        <?php }?>
        <strong style="color: rgb(31, 107, 12)"> {{$other_data['otp']}} </strong>
        <br>
        <span style="color: red">valid for 5 minutes</span>
    </p>

    <p>
        <br><br>
        <strong>Thank You! </strong>
        <br>
        <strong>ODN.Connect | Innovative Content Creators</strong>
        <br><br>
    </p>
   
</body>
</html>
