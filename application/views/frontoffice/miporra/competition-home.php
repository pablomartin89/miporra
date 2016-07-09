<div class="container clearfix">
    <?php /* <!-- Sidebar
      ============================================= -->
      <div class="sidebar nobottommargin clearfix">
      <div class="sidebar-widgets-wrap">

      <div class="widget widget_links clearfix">

      <h4>Buscador</h4>


      </div>

      <div class="widget widget_links clearfix">

      <h4>Estadísticas</h4>


      </div>


      <div class="widget widget-twitter-feed clearfix">

      <h4>Twitter Feed</h4>
      <ul class="iconlist twitter-feed" data-username="envato" data-count="2">
      <li></li>
      </ul>

      <a href="#" class="btn btn-default btn-sm fright">Follow Us on Twitter</a>

      </div>

      </div>
      </div><!-- .sidebar end --> */ ?>

    <!-- Post Content
    ============================================= -->
    <div class="nobottommargin col_last clearfix">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Competition</th>
                    <th>Sport</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($competitions as $c) { ?>
                    <tr onclick="document.location = '<?= base_url('competitions/' . $c->url) ?>';">
                        <td><?= $c->id ?></td>
                        <td><?= $c->name ?></td>
                        <td><?= $c->sportname ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


    </div><!-- .postcontent end -->



</div>
