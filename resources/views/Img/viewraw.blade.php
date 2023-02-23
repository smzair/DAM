@extends('layouts.admin')

@section('title')
Upload Raw Images
@endsection
@section('content')

<head>
    <title>View Upload Image Gallery</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- <link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css"> -->
</head>

<style>

.more-link {
    position: relative;
    border: none;
    box-shadow: none;
    width: 130px;
    height: 40px;
    line-height: 42px;
    display: inline-block;
    color: #000 !important;
}
.more-link span {
  background: rgb(0,172,238);
  background: linear-gradient(0deg,#fbf702 0%, #fbf702 100%);
  display: block;
  position: absolute;
  width: 130px;
  height: 40px;
  box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
   7px 7px 20px 0px rgba(0,0,0,.1),
   4px 4px 5px 0px rgba(0,0,0,.1);
  border-radius: 5px;
  margin:0;
  text-align: center;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all .3s;
  transition: all .3s;
  color: inherit !important;
}
.more-link span:nth-child(1) {
  box-shadow:
   -7px -7px 20px 0px #fff9,
   -4px -4px 5px 0px #fff9,
   7px 7px 20px 0px #0002,
   4px 4px 5px 0px #0001;
  -webkit-transform: rotateX(90deg);
  -moz-transform: rotateX(90deg);
  transform: rotateX(90deg);
  -webkit-transform-origin: 50% 50% -20px;
  -moz-transform-origin: 50% 50% -20px;
  transform-origin: 50% 50% -20px;
}
.more-link span:nth-child(2) {
  -webkit-transform: rotateX(0deg);
  -moz-transform: rotateX(0deg);
  transform: rotateX(0deg);
  -webkit-transform-origin: 50% 50% -20px;
  -moz-transform-origin: 50% 50% -20px;
  transform-origin: 50% 50% -20px;
}
.more-link:hover span:nth-child(1) {
  box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
   7px 7px 20px 0px rgba(0,0,0,.1),
   4px 4px 5px 0px rgba(0,0,0,.1);
  -webkit-transform: rotateX(0deg);
  -moz-transform: rotateX(0deg);
  transform: rotateX(0deg);
}
.more-link:hover span:nth-child(2) {
  box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
   7px 7px 20px 0px rgba(0,0,0,.1),
   4px 4px 5px 0px rgba(0,0,0,.1);
 color: transparent;
  -webkit-transform: rotateX(-90deg);
  -moz-transform: rotateX(-90deg);
  transform: rotateX(-90deg);
}

.view-all-list ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.view-all-list > ul {
    display: block;
}

.view-all-list ul li {
    position: relative;
}

.view-all-list > ul li {
    font-size: 16px;
    line-height: 1.4;
}

.view-all-list ul.submenu-wrapper ul {
    padding-left: 20px;
}

.view-all-list > ul li > a {
    display: inline-block;
    position: relative;
    color: #000;
    padding: 10px 0;
    font-weight: 500;
}

.view-all-list ul li a {
    text-decoration: none !important;
}

.view-all-list > ul li.lot-no-list > a:after, 
.view-all-list > ul li.wrc-no-list > a:after, 
.view-all-list > ul li.adaptations-list > a:after {
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    line-height: 1;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    margin-left: 5px;
    vertical-align: middle;
    font-size: 1.2rem;
    content: "\f0d7";
    color: rgba(0,0,0,0.7);
    position: relative;
    top: -2px;
}

.view-all-list > ul li.lot-no-list.menu-open > a:after,
.view-all-list > ul li.wrc-no-list.menu-open > a:after,
.view-all-list > ul li.adaptations-list.menu-open > a:after {
    content: "\f0d8";
}

.view-all-list > ul li > span.sol-details {
    padding-top: 10px;
    padding-bottom: 10px;
}

.view-all-list ul ul.submenu {
    display: none;
}

.sku-no-list > a {
    font-size: 14px;
}

#image-gallery .modal-footer{
  display: block;
}

.sol-details > a.thumbnail img.img-thumbnail {
    height: 40px;
    object-fit: cover;
}

.image-thumb-list {
    white-space: nowrap;
    overflow-x: auto;
    vertical-align: middle;
}

.image-thumb-list::-webkit-scrollbar {
    border: 0;
    height: 6px;
}

.image-thumb-list::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background: #d5d5d5;
}

.image-thumb-list::-webkit-scrollbar-track {
    border-radius: 0;
    background: #eeeeee;
}

