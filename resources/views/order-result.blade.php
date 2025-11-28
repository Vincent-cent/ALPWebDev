<html>
<head>
<title>Order Result</title>
</head>
<body>
<h2>Order ID: {{ $order_id }}</h2>
<h3>API Response:</h3>
<pre>{{ print_r($api_result, true) }}</pre>
</body>
</html>