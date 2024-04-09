<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet"  href="css/style.css">
    <script src="JS/script.js"></script>
</head>
<?php include 'includes/navbar.php'; ?>
<body>
<div class="container">
    <div class="category boxed" onclick="fetchCategoryData('Feelings')">Ik voel</div>
    <div class="category boxed" onclick="fetchCategoryData('Needs')">Ik wil</div>
    <div class="category boxed" onclick="fetchCategoryData('Belongings')">Ik heb</div>
    <div class="category boxed" onclick="fetchCategoryData('IdentityStatements')">Ik ben</div>
</div>
<div class="container items-slider" id="items">

</div>
<div id="sentence" class="sentence">
    <span id="speakIcon" style="float: right; cursor: pointer;">🔊</span>
</div>



</body>
</html>

