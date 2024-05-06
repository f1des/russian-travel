<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Page\Asset;

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?$APPLICATION->ShowTitle();?>Burger</title>
    <!-- <meta name="description" content=""> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_TEMPLATE_PATH ?>/assets/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->

	<?php
      Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/bootstrap.min.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/owl.carousel.min.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/magnific-popup.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/font-awesome.min.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/themify-icons.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/nice-select.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/flaticon.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/animate.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/slicknav.css');
	  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/style.css');

	  // JS here

	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/vendor/modernizr-3.5.0.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/vendor/jquery-1.12.4.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/popper.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/bootstrap.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/owl.carousel.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/isotope.pkgd.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/ajax-form.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/waypoints.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.counterup.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/imagesloaded.pkgd.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/scrollIt.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.scrollUp.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/wow.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/nice-select.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.slicknav.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.magnific-popup.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/plugins.js');

	  // contact js
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/contact.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.ajaxchimp.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.form.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.validate.min.js');
	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/mail-script.js');

	  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/main.js');
	?>

	<?$APPLICATION->ShowHead();?>
</head>

<body>
	<div id="panel">
		<?$APPLICATION->ShowPanel();?>
	</div>	

    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid p-0">
                    <div class="row align-items-center no-gutters">
                        <div class="col-xl-5 col-lg-5">
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "top_menu", 
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "COMPOSITE_FRAME_MODE" => "A",
                                "COMPOSITE_FRAME_TYPE" => "AUTO",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "left",
                                "USE_EXT" => "N",
                                "COMPONENT_TEMPLATE" => "top_menu"
                            ), false);
                        ?>
                            <!-- <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a class="active" href="/">home</a></li>
                                        <li><a href="/menu">Menu</a></li>
                                        <li><a href="/about">About</a></li>
                                        <li><a href="#">blog <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="/blog">blog</a></li>
                                                <li><a href="/single-blog">single-blog</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Pages <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="/elements">elements</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="/contact">Contact</a></li>
                                    </ul>
                                </nav>
                            </div> -->

                        </div>
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo-img">
                                <a href="/">
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 d-none d-lg-block">
                            <div class="book_room">
                                <div class="socail_links">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-google-plus"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="book_btn d-none d-xl-block">
                                    <a class="#" href="#">+10 367 453 7382</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->
	
						