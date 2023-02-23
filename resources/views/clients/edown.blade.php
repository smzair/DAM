    <ul>@foreach($all as $file)
                <li>
                    <div class="uploaded-list-content">
                        <div class="list-content-inner">
                            @if($file['filename'] == Null)
                            
                            <span class="file-span file-name">Edited File Pending</span>
                            <span class="file-span file-action">
                                <a href="#" class="btn file-action-btn deactive-btn" id="file1DownloadBTN">
                                    Download
                                </a>
                            </span>
                            @else
                             <span class="file-span file-name">{{$file['filename']}}</span>
                            <span class="file-span file-name">{{dateFormat($file['updated_at'])}}</span>
                            <span class="file-span file-action">
                                <a href="{{$file['filepath']}}" class="btn file-action-btn" id="file1DownloadBTN">
                                    Download
                                </a>
                            </span>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>