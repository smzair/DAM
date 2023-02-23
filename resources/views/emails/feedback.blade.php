<!DOCTYPE html>
<html lang="en">

 <head>  
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width,initial-scale=1 user-scalable=yes">
   <meta name="x-apple-disable-message-reformatting">
   <meta name="color-scheme" content="#FBFC00">
   <meta name="supported-color-schemes" content="#FBFC00">
   <title>Feedback</title>
   <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        html {
            height: 100% !important;
            width: 100% !important;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.5;
            color: #FBFBFB;
            height: 100% !important;
            width: 100% !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
            background-color: #000000;
        }

        p {
            margin: 0;
        }

        a {
            color: #000;
            text-decoration: none;
        }

        img {
            display: inline-block;
            vertical-align: middle;
            max-width: 100%;
        }

        .logo-td {
            padding: 18px 0px 18px 14px;
        }

        .custom-logo {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
        }

        .logo-img {
            flex: 0 0 auto;
            margin-right: 8px;
        }

        .links-td {
            color: #FBFBFB;
            padding: 18px 15px 18px 0;
        }

        .custom-right-content {
            text-align: right;
        }

        .custom-right-content * {
            color: #FBFBFB;
        }

        .logo-info {
            flex: 0 0 auto;
        }

        /* .logo-img img {
            width: 40px;
        } */

        .custom-right-content p span.header-link {
            display: block;
        }

        .m-content {
            padding: 40px 15px;
        }

        .content-info {
            display: block;
            width: 100%;
        }

        .content-info p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .content-button {
            display: block;
            width: 100%;
            text-align: center;
        }

        .content-btn {
            display: inline-block;
            width: auto;
            height: auto;
            appearance: none;
            padding: 8px 16px;
            font-size: inherit;
            line-height: inherit;
            border: 1px solid;
            border-radius: 4px;
            font-weight: 500;
            margin-top: 10px;
            min-width: 180px;
        }

        .content-btn.y-btn {
            color: #000000;
            background-color: #FBFC00;
            border-color: transparent;
        }

        .content-btn.b-btn {
            color: #FBFC00;
            background-color: #000;
            border-color: #FBFC00;
            font-weight: 400;
        }

        .content-button .btn-span {
            display: block;
        }

        .thank-you {
            padding: 40px 0;
            text-align: center;
            padding-bottom: 0;
        }

        .thank-you p {
            font-weight: 300;
            display: block;
            margin-bottom: 10px;
        }

        .thank-you .thankyou-img {
            display: inline-block;
        }

        .content-info p:last-child {
            margin-bottom: 30px;
        }

        .footer-img img {
            width: 100%;
        } 
        
        @media (min-width: 768px) {
            .footer-img.m-image {
                display: none;
            }

            .footer-img.d-image {
                display: block;
            }
        }

        @media (max-width: 767px) {
            body {
                font-size: 10px;
            }

            .content-info p {
                font-size: 12px;
            }

            .footer-img.m-image {
                display: block;
            }

            .footer-img.d-image {
                display: none;
            }
            
            .hero-banner {
                background-image: url('{{$data['bannerSm']}}') !important;
                height: 160px !important;
            }
            
        }
   </style>
 </head>
 <body width="100%" style="margin: 0; padding: 0; background-color: #7D7D7D;">
    <center style="width: 100%; background-color: #7D7D7D;">
        <div class="email-container" style="max-width: 600px; margin: 0 auto;">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tbody>
                    <tr>
                        <td class="logo-td">
                            <div class="custom-logo">
                                <div class="logo-img">
                                    <img src="{{$data['logoimg']}}" alt="ODN">
                                </div>
                                <div class="logo-info">
                                    <p style="color: #FBFBFB; padding-top:50%; font-size:10px">
                                        Content Partner
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="links-td">
                            <div class="custom-right-content">
                                <p>
                                    <span class="header-link odn-link" style="color:yellow;" id="headerLink1"><a href="mailto:opendoors@odndigital.com" style="color:yellow; font-size:10px;">opendoors@odndigital.com</a></span>
                                    <span class="header-link odn-w-link" style="color:yellow;" id="headerLink2"><a href="www.odndigital.com" style="color:yellow; font-size:10px;">www.odndigital.com</a></span>
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="hero-banner" style="background-size: cover; height: 200px; background-repeat: no-repeat; background-position: center;">
                            <div class="banner d-banner">
                                <img src="{{$data['banners']}}" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-td" colspan="2">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td class="m-content">
                                            <div class="content-info">
                                                <p style="color: #FBFBFB;">Hello <span id="userName">{{$data['name']}}!</span></p>
                                                <p style="color: #FBFBFB;">Thanks for your business. To help us improve our services, we request
                                                    you to kindly participate in a short feedback session.</p>
                                                <p style="color: #FBFBFB;">This feedback will take about 5 minutes of your time.</p>
                                            </div>
                                            <div class="content-button">
                                                <span class="btn-span">
                                                    <a href="{{$data['url']}}" target="_blank" class="content-btn y-btn" id="startBTN">Click here to start!</a>
                                                </span>
                                                <span class="btn-span">
                                                    <a href="{{$data['Rurl']}}" class="content-btn b-btn" id="skipBTN">I would rather skip.</a>
                                                </span>
                                            </div>
                                            <div class="thank-you">
                                                <p style="color: #FBFBFB;">We appreciate your time!</p>
                                                <span class="thankyou-img">
                                                    <img src="{{$data['thank']}}" alt="Thank You">
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="footer-img d-image">
                                                <img src="{{$data['footrs']}}" alt="Footer">
                                            </div>
                                            <div class="footer-img m-image">
                                                <img src="{{$data['footrM']}}" alt="Footer">
                                            </div>
                                            
                                        
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </center>
 </body>
</html>
