<?php
// Create storage symlink
$target = $_SERVER['DOCUMENT_ROOT'] . '/../storage/app/public';
$link = $_SERVER['DOCUMENT_ROOT'] . '/storage';

if (file_exists($link)) {
    echo "Storage link already exists!";
} else {
    if (symlink($target, $link)) {
        echo "Storage link created successfully!";
    } else {
        echo "Failed to create storage link. Please run: php artisan storage:link";
    }
}
?>
