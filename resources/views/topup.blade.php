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
<option value="UPMBL5">5 Diamonds</option>
<option value="UPMBL12">12 Diamonds</option>
<option value="UPMBL19">19 Diamonds</option>
<option value="UPMBL18">28 Diamonds</option>
</select><br><br>


<button type="submit">Top Up</button>
</form>
</body>
</html>