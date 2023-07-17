
<script>
	const folderContainer = document.getElementById('folderContainer');
	const folders = Array.from(folderContainer.getElementsByClassName('folder'));
	const selectedFoldersCount = document.getElementById('selectedFoldersCount');
	const popover = document.getElementById('popover');

	let selectedFolders = [];
	let isCtrlPressed = false;

	folderContainer.addEventListener('click', handleFolderSelection);
	document.addEventListener('keydown', handleKeyDown);
	document.addEventListener('keyup', handleKeyUp);

	function handleFolderSelection(event) {
		if (isCtrlPressed) {
			const folder = getClosestFolder(event.target);
			const isSelected = folder.classList.toggle('selected');
			if (isSelected) {
				selectedFolders.push(folder);
			} else {
				selectedFolders11 = selectedFolders.filter((f, index) => {
					console.log(index, ' f :>> ', f);
					console.log('folder :>> ', folder);
				});
				selectedFolders = selectedFolders.filter(f => f !== folder);
			}
			updateSelectedFoldersCount();
			updatePopover();
		}
	}

	function handleKeyDown(event) {
		if (event.key === 'Control' || event.key === 'Meta') {
			isCtrlPressed = true;
		}
	}

	function handleKeyUp(event) {
		if (event.key === 'Control' || event.key === 'Meta') {
			isCtrlPressed = false;
		}
	}

	function updateSelectedFoldersCount() {
		const count = selectedFolders.length;
		if (selectedFolders.length > 0) {
			const selectedFoldersCountText = document.getElementById('selectedFoldersCountText');
			selectedFoldersCountText.textContent = `${count} ${count > 1 ? '' : ''} selected`;
			selectedFoldersCount.style.display = 'block';
		} else {
			selectedFoldersCount.style.display = 'none';
		}

		if(count > 1){
			$("#sidebar_one").addClass('d-none')
			$("#sidebar_multi").removeClass('d-none')	
			$("#multi_view_details").addClass('disable')	
      
		}else{
			$("#multi_view_details").removeClass('disable')	
			$("#sidebar_one").removeClass('d-none')
			$("#sidebar_multi").addClass('d-none')
		}
	}

	function updatePopover() {
		if (selectedFolders.length > 0) {
			const folderNames = selectedFolders.map(folder => folder.textContent).join(', ');
			const downloadLink = createDownloadLink();
			// popover.innerHTML = `${folderNames}<br>${downloadLink}`;
			popoverfolderselect.style.display = 'block';
		} else {
			popoverfolderselect.style.display = 'none';
		}
	}

	function createDownloadLink() {
		const link = document.createElement('a');
		link.textContent = 'Download';
		link.href = '#'; // Replace with the actual download link
		link.addEventListener('click', handleDownloadClick);
		return link.outerHTML;
	}

	function handleDownloadClick(event) {
		// Handle the download action here
		event.preventDefault();
		console.log('Download link clicked');
	}

	function getClosestFolder(element) {
		while (element && !element.classList.contains('folder')) {
			element = element.parentElement;
		}
		return element;
	}

</script>

{{--  Function for adding multipal files to favorites --}}
<script>
		async function add_to_multipal_fav(){
		var selectedFolders = document.querySelectorAll('#folderContainer .selected .myPopover .add_to_favorites_calss');

		let data_obj_array = [];
		selectedFolders.forEach((element) => {
			var data_obj = element.getAttribute('data-data_obj');
			data_obj_array.push(data_obj);
    });

		if(data_obj_array.length > 0){
			await $.ajax({
				url: "{{ url('your-assets-Multipal-Favorites')}}",
				type: "POST",
				dataType: 'json',
				data: {
					data : data_obj_array,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					console.log('res => ', res )
					if(res?.status){
						$('.Multipal-fav-and-notfav-Text').text(res.massage);
						$('.Multipal-fav-div').removeClass('d-none');
						setTimeout(() => {
							$('.Multipal-fav-div').addClass('d-none');
						}, 2000);
					}else{
						$('.error-text').text(res.massage);
						$('.added-notfav-div').removeClass('d-none');
						setTimeout(() => {
							$('.added-notfav-div').addClass('d-none');
							$('.error-text').text('Removed from favourites');
						}, 2000);
					}
				}
			});
		}
	}

</script>



{{--  Download Multipal zIP files --}}
<script>
	function download_mul_zip(){
		const folderNames = selectedFolders.map(async (folder , index) => {
      let selectedfolder_id = folder.classList[0];
      console.log('folder', folder)
      console.log('selectedfolder_id', selectedfolder_id)
			var selectedFolder = document.querySelector('.'+selectedfolder_id);
      console.log('selectedFolder', selectedFolder)
			var popoverFirstChild = selectedFolder.querySelector('.myPopover .Download');

      console.log('popoverFirstChild', popoverFirstChild)
			var hrefValue = popoverFirstChild.getAttribute('href');
			var file_name = popoverFirstChild.getAttribute('data-file_name');
			console.log({selectedfolder_id ,index, file_name, hrefValue});
			if(hrefValue != '' && hrefValue != null){
				hrefValue = hrefValue+"/multipal";
				console.log('hrefValue', hrefValue)
				await $.ajax({
					url: hrefValue,
					type: "GET",
					xhrFields: {
						responseType: 'blob'
					},
					success: function(blob) {
						// Create a temporary URL for the downloaded file
						console.log('blob', blob)
						if(blob?.size > 0){
							var url = URL.createObjectURL(blob);
	
							var link = document.createElement('a');
							link.href = url;
							link.download = file_name + '.zip';
							// Programmatically click the link to trigger the download
							link.click();
							URL.revokeObjectURL(url);
						}
					},
					error: function(xhr, status, error) {
						console.error('Error:', error);
					}
				});

			}
		})
	}
</script>

{{--  Download Multipal Img files --}}
<script>
	function download_mul_img(){
		const folderNames = selectedFolders.map(async (folder , index) => {
      let selectedfolder_id = folder.classList[0];
      console.log('folder', folder)
      console.log('selectedfolder_id', selectedfolder_id)
			var selectedFolder = document.querySelector('.'+selectedfolder_id);
      console.log('selectedFolder', selectedFolder)
			var element = popoverFirstChild = selectedFolder.querySelector('.myPopover .Download');
      console.log('popoverFirstChild', popoverFirstChild)

			if (element) {
				element.click();				
      } else {
        console.log('Element not found.');
			}
		})
	}
</script>

{{-- Multi view details --}}
<script>
	$("#multi_view_details .popover-item-text").on("click", function(){
		const folderNames = selectedFolders.map(async (folder , index) => {
      let selectedfolder_id = folder.classList[0];
      console.log('folder', folder)
      console.log('selectedfolder_id', selectedfolder_id)
			var selectedFolder = document.querySelector('.'+selectedfolder_id);
      console.log('selectedFolder', selectedFolder)
			var element = popoverFirstChild = selectedFolder.querySelector('.myPopover .view_details');
      console.log('popoverFirstChild', popoverFirstChild)

			if (element) {
				element.click();				
      } else {
        console.log('Element not found.');
			}
		})
  	console.log('Working')
	});
</script>