@media (max-width: 991px) and (min-width: 576px) {
    #modal-vw-lg .modal-lg,
    #image-gallery .modal-lg {
        max-width: 90%;
    }
}

@media (max-width: 767px) {
    .view-all-list > ul li {
        font-size: 13px;
    }

    .sku-no-list > a {
        font-size: 12px;
    }
}

</style>

<body>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Details of uploaded images</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table text-nowrap">
                            <thead>
                              <tr>
                                  <th class="align-middle" width="10px">Id</th>
                                  <th class="align-middle">Date of plan</th>
                                  <th class="align-middle">Lot Count</th>
                                  <th class="align-middle">Image Count</th>
                                  <th class="align-middle">Studio</th>
                                  <th class="align-middle">Shoot Type</th>
                                  <th class="align-middle">Clothing</th>
                                  <th class="align-middle">Photographer</th>
                                  <th class="align-middle">Stylist</th>
                                  <th class="align-middle">Makeup Artist</th>
                                  <th class="align-middle">Raw QC</th>
                                  <th class="align-middle">Models</th>
                                  <th class="align-middle">Agency</th>
                                  <th class="align-middle">Assistants</th>
                                  <th class="align-middle">View More Details</th>
                              </tr>
                            </thead>
                            <tbody id="#accordion1">
                              @foreach($shoot as $index => $shot)
                              <tr>
                                  <td class="align-middle" width="10px">{{$index}}</td>  
                                  <td class="align-middle">{{$shot->date}}</td>
                                  <td class="align-middle">90</td>
                                  <td class="align-middle">30</td>
                                  <td class="align-middle">{{$shot->studio}}</td>
                                  <td class="align-middle">{{$shot->type_of_shoot}}</td>
                                  <td class="align-middle">{{$shot->type_of_clothing}}</td>
                                  <td class="align-middle">{{$shot->photographer}}</td>
                                  <td class="align-middle">{{$shot->stylist}}</td>
                                  <td class="align-middle">{{$shot->makeupartist}}</td>
                                  <td class="align-middle">{{$shot->rawqc}}</td>
                                  <td class="align-middle">{{$shot->model}}</td>
                                  <td class="align-middle">{{$shot->agency}}</td>
                                  <td class="align-middle">{{$shot->assistant}}</td>
                                  <td class="align-middle">
                                    <a href="javascript:;" class="more-link"><span>Click!</span><span>Read More</span></a>
                                  </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-vw-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Upload Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="view-all-list">
                            <ul class="submenu-wrapper m-0 p-0 list-unstyled">
                                <h4 class="text-info mb-3">Lot Numbers</h4>
                                <li class="has-submenu lot-no-list row m-0 mb-2">
                                    <a href="javascript:;" class="submenu-link col-sm-4 col-12">ODN-786723456</a>
                                    <span class="col-sm-4 col-12 d-inline-block sol-details">Company Name: <strong>Myntra</strong></span>
                                    <span class="col-sm-4 col-12 d-inline-block sol-details">Brand: <strong>Cloth</strong></span>
                                    <ul class="submenu col-12">
                                        <h5 class="mt-2 text-primary">WRC Numbers</h5>
                                        <li class="has-submenu wrc-no-list row m-0 mb-2">
                                            <a href="javascript:;" class="submenu-link col-sm-4 col-12">WRC-345</a>
                                            <span class="col-sm-4 col-12 d-inline-block sol-details">Type of shoot: <strong>Custom</strong></span>
                                            <span class="col-sm-4 col-12 d-inline-block sol-details">Type of clothing: <strong>Casual</strong></span>
                                            <ul class="submenu col-12">
                                                <h6 class="mt-2 text-danger">SKU Numbers</h6>
                                                <li class="has-submenu sku-no-list" id="sku-img-list">
                                                    <a href="javascript:;" class="submenu-link">SKU-346</a>
                                                    <span class="d-inline-block sol-details image-thumb-list">
                                                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="SKU-1" data-image="images/skimage1.jpeg" data-target="#image-gallery">
                                                            <img class="img-thumbnail rounded-circle" src="images/skimage1.jpeg" alt="Another alt text" width="40px">
                                                        </a>
                                                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="SKU-2" data-image="images/skimage2.jpeg" data-target="#image-gallery">
                                                            <img class="img-thumbnail rounded-circle" src="images/skimage2.jpeg" alt="Another alt text" width="40px">
                                                        </a>
                                                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="SKU-3" data-image="images/skimage3.jpeg" data-target="#image-gallery">
                                                            <img class="img-thumbnail rounded-circle" src="images/skimage3.jpeg" alt="Another alt text" width="40px">
                                                        </a>
                                                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="SKU-4" data-image="images/skimage4.jpeg" data-target="#image-gallery">
                                                            <img class="img-thumbnail rounded-circle" src="images/skimage4.jpeg" alt="Another alt text" width="40px">
                                                        </a>
                                                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="SKU-5" data-image="images/skimage5.jpeg" data-target="#image-gallery">
                                                            <img class="img-thumbnail rounded-circle" src="images/skimage5.jpeg" alt="Another alt text" width="40px">
                                                        </a>
                                                    </span>
                                                </li>
                                               
                                            </ul>
                                        </li>
                                       
                                    </ul>
                                </li>
                               
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="image-gallery-title"></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="fix-infor-wrapper">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
      <i class="fas fa-info ic-infor"></i>
      <i class="fas fa-times cl-infor"></i>
    </a>
    <div class="infor-content">
      <p>Check Your Data Form Dashboard</p>
    </div>
  </div>

    <script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
    <script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="application/javascript" src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="application/javascript" src="dist/js/adminlte.js"></script>
    <script type="application/javascript" src="dist/js/adminlte.min.js"></script>

    <!-- <script type="application/javascript" src="plugins/ekko-lightbox/ekko-lightbox.min.js"></script> -->

    <script>
        

        $('.more-link').click(function(){
            $('#modal-vw-lg').modal('show');
        });

        $('.view-img-slider').click(function(){
            $('#modal-image-xl').modal('show');
        });

        $(".submenu-link").click(function () {
            $(this).parent().siblings(".has-submenu").find(".submenu").slideUp(250);
            $(this).parent().children('.submenu').slideToggle(250);
            $(this).toggleClass("child-open");
            $(this).parent("li.has-submenu").toggleClass("menu-open");
            $(this).parent("li.has-submenu").siblings("li.has-submenu").removeClass("menu-open");
            $(this).parent("li.has-submenu").children(".submenu").find("li.has-submenu").removeClass("menu-open");
        });

        // $(document).on('click', '#sku-img-list [data-toggle="lightbox"]', function (event) {
        //     event.preventDefault();
        //     $(this).ekkoLightbox();
        // });

    let modalId = $('#image-gallery');

        $(document)
            .ready(function () {

                loadGallery(true, 'a.thumbnail');

                //This function disables buttons when needed
                function disableButtons(counter_max, counter_current) {
                    $('#show-previous-image, #show-next-image')
                        .show();
                    if (counter_max === counter_current) {
                        $('#show-next-image')
                            .hide();
                    } else if (counter_current === 1) {
                        $('#show-previous-image')
                            .hide();
                    }
                }

                /**
                 *
                 * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
                 * @param setClickAttr  Sets the attribute for the click handler.
                 */

                function loadGallery(setIDs, setClickAttr) {
                    let current_image,
                        selector,
                        counter = 0;

                    $('#show-next-image, #show-previous-image')
                        .click(function () {
                            if ($(this)
                                .attr('id') === 'show-previous-image') {
                                current_image--;
                            } else {
                                current_image++;
                            }

                            selector = $('#sku-img-list [data-image-id="' + current_image + '"]');
                            updateGallery(selector);
                        });

                    function updateGallery(selector) {
                        let $sel = selector;
                        current_image = $sel.data('image-id');
                        $('#image-gallery-title')
                            .text($sel.data('title'));
                        $('#image-gallery-image')
                            .attr('src', $sel.data('image'));
                        disableButtons(counter, $sel.data('image-id'));
                    }

                    if (setIDs == true) {
                        $('#sku-img-list [data-image-id]')
                            .each(function () {
                                counter++;
                                $(this)
                                    .attr('data-image-id', counter);
                            });
                    }
                    $(setClickAttr)
                        .on('click', function () {
                            updateGallery($(this));
                        });
                }
            });

        // build key actions
        $(document)
            .keydown(function (e) {
                switch (e.which) {
                    case 37: // left
                        if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
                            $('#show-previous-image')
                                .click();
                        }
                        break;

                    case 39: // right
                        if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
                            $('#show-next-image')
                                .click();
                        }
                        break;

                    default:
                        return; // exit this handler for other keys
                }
                e.preventDefault(); // prevent the default action (scroll / move caret)
            });

        

    </script>

</body>
@endsection
