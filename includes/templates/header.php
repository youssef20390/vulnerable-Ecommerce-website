<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php getTitle();  ?></title>
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
        <?php if(!isset($NonewCss)){echo '<link rel="stylesheet" href="' . $css . 'newCss.css?v=' . time().'">';} ?>
        <link rel="stylesheet" href="<?php echo $css; ?>front.css?v=<?php echo time();?>">
    </head>
    <body>
    
    
