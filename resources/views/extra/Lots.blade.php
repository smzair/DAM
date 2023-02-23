<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>New Lots</h2>

<table>
  <tr>
    <th>Lot Number</th>
      <th>location</th>
       <th>verticleType</th>
    <th>Genrated On</th>
  </tr>
  @foreach($newLots as $lot)
  <tr>
    <td>{{$lot->lot_id}}</td>
     <td>{{$lot->location}}</td>
      <td>{{$lot->verticleType}}</td>
    <td>{{dateFormat($lot->created_at)}}</td>
  </tr>
 @endforeach
</table>

</body>
</html>

