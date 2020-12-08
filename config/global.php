<?php

$product_image_path = public_path('/uploads/products/');
$brand_image_path = public_path('/uploads/product_brands/');
$vendor_image_path = public_path('/uploads/vendors/');
$qrcode_image_path = public_path('/uploads/machine_qr_codes/');

$api_url = config('app.env') === 'production' ? env('PRODUCTION_API_URL') : env('LOCAL_API_URL');
$api_url_bkash = $api_url . 'bkash/';
$bkash_url = env('BKASH_URL');
$bkash_app_key = env('BKASH_APP_KEY');
$bkash_app_secret = env('BKASH_APP_SECRET');
$bkash_username = env('BKASH_USERNAME');
$bkash_password = env('BKASH_PASSWORD');

return [
    'locker' => 'ML',
    'store' => 'MS',

    'api_url' => $api_url,
    'api_url_bkash' => $api_url_bkash,
    'bkash_url' => $bkash_url,
    'bkash_app_key' => $bkash_app_key,
    'bkash_app_secret' => $bkash_app_secret,
    'bkash_username' => $bkash_username,
    'bkash_password' => $bkash_password,

    'product_image_path' => $product_image_path,
    'product_brand_image_path' => $brand_image_path,
    'vendor_image_path' => $vendor_image_path,
    'qrcode_image_path' => $qrcode_image_path,
];
