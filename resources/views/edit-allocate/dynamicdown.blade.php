@foreach($all as $alls)
<li class="list-group-item">
    <div class="uploaded-list-content">
        <div class="list-content-inner">
            <span class="file-span file-num">{{$sr++}}</span>
            <span class="file-span file-name">{{$alls['filename']}}</span>
            <span class="file-span file-count">Image Count : <b>{{$alls['count']}}</b></span>
            <span class="file-span file-count">{{dateFormat($alls['created_at'])}}</b></span>
            <span class="file-span file-action">
                <a href="{{$alls['filepath']}}" data-flipId="{{$alls['fileId']}}" onclick="Editingstart(this)" target="_self" class="btn btn-warning btn-xs file-action-btn" id="file1DownloadBTN">
                    Download thread
                </a>
            </span>
        </div>
    </div>
</li>
@endforeach