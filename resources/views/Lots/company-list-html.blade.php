
<div class="form-group">
	<label class="control-label required">Company Name</label>
	<select class="form-control com select2"  id="user_id"  name="user_id" required data-placeholder="Select Company" onchange="getServiceList(this)">
		<option value = "">Select Company</option>
		@foreach($users as $user)
		<option  <?php echo ($selectedUserId == $user->id) ? 'selected' : ''; ?> value = "{{$user->id}}" data-c_short = "{{$user->c_short}}">{{$user->client_id}}  |  {{$user->Company}}</option>
		@endforeach
	</select>
</div>