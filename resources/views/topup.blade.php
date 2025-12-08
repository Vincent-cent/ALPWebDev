<html>
<head>
<title>Top Up ML</title>
</head>
<body>
<h2>Top Up Mobile Legends</h2>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/order">
@csrf

<label>User ID</label><br>
<input type="text" name="userid"><br><br>

<label>Server ID</label><br>
<input type="text" name="serverid"><br><br>

<label>Pilih Diamond</label><br>
<select name="diamond">
<option value="DGHMBL5">5 Diamonds</option>
<option value="DGHMBL12">12 Diamonds</option>
<option value="KCIDMBL10">10 Diamond Kachishop</option>
<option value="DGRMBL3">3 Diamond Mobile Legend DGR</option>
<option value="ML55">Diamond×50+5 SmileOne</option>
</select><br><br>

<button type="submit">Top Up</button>
</form>
</body>
</html>