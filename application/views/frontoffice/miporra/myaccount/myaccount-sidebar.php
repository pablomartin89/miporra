<!-- Sidebar
        ============================================= -->
<div class="sidebar nobottommargin clearfix">
    <div class="sidebar-widgets-wrap">

        <div class="widget widget_links clearfix">

            <h4>Mi Cuenta</h4>
            <ul>
                <li><a href="<?=base_url('myaccount')?>"><div>Mi Perfil</div></a></li>
                <li><a href="<?= base_url('myaccount/groups')?>"><div>Mis grupos</div></a></li>
                <li><a href="#"><div>Notificaciones</div></a></li>
                <li><a href="<?= base_url('myaccount/calendar') ?>"><div>Calendario</div></a></li>
                <li><a href="<?= base_url('myaccount/logout') ?>"><div>Logout</div></a></li>
            </ul>

        </div>

        <div class="widget widget_links clearfix">


            <h4>Mis resultados</h4>

            <ul>
                <?php
                if (isset($user_competitions)) {
                    foreach ($user_competitions as $group_competition) { ?>

                        <li><a href="#"><div><?=$group_competition[0]->group_name?></div></a>
                            <ul>
                                 <?php foreach ($group_competition as $competition) { ?>
                                <li><a href="<?=base_url('myaccount/results/'.$competition->group_url).'/'.$competition->competition_url.'/'.$competition->season_number?>"><div><?=$competition->competition_name?> - <?=$competition->season_number?></div></a></li>
                                <?php } ?>
                            </ul>
                            <?php }  ?>
                    </li>
                    <?php }
                ?>


                <li><a href="#"><div>Crear Grupo</div></a> </li>
            </ul>

        </div>

        <div class="widget clearfix">

            <h4>Recent Posts</h4>
            <div id="post-list-footer">

                <div class="spost clearfix">
                    <div class="entry-image">
                        <a href="#" class="nobg"><img src="images/magazine/small/1.jpg" alt=""></a>
                    </div>
                    <div class="entry-c">
                        <div class="entry-title">
                            <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
                        </div>
                        <ul class="entry-meta">
                            <li>10th July 2014</li>
                        </ul>
                    </div>
                </div>

                <div class="spost clearfix">
                    <div class="entry-image">
                        <a href="#" class="nobg"><img src="images/magazine/small/2.jpg" alt=""></a>
                    </div>
                    <div class="entry-c">
                        <div class="entry-title">
                            <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
                        </div>
                        <ul class="entry-meta">
                            <li>10th July 2014</li>
                        </ul>
                    </div>
                </div>

                <div class="spost clearfix">
                    <div class="entry-image">
                        <a href="#" class="nobg"><img src="images/magazine/small/3.jpg" alt=""></a>
                    </div>
                    <div class="entry-c">
                        <div class="entry-title">
                            <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
                        </div>
                        <ul class="entry-meta">
                            <li>10th July 2014</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

        <div class="widget clearfix">

            <h4>Connect with Us</h4>
            <a href="#" class="social-icon si-colored si-small si-facebook" data-toggle="tooltip" data-placement="top" title="Facebook">
                <i class="icon-facebook"></i>
                <i class="icon-facebook"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-delicious" data-toggle="tooltip" data-placement="top" title="Delicious">
                <i class="icon-delicious"></i>
                <i class="icon-delicious"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-android" data-toggle="tooltip" data-placement="top" title="Android">
                <i class="icon-android"></i>
                <i class="icon-android"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-gplus" data-toggle="tooltip" data-placement="top" title="Google Plus">
                <i class="icon-gplus"></i>
                <i class="icon-gplus"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-stumbleupon" data-toggle="tooltip" data-placement="top" title="Stumbleupon">
                <i class="icon-stumbleupon"></i>
                <i class="icon-stumbleupon"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-foursquare" data-toggle="tooltip" data-placement="top" title="Foursquare">
                <i class="icon-foursquare"></i>
                <i class="icon-foursquare"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-forrst" data-toggle="tooltip" data-placement="top" title="Forrst">
                <i class="icon-forrst"></i>
                <i class="icon-forrst"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-digg" data-toggle="tooltip" data-placement="top" title="Digg">
                <i class="icon-digg"></i>
                <i class="icon-digg"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-spotify" data-toggle="tooltip" data-placement="top" title="Spotify">
                <i class="icon-spotify"></i>
                <i class="icon-spotify"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-reddit" data-toggle="tooltip" data-placement="top" title="Reddit">
                <i class="icon-reddit"></i>
                <i class="icon-reddit"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-blogger" data-toggle="tooltip" data-placement="top" title="Blogger">
                <i class="icon-blogger"></i>
                <i class="icon-blogger"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-dribbble" data-toggle="tooltip" data-placement="top" title="Dribbble">
                <i class="icon-dribbble"></i>
                <i class="icon-dribbble"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-flickr" data-toggle="tooltip" data-placement="top" title="Flickr">
                <i class="icon-flickr"></i>
                <i class="icon-flickr"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-linkedin" data-toggle="tooltip" data-placement="top" title="Linked In">
                <i class="icon-linkedin"></i>
                <i class="icon-linkedin"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-rss" data-toggle="tooltip" data-placement="top" title="RSS">
                <i class="icon-rss"></i>
                <i class="icon-rss"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-skype" data-toggle="tooltip" data-placement="top" title="Skype">
                <i class="icon-skype"></i>
                <i class="icon-skype"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-twitter" data-toggle="tooltip" data-placement="top" title="Twitter">
                <i class="icon-twitter"></i>
                <i class="icon-twitter"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-youtube" data-toggle="tooltip" data-placement="top" title="Youtube">
                <i class="icon-youtube"></i>
                <i class="icon-youtube"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-vimeo" data-toggle="tooltip" data-placement="top" title="Vimeo">
                <i class="icon-vimeo"></i>
                <i class="icon-vimeo"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-yahoo" data-toggle="tooltip" data-placement="top" title="Yahoo">
                <i class="icon-yahoo"></i>
                <i class="icon-yahoo"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-github" data-toggle="tooltip" data-placement="top" title="Github">
                <i class="icon-github-circled"></i>
                <i class="icon-github-circled"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-tumblr" data-toggle="tooltip" data-placement="top" title="Trumblr">
                <i class="icon-tumblr"></i>
                <i class="icon-tumblr"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-instagram" data-toggle="tooltip" data-placement="top" title="Instagram">
                <i class="icon-instagram"></i>
                <i class="icon-instagram"></i>
            </a>

            <a href="#" class="social-icon si-colored si-small si-pinterest" data-toggle="tooltip" data-placement="top" title="Pinterst">
                <i class="icon-pinterest"></i>
                <i class="icon-pinterest"></i>
            </a>

        </div>

        <div class="widget clearfix">

            <h4>Embed Videos</h4>
            <!-- <iframe src="//player.vimeo.com/video/103927232" width="500" height="250" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> -->

        </div>

    </div>
</div><!-- .sidebar end -->
