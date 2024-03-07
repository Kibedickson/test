<?php
require 'vendor/autoload.php';
require 'RedisClient.php';
require 'SendEmailJob.php';

$redis = new RedisClient();
Resque::setBackend($redis->getClient());

$jsonFileContent = file_get_contents('order.json');
$orderData = json_decode($jsonFileContent, true);

function calculateTotal(array $orderData): int
{
    return array_reduce($orderData['order_items'], fn($total, $item) => $total + ($item['unit_price'] * $item['quantity']),0);
}

$total = calculateTotal($orderData);
$orderData['total'] = $total;

Resque::enqueue('default', 'SendEmailJob', $orderData);

echo 'Customer Name: ' . $orderData['customer']['name'] . PHP_EOL;
echo 'Total: ' . $orderData['total'] . ' ' . $orderData['currency'] . PHP_EOL;

echo 'Order Items:' . PHP_EOL;
foreach ($orderData['order_items'] as $item) {
    echo '- Product: ' . $item['product_name'] . ', Quantity: ' . $item['quantity'] . PHP_EOL;
}



