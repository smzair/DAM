     <div class="modal-header">
        <h5 class="modal-title">
            File Uploaded
        </h5>
        <span class="file-span "> Pending files to uploads : <b>{{$pending}}</b></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="file-uploaded-list">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="uploaded-list-content">
                        <div class="list-content-inner">
                            <span class="file-span file-num">#</span>
                            <span class="file-span file-name"> Received Name</span>
                            <span class="file-span file-count">Uploaded Name</span>
                            <span class="file-span file-count">Uploaded at</span><span class="file-span file-count">Image Count</span>
                        </div>
                    </div>
                </li>
  @foreach($files as $file)
                <li class="list-group-item">
                    <div class="uploaded-list-content " >
                      
                        <div class="list-content-inner">
                            <span class="file-span file-num">{{$sr++}}</span>
                            <span class="file-span file-name">{{$file->recivedFilename}}</span>
                            <span class="file-span file-count">{{$file->sentFilename}}</span>
                            <span class="file-span file-count">{{dateFormat($file->updated_at)}}</span>
                            <span class="file-span file-count">{{$file->imageCount}}</span>

                        </div>
                  
                    </div>
                </li>
                      @endforeach
            </ul>
        </div>
    </div>