<!DOCTYPE html>
<html <?php language_attributes(); ?> class="m-0 p-0">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title><?php wp_title(); ?></title>
    
    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>
    <style>
        html { font-size: 16px }
    </style>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand pr-5" href="#">
                <img src="<?php echo INVMNG_PLUGIN_DIR_URL?>assets/logo.jpg" class="rounded-circle" alt="logo" width="33" height="33">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php 
                    $navTabs = apply_filters( 'invmng_navbar', '', '' );
                    for( $i=0; $i < count( $navTabs ); $i++ ):
                    ?>
                        <li class="nav-item">
                            <a class="nav-link 
                                <?php echo ( $navTabs[$i]['active'] ) ? 
                                ( 'active" aria-current="page"' ) : 
                                ( '"' ); ?>
                                href="<?php echo site_url( $navTabs[$i]['id'] )?>">
                                <?php echo $navTabs[$i]['name']?>
                            </a> 
                        </li>
                    <?php endfor; ?>
                </ul>

                <span class="navbar-text">
                    Wallace Huo
                </span>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="col-12">