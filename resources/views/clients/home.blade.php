@extends('layouts.client')
@section('title')
Flipkart Panel
@endsection
@section('content')

        <div class="container">
            <div class="row template-row">
                <div class="col-12">
                    <div class="custom-start-wrapper">
                        <h1>Hello!</h1>
                        <h3>Let's Start</h3>
                    </div>
                </div>
            </div>
            <div class="row template-row">
                <div class="col-6">
                    <div class="custom-temp-actions upload-action">
                        <a href="{{route('flipkart.upload')}}" class="actions-link" id="uploadImagesLink">
                            <span class="action-image">
                                <img src="{{asset('dist/img/content-images/upload.png')}}" alt="Upload" class="upload-icon">
                                <span class="circle-anim">
                                    Click To <br>
                                    Upload
                                </span>
                            </span>
                            <span class="action-name">Upload Images Zip</span>
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-temp-actions download-action">
                        <a href="{{route('flipkart.download')}}" class="actions-link" id="downloadImagesLink">
                            <span class="action-image">
                                <img src="{{asset('dist/img/content-images/download.png')}}" alt="Download" class="download-icon">
                                <span class="circle-anim">
                                    Click To <br>
                                    Download
                                </span>
                            </span>
                            <span class="action-name">Download Images</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
