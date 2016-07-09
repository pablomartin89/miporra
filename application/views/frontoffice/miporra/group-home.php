

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
                        <th>Grupo</th>
                        <th>nº competiciones</th>
                        <th>nº usuarios</th>
                        <th>Público</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($groups as $g) { ?>
                        <tr onclick="document.location = '<?= base_url('groups/' . $g->url) ?>';">
                            <td><?= $g->id ?></td>
                            <td><?= $g->name ?></td>
                            <td><?= $g->nb_competition ?></td>
                            <td><?= $g->nb_users ?></td>
                            <td><?= $g->isPublic ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


        </div><!-- .postcontent end -->



    </div>


