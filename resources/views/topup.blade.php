<!DOCTYPE html>
<html>
<head>
    <title>Top Up Game</title>
</head>
<body>

<h2>Top Up Game (Impedia)</h2>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if (session('result'))
    <pre>{{ json_encode(session('result'), JSON_PRETTY_PRINT) }}</pre>
@endif

<form method="POST" action="/order">
@csrf

<label>User ID</label><br>
<input type="text" name="userid" required><br><br>

<label>Server ID (opsional)</label><br>
<input type="text" name="serverid"><br><br>

<label>Pilih Produk</label><br>
<select name="product_id" required>
    <option value="">-- Pilih --</option>
    <option value="STEAM12-S55">Steam Wallet 12</option>
</select><br><br>

<button type="submit">Top Up</button>

</form>

</body>
</html>
