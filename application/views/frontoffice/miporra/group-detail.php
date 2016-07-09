

<div class="container clearfix">


    <!-- Post Content
    ============================================= -->
    <div class="nobottommargin col_last clearfix">
        <div class="tabs clearfix ui-tabs ui-widget ui-widget-content ui-corner-all" id="tab-3">

            <ul class="tab-nav tab-nav2 clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">

                <?php foreach ($competitions as $key => $c) { ?>
                    <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-<?= $key ?>" aria-labelledby="ui-id-<?= $key ?>" aria-selected="false"><a href="#tabs-<?= $key ?>" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-<?= $key ?>"><?= $c->competition_name ?> - <?= $c->season_number ?> </a></li>
                <?php } ?>

            </ul>

            <div class="tab-container">

                <?php foreach ($clasificaciones as $key => $clasificacion) { ?>
                    <div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-<?= $key ?>" aria-labelledby="ui-id-<?= $key ?>" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nick</th>
                                    <th>Nº Resultados</th>
                                    <th>Nº Ganadores</th>
                                    <th>PTOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clasificacion as $key => $c) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $c->nick ?></td>
                                        <td><?= $c->nb_results ?></td>
                                        <td><?= $c->nb_winner ?></td>
                                        <td><?= $c->points ?></td> 
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

            </div>

        </div>
        
        <h2>Comentarios</h2>




    </div><!-- .postcontent end -->



</div>


