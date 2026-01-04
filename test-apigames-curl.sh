#!/bin/bash

API_URL="https://v1.apigames.id/v2/transaksi"
API_ID="M251129BGUM1758QB"
API_KEY="1ab829e6b779a31bfc7048d60cc20791a4a644a44b79029357dd97a6efc6082e"
ORDER_ID="CURL-TEST123"
SIGNATURE=$(echo -n "${API_ID}${API_KEY}${ORDER_ID}" | md5sum | cut -d' ' -f1)

echo "Sending test request to APIGames..."
echo "URL: $API_URL"
echo "Payload:"
echo "ref_id=$ORDER_ID"
echo "merchant_id=$API_ID"
echo "produk=ML55"
echo "tujuan=95349700"
echo "signature=$SIGNATURE"

curl -X POST "$API_URL" \
  -d "ref_id=$ORDER_ID" \
  -d "merchant_id=$API_ID" \
  -d "produk=ML55" \
  -d "tujuan=95349700" \
  -d "signature=$SIGNATURE" \
  -v
