<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Source Taxonomy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div id="halachic-index"></div>
</body>
</html>
