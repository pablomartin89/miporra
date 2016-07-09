<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="SemiColonWeb" />

        <!-- Stylesheets
        ============================================= -->
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?= $front_media_folder ?>css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="<?= $front_media_folder ?>style.css" type="text/css" />
        <link rel="stylesheet" href="<?= $front_media_folder ?>css/dark.css" type="text/css" />
        <link rel="stylesheet" href="<?= $front_media_folder ?>css/font-icons.css" type="text/css" />
        <link rel="stylesheet" href="<?= $front_media_folder ?>css/animate.css" type="text/css" />
        <link rel="stylesheet" href="<?= $front_media_folder ?>css/magnific-popup.css" type="text/css" />
        <?php
        if (isset($css)) {
            foreach ($css as $css_file) {
                ?>
                <link rel="stylesheet" href="<?= $front_media_folder ?><?= $css_file ?>" type="text/css" />
                <?php
            }
        }
        ?>
        <link rel="stylesheet" href="<?= $front_media_folder ?>css/responsive.css" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->

        <!-- External JavaScripts
        ============================================= -->
        <script type="text/javascript" src="<?= $front_media_folder ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?= $front_media_folder ?>js/plugins.js"></script>
        <?php
        if (isset($js)) {
            foreach ($js as $js_file) {
                ?>
                <script type="text/javascript" src="<?= $front_media_folder ?><?= $js_file ?>"></script>
                <?php
            }
        }
        ?>

        <!-- Document Title
        ============================================= -->
        <title>Canvas | The Multi-Purpose HTML5 Template</title>

    </head>

    <body class="stretched">

        <!-- Document Wrapper
        ============================================= -->
        <div id="wrapper" class="clearfix">

            <!-- Header
            ============================================= -->
            <header id="header" class="full-header dark">

                <div id="header-wrap">

                    <div class="container clearfix">

                        <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                        <!-- Logo
                        ============================================= -->
                        <div id="logo">
                            <a href="<?=  base_url()?>" class="standard-logo" data-dark-logo="<?= $front_media_folder ?>images/logo-dark.png"><img src="<?= $front_media_folder ?>images/logo-dark.png" alt="Canvas Logo"></a>
                            <a href="<?=  base_url()?>" class="retina-logo" data-dark-logo="<?= $front_media_folder ?>images/logo-dark@2x.png"><img src="<?= $front_media_folder ?>images/logo-dark@2x.png" alt="Canvas Logo"></a>
                        </div><!-- #logo end -->


                        <?php if (isset($menu)) echo $menu ?>

                    </div>

                </div>

            </header><!-- #header end -->

            <?php if (isset($pageTitle)) echo $pageTitle ?>

            <?php if (isset($slider)) echo $slider ?>

            <!-- Content
            ============================================= -->
            <section id="content">
                <div class="content-wrap">
                    <?php if (isset($pageContent)) echo $pageContent ?>
                </div>
            </section><!-- #content end -->

            <!-- Footer
            ============================================= -->
            <footer id="footer" class="dark">

                <!-- Copyrights
                ============================================= -->
                <div id="copyrights">

                    <div class="container clearfix">

                        <div class="col_half">
                            Copyrights &copy; 2014 All Rights Reserved by Canvas Inc.<br>
                            <div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
                        </div>

                        <div class="col_half col_last tright">
                            <div class="fright clearfix">
                                <a href="#" class="social-icon si-small si-borderless si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>

                                <a href="#" class="social-icon si-small si-borderless si-twitter">
                                    <i class="icon-twitter"></i>
                                    <i class="icon-twitter"></i>
                                </a>

                                <a href="#" class="social-icon si-small si-borderless si-gplus">
                                    <i class="icon-gplus"></i>
                                    <i class="icon-gplus"></i>
                                </a>

                                <a href="#" class="social-icon si-small si-borderless si-pinterest">
                                    <i class="icon-pinterest"></i>
                                    <i class="icon-pinterest"></i>
                                </a>

                                <a href="#" class="social-icon si-small si-borderless si-vimeo">
                                    <i class="icon-vimeo"></i>
                                    <i class="icon-vimeo"></i>
                                </a>

                                <a href="#" class="social-icon si-small si-borderless si-github">
                                    <i class="icon-github"></i>
                                    <i class="icon-github"></i>
                                </a>

                                <a href="#" class="social-icon si-small si-borderless si-yahoo">
                                    <i class="icon-yahoo"></i>
                                    <i class="icon-yahoo"></i>
                                </a>

                                <a href="#" class="social-icon si-small si-borderless si-linkedin">
                                    <i class="icon-linkedin"></i>
                                    <i class="icon-linkedin"></i>
                                </a>
                            </div>

                            <div class="clear"></div>

                            <i class="icon-envelope2"></i> info@canvas.com <span class="middot">&middot;</span> <i class="icon-headphones"></i> +91-11-6541-6369 <span class="middot">&middot;</span> <i class="icon-skype2"></i> CanvasOnSkype
                        </div>

                    </div>

                </div><!-- #copyrights end -->

            </footer><!-- #footer end -->

        </div><!-- #wrapper end -->

        <!-- Go To Top
        ============================================= -->
        <div id="gotoTop" class="icon-angle-up"></div>

        <!-- Footer Scripts
        ============================================= -->
        <script type="text/javascript" src="<?= $front_media_folder ?>js/functions.js"></script>

    </body>
</html>