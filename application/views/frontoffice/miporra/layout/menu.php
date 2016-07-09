<!-- Primary Navigation
============================================= -->
<nav id="primary-menu" class="dark">

    <ul>
        <li class="current"><a href="<?= base_url() ?>"><div>Home</div></a></li>
        <li><a href="<?= base_url('competitions') ?>"><div>Competiciones</div></a></li>
        <li class="mega-menu"><a href="<?= base_url('groups') ?>"><div>Porras</div></a></li>
        <li class="mega-menu"><a href="#"><div>Faq</div></a></li>
        <li><a href="#"><div>Contacto</div></a></li>
        <li class="mega-menu"><a href="<?= base_url('myaccount') ?>"><div><?=($user)?$user->nick:'Mi Cuenta'?></div></a></li>
    </ul>

    <!-- Top Search
    ============================================= -->
    <div id="top-search">
        <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
        <form action="search.html" method="get">
            <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
        </form>
    </div><!-- #top-search end -->

</nav><!-- #primary-menu end -->