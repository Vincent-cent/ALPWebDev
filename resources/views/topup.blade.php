<html>
<head>
<title>Top Up ML</title>
</head>
<body>
<h2>Top Up Mobile Legends</h2>
<form method="POST" action="/order">
@csrf


<label>User ID</label><br>
<input type="text" name="userid"><br><br>


<label>Server ID</label><br>
<input type="text" name="serverid"><br><br>


<label>Pilih Diamond</label><br>
<select name="diamond">
<option value="dm11">11 Diamonds</option>
<option value="dm28">28 Diamonds</option>
<option value="dm59">59 Diamonds</option>
<option value="dm85">85 Diamonds</option>
</select><br><br>


<button type="submit">Top Up</button>
</form>
</body>
</html>