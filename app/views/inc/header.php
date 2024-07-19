<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/customer_style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT; ?>/css/datatables.min.css"/>
    <script src="<?php echo URLROOT; ?>/js/jquery_1.9.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/font-awesome.min.css">
    <script type="text/javascript" src="<?php echo URLROOT; ?>/js/datatables.min.js" defer></script>
    <title><?php echo SITENAME; ?></title>
</head>

<body>
    <?php 
    header('Content-Type: text/html; charset=UTF-8');
    require APPROOT . "/views/inc/navbar.php" ?>
    <div class="container">

<script>
    $( "#clearBuyHistory" ).click(function(e) {
        var result = window.confirm('အဝယ်ဘောင်ချာတွေဖျက်ပစ်ပါမယ်....');
        if (result == false) {
            e.preventDefault();
        };
    });
    $( "#clearSellHistory" ).click(function(e) {
        var result = window.confirm('အရောင်းဘောင်ချာတွေဖျက်ပစ်ပါမယ်....');
        if (result == false) {
            e.preventDefault();
        };
    });
</script>