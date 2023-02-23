<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You Page</title>
    <meta name="author" content="ODN Digital Services">
    <meta name="theme-color" content="#FBFC00" />

    <link rel="apple-touch-icon" href="Images\logo.svg">

    <link rel="shortcut icon" type="image/x-icon" href="Images\logo.svg">

    <!-- Theme Style  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    
    <!-- Common Style  -->
    <link rel="stylesheet" src="http://127.0.0.1:8000/dist/css/style.css">
   <!-- Common Style  -->
<style type="text/css">
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    font-size: 16px;
}

body {
    font-size: 1.15rem;
    line-height: 1.2;
    font-weight: 400;
    color: #F7F7F7;
    font-style: normal;
    background-color: #FBFC00;
    font-family: 'Raleway', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

p {
    margin: 0 0 10px 0;
}

a {
    text-decoration: none;
    color: #000;
}

a:hover,
a:focus {
    text-decoration: none;
    color: #000;
    outline: 0;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    font-family: 'Raleway', sans-serif;
    font-weight: 600;
    font-style: normal;
    margin: 0 0 15px 0;
    color: #F7F7F7;
    line-height: 1.1;
}

h1 {
    font-size: 60px;
}

h2 {
    font-size: 58px;
}

h3 {
    font-size: 55px;
}

h4 {
    font-size: 53px;
}

h5 {
    font-size: 50px;
}

h6 {
    font-size: 40px;
}

.page-center {
    width: 100%;
    display: block;
}

form {
    width: 100%;
    display: block;
}

img {
    display: inline-block;
    max-width: 100%;
    vertical-align: middle;
    border-style: none;
}

button, .btn {
    display: inline-block;
    vertical-align: middle;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
    padding: 12px 30px;
    font-size: inherit;
    line-height: 1.2;
    font-family: 'Raleway', sans-serif;
    font-weight: 400;
    color: #FFFFFF;
    background-color: #000000;
    text-transform: uppercase;
    text-align: center;
    outline: 0;
    border: 1px solid transparent;
    appearance: none;
    width: auto;
    height: auto;
    transition: all 0.3s ease-in-out;
    box-shadow: none !important;
}

button:hover, .btn:hover {
    background-color: #000;
    border-color : transparent;
    color: #FBFC00;
}

button:focus, .btn:focus {
    outline: 0;
    box-shadow: none !important;
    background-color: #000;
    border-color : transparent;
    color: #FBFC00;
}


/* Main Style */

.site-wrapper {
    height: 100vh;
    display: flex;
    flex-wrap: nowrap;
    width: 100%;
}

.header-container-wrapper, .body-container-wrapper {
    width: 50%;
    flex: 0 0 auto;
}

.header-container-wrapper {
    background-color: #000;
}

.body-container-wrapper {
    background-color: #FBFC00;
}

.custom-header-content, 
.custom-body-content {
    padding-left: 80px;
    padding-right: 80px;
}

.custom-main-section {
    display: flex;
    height: calc(100vh - 80px);
    align-items: center;
}

.col-header {
    min-height: 80px;
}

.custom-hor-space {
    display: block;
    width: 100%;
}

.custom-hor-space .inner-hor-space {
    height: 100%;
}

.custom-action-btn-wrapper {
    display: block;
    width: 100%;
    margin-top: 30px;
}

.form-control {
    font-size: 15px;
    border: 0;
    background-color: transparent !important;
    border-bottom: 2px solid #000 !important;
    padding: 4px 2px;
    color: #000;
    line-height: 1.1;
    font-style: italic;
    font-weight: 500;
    box-shadow: none !important;
    border-radius: 0;
    display: block;
    width: 100%;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    margin-bottom: 25px;
    -webkit-appearance: auto;
    -moz-appearance: auto;
    appearance: auto;
}


/* Start Page Style  */

.start-page-wrapper {
    height: auto;
    flex-wrap: wrap;
}

.start-page-wrapper .header-container-wrapper, 
.start-page-wrapper .body-container-wrapper {
    width: 100%;
    flex: 0 0 auto;
}

.start-page-wrapper .custom-header-content, 
.start-page-wrapper .custom-body-content {
    padding-left: 0;
    padding-right: 0;
}

.start-page-wrapper .custom-main-section {
    display: flex;
    height: calc(50vh - 80px);
    text-align: center;
}

.start-page-wrapper .custom-main-section.black-section {
    align-items: flex-end;
    justify-content: center;
}

.start-page-wrapper .custom-main-section.yellow-section {
    align-items: flex-start;
    height: 50vh;
}

.start-page-wrapper .custom-hor-space {
    display: none;
}

.start-page-wrapper .main-p-content {
    max-width: 900px;
    margin: 0 auto;
    padding-top: 40px;
    padding-bottom: 40px;
    color: #000000;
}

/* End of Start Page Style */

/* Survey Page Wrapper */

.survey-page-wrapper .custom-main-section.black-section {
    flex-wrap: wrap;
}

/* .survey-page-wrapper .custom-main-section.black-section .main-p-title {
    align-self: flex-end;
} */

.survey-page-wrapper .custom-main-section.black-section .main-p-content {
    align-self: flex-start;
}

.survey-page-wrapper .custom-main-section.black-section .main-p-content p {
    margin: 0;
}

.custom-feedback-survey-wrapper {
    width: 100%;
    display: block;
    color: #000;
}

.form-group {
    display: block;
    width: 100%;
    margin-bottom: 10px;
}

.group-inner {
    position: relative;
    display: block;
    width: 100%;
}

.survery-qus-wrapper {
    margin-bottom: 20px;
    font-weight: 500;
}

.survery-qus-wrapper p {
    margin: 0;
}

.rating-value-wrapper {
    display: block;
    width: 100%;
    margin-bottom: 30px;
}

.rating-value-label {
    width: 100%;
    display: flex;
    justify-content: space-between;
    position: relative;
    font-weight: 400;
    font-size: 14px;
}

.rating-value-label .val-label-span {
    display: inline-block;
    font-weight: 500;
}

.feedback-action-wrapper {
    display: flex;
    width: 100%;
    margin-top: 20px;
    align-items: center;
    justify-content: space-between;
}

.feedback-action-wrapper .btn {
    padding: 8px 20px;
    font-size: 1rem;
    font-weight: 500;
}

.feedback-action-wrapper .btn.action-btn.deactive {
    pointer-events: none;
    opacity: 0.5;
}

.rating-value-list {
    display: flex;
    width: 100%;
    position: relative;
    justify-content: space-between;
    margin-bottom: 5px;
}

.rating-value-list > .rating-value-item {
    width: 40px;
    height: 40px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: 400;
    font-family: 'Roboto', sans-serif;
    text-align: center;
    position: relative;
    background-color: rgba(0,0,0,0.1);
    border: 1px solid rgba(0, 0, 0, 0.8);
}

.rating-value-list > .rating-value-item > * {
    cursor: pointer;
}

.rating-value-list > .rating-value-item .rating-input {
    position: absolute;
    width: 100%;
    height: 100%;
    appearance: none;
    z-index: 3;
    background-color: rgba(0,0,0,0.1);
    border: 1px solid rgba(0, 0, 0, 0.8);
    border-radius: 5px;
    opacity: 0;
    visibility: hidden;
}

.rating-value-list > .rating-value-item label.rating-text {
    z-index: 2;
    position: relative;
}

.rating-value-list > .rating-value-item.checked {
    background-color: #000;
}

.rating-value-list > .rating-value-item.checked label.rating-text {
    color: #FFFFFF;
} 

.rating-value-list > .rating-value-item:hover {
    background-color: #000;
}

.rating-value-list > .rating-value-item:hover label.rating-text {
    color: #FFFFFF;
} 

/* .rating-value-list > .rating-value-item .rating-input {
    position: absolute;
    width: 100%;
    height: 100%;
    appearance: none;
    z-index: 2;
    background-color: rgba(0,0,0,0.1);
    border: 1px solid rgba(0, 0, 0, 0.8);
    border-radius: 5px;
}

.rating-value-list > .rating-value-item label.rating-text {
    z-index: 3;
    position: relative;
}

.rating-value-list > .rating-value-item .rating-input:checked {
    background-color: #000000;
}

.rating-value-list > .rating-value-item .rating-input:checked ~ label.rating-text {
    color: #FFFFFF;
}

.rating-value-list > .rating-value-item .rating-input:hover {
    background-color: #000000;
}

.rating-value-list > .rating-value-item .rating-input:hover ~ label.rating-text {
    color: #FFFFFF;
} */


.feedback-survey-form .form-group:not(:first-of-type) {
    display: none;
}


.rating-select-dropdown-wrapper {
    display: block;
    width: 100%;
    margin-bottom: 30px;
}

.select-dropdown-group {
    display: block;
    width: 100%;
}

.select-dropdown-group:not(:last-of-type) {
    margin-bottom: 15px;
}

.select-dropdown-group > label.control-label {
    margin-bottom: 10px;
    font-size: 15px;
    font-style: normal;
    font-weight: 500;
}

.red-star {
    display: inline-block;
    color: #FF0000;
}

.form-control::placeholder {
    color: #000;
    font-weight: 100;
}

.rating-value-list.rating-val-three-grp {
    justify-content: flex-start;
    margin-top: 10px;
    margin-bottom: 20px;
}

.rating-value-list.rating-val-three-grp > .rating-value-item {
    width: 90px;
    height: 40px;
    font-size: 0.9rem;
}

.rating-value-list.rating-val-three-grp > .rating-value-item:not(:last-child) {
    margin-right: 20px;
}

.select-dropdown-group > label.control-label.suggestion-label {
    font-size: 14px;
    line-height: 1.5;
    display: block;
    margin-bottom: 20px;
}

/* End of Survey Page Wrapper */

/* Thank you page Style */

.thankyou-page-wrapper .header-container-wrapper {
    background-color: #FBFC00;
}

.thankyou-page-wrapper .body-container-wrapper {
    background-color: #000000;
}

.custom-thankyou-wrapper {
    text-align: center;
}

.custom-thankyou-wrapper .like-icon {
    margin-bottom: 30px;
}

.custom-thankyou-wrapper h6 {
    font-weight: 400;
}

/* End of Thank you page Style */

/* Media Queries */

@media (max-width: 767px) {
    .site-wrapper {
        flex-wrap: wrap;
    }
    
    .header-container-wrapper, .body-container-wrapper {
        width: 100%;
        flex: 1 1 auto;
    }
    
    .main-p-content {
        display: none;
    }
    
    .custom-header-content, .custom-body-content {
        padding-left: 20px;
        padding-right: 20px;
    }
    
    .custom-main-section {
        display: block;
        height: auto;
    }
    
    .custom-hor-space {
        display: none;
    }
    
    h1 {
        font-size: 40px;
    }
    
    .main-p-title {
        text-align: center;
    }
    
    .custom-main-section {
        padding-top: 50px;
        padding-bottom: 50px;
    }
    
    .col-header {
        min-height: 40px;
    }
    
    .custom-logo img {
        max-width: 40px;
    }

    body {
        font-size: 1rem;
    }
    
    .rating-value-list > .rating-value-item {
        width: 30px;
        height: 30px;
    }
    
    .rating-value-label {
        font-size: 13px;
    }
    
    .rating-value-wrapper {
        margin-bottom: 20px;
    }

    .feedback-action-wrapper .btn {
        padding: 6px 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .back-btn img {
        max-width: 80%;
    }

    .select-dropdown-group > label.control-label {
        font-size: 14px;
    }
    
    .form-control {
        font-size: 14px;
        margin-bottom: 20px;
    }
    
    .select-dropdown-group:not(:last-of-type) {
        margin-bottom: 10px;
    }

    .start-page-wrapper .custom-main-section {
        display: block;
    }
    
    .start-page-wrapper .custom-main-section.yellow-section {
        height: auto;
    }
    
    .start-page-wrapper .main-p-content {
        display: block;
        padding: 0;
    }

    .start-page-wrapper .custom-main-section.black-section {
        height: auto;
    }

    .thankyou-page-wrapper .custom-main-section.black-section {
        display: none;
    }
        
    .thankyou-page-wrapper .header-container-wrapper {
        display: none;
    }
    
    .thankyou-page-wrapper .custom-thankyou-wrapper .like-icon img {
        max-width: 80px;
    }
    
    .thankyou-page-wrapper .custom-main-section.yellow-section {
        height: 100vh;
        display: flex;
        justify-content: center;
    }
    
    h6 {
        font-size: 25px;
    }
}

/* End of Media Queries */

/* End of Main Style */
</style>
</head>
<body>
    <div class="site-wrapper thankyou-page-wrapper">
        <div class="header-container-wrapper">
            <div class="page-center">
                <div class="container">
                    <div class="custom-header-content">
                        <div class="custom-hor-space col-header">
                            <div class="inner-hor-space"></div>
                        </div>
                        <div class="custom-main-section black-section">
                            <div class="odn-image">
                                <img src="Images\Thank-ODN.png" alt="ODN">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-container-wrapper">
            <div class="page-center">
                <div class="container">
                    <div class="custom-body-content">
                        <div class="custom-hor-space col-header">
                            <div class="inner-hor-space"></div>
                        </div>
                        <div class="custom-main-section yellow-section">
                            <div class="custom-thankyou-wrapper">
                                <div class="like-icon">
                                    <img src="Images\like-icon.svg" alt="Like">
                                </div>
                                <h6>Thank you for your time!</h6>
                                <p>We appreciate your feedback.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script type="text/javascript" src="js\javascript.js"></script>

</body>
</html>