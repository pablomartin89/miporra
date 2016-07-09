
<div class="container clearfix">


    <!-- Post Content
    ============================================= -->
    <div class="nobottommargin col_last clearfix">
        <div class="tabs clearfix ui-tabs ui-widget ui-widget-content ui-corner-all" id="tab-3">

            <ul class="tab-nav tab-nav2 clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">

                <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-10" aria-labelledby="ui-id-22" aria-selected="false"><a href="#tabs-10" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-22">Resultados</a></li>
                <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-11" aria-labelledby="ui-id-23" aria-selected="false"><a href="#tabs-11" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-23">Clasificacion</a></li>

            </ul>

            <div class="tab-container">


                <div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-10" aria-labelledby="ui-id-22" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">


                    <?php foreach ($matchsByRound as $key => $round) { ?>
                        <div class="panel panel-primary col_one_third <?= $round[0]->round->number % 3 ?> <?php if ($round[0]->round->number % 3 == 0) echo 'col_last' ?>">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $round[0]->round->name ?><?=($round[0]->round->date)?' - '.$round[0]->round->date:'' ?></h3>
                            </div>
                            <div class="panel-body">
                                <?php foreach ($round as $m) { ?>
                                    <?= $m->name_local ?> <?= $m->score_local ?>-<?= $m->score_visitor ?> <?= $m->name_visitor ?> <br/>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>


                </div>
                <div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-11" aria-labelledby="ui-id-23" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>PJ</th>
                                <th>PG</th>
                                <th>PE</th>
                                <th>PP</th>
                                <th>GF</th>
                                <th>GC</th>
                                <th>PTOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clasificacion as $key => $c) { ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $c->name ?></td>
                                    <td><?= $c->PJ ?></td>
                                    <td><?= $c->PG ?></td>
                                    <td><?= $c->PE ?></td>
                                    <td><?= $c->PP ?></td>
                                    <td><?= $c->GF ?></td>
                                    <td><?= $c->GC ?></td>
                                    <td><?= $c->PUNTOS ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>




    </div><!-- .postcontent end -->



</div>
