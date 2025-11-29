<html>
<head>
<title>Order Result</title>
</head>
<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Order ID: {{ $order_id }}</h2>
<h3>API Response:</h3>
<pre>{{ print_r($api_result, true) }}</pre>
</body>
</html>