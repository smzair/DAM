<html>
<table>
	<thead>
<th>Company</th>
<th>Brand</th>
<th>Client Name</th>
<th>Client Mail</th>
<th>Am Name</th>
<th>Your recent overall experience with us?</th>
<th>Speed of response from ODN?</th>
<th>Transparency and clarity of information?</th>
<th>Speed of delivery?</th>
<th>Models suitable for the brand/product line?</th>
<th>Models look and feel?</th>
<th>Models posing?</th>
<th>Pairing?</th>
<th>Understanding of product usages</th>
<th>Lighting of the shoot</th>
<th>Would you recommend us to your friends?</th>
<th>Any suggestions for us?</th>
<th>Request Raised On</th>
	<th>Feedback Filled On</th>
</thead>
@foreach($feedback as $data)
<tbody>
<tr>
<td>{{$data['Company']}}</td>
<td>{{$data['name']}}</td>
<td>{{$data['Cemail']}}</td>
<td>{{$data['C_name']}}</td>
<td>{{$data['am_name']}}</td>
<td>{{$data['q1']}}</td>
<td>{{$data['q2']}}</td>
<td>{{$data['q3']}}</td>
<td>{{$data['q4']}}</td>
<td>{{$data['q5_1']}}</td>
<td>{{$data['q5_2']}}</td>
<td>{{$data['q5_3']}}</td>
<td>{{$data['q6_1']}}</td>
<td>{{$data['q6_2']}}</td>
<td>{{$data['q6_3']}}</td>
<td>{{$data['q7']}}</td>
<td>{{$data['q8']}}</td>
<td>{{dateFormat($data['Request_raised'])}}</td>
<td>{{dateFormat($data['filled'])}}</td>
</tr>
@endforeach
</tbody>
</table>
</html>