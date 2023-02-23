<div class="form-group">
	<label class="control-label required">Type Of Service</label>
	<select class="form-control wrcid" id="wrcid"  id="s_type"  name="s_type" required data-placeholder="Select Service">
		<option value = "">Select Service</option>
		@foreach($serviceList as $sKey => $service)
		<option  <?php echo ($selectedService === $sKey) ? 'selected' : ''; ?> value = "{{$sKey}}">{{$service}}</option>
		@endforeach
		<option value="GO" >GO Live</option>
	</select>

	
</div>

