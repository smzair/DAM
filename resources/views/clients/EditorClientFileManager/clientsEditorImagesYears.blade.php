<div class="content custom-dashboard-content">
    <div class="container-fluid">
        <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-transparent card-info mt-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-9">
                                    <h6 class="card-title">All Years</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="year-list">
                            @foreach($all_years as $key=>$object)
                                <div class="col-md-2 year-item">
                                    <div class=" justify-content-between align-content-center">
                                        <div class="text-center">
                                            <a id="folder" ondblclick="navigateToLink('editormonths/{{$object->year}}')">
                                                <img id="folder-image-{{$key}}" src="https://img.icons8.com/color/100/000000/folder-invoices.png" width="50" />
                                            </a>
                                            <!-- Popup container -->
                                            <div id="popup-container-{{ $key }}" class="popup-container">
                                                <ul>
                                                <li><a href="{{route('editorDownloadYearData', ['id' => $object->year])}}">Download</a></li>
                                                </ul>
                                                <ul>
                                                    <li>
                                                        <a href="#" onclick="copyToClipboard('{{route('editorDownloadYearData', ['id' => $object->year])}}' , 'Year'); return false;">
                                                            Copy Link
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="about">
                                                <span>{{ $object->year }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div id="no-results" style="display: none;text-align:center"><h5>No results found</h5></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

{{--script for open popup for folder--}}
<script>
    @foreach($all_years as $key=>$object)
      const folderImage{{ $key }} = document.getElementById('folder-image-{{ $key }}');
      folderImage{{ $key }}.addEventListener('contextmenu', openPopup{{ $key }});
      
      function openPopup{{ $key }}(event) {
        event.preventDefault();
        const x = event.clientX;
        const y = event.clientY;
        const popup = document.getElementById('popup-container-{{ $key }}');
        popup.style.display = 'block';
        popup.style.top = `${y}px`;
        popup.style.left = `${x}px`;
        
        // Close popup when clicked outside
        document.addEventListener('click', closePopupOutside{{ $key }});
      }
      
      function closePopup{{ $key }}() {
        const popup = document.getElementById('popup-container-{{ $key }}');
        popup.style.display = 'none';
      }
      
      function closePopupOutside{{ $key }}(event) {
        const popup = document.getElementById('popup-container-{{ $key }}');
        if (!popup.contains(event.target)) {
          popup.style.display = 'none';
          document.removeEventListener('click', closePopupOutside{{ $key }});
        }
      }
    @endforeach
  </script>