<div class="fancy-title ">
    <?php if (isset($group) && isset($competition)) { ?>
        <h3><?= $group->name ?> - <span><?= $competition->name ?></span> </h3>
    <?php } else {
        ?>
        <h3>Mis <span>resultados</span> </h3>
    <?php } ?>
</div>

<p class="hidden-xs">Loorerem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, eos quibusdam accusamus. Maiores, distinctio similique at fugiat reiciendis corporis pariatur. Iusto, molestiae odio ullam quas ratione! Explicabo, sunt, totam mollitia eveniet quasi commodi maxime impedit quos magni deleniti? Laborum, ad, necessitatibus minima officiis mollitia commodi quia dolore enim animi doloribus.</p>


<div class="tabs clearfix ui-tabs ui-widget ui-widget-content ui-corner-all" id="tab-3">

    <ul class="tab-nav tab-nav2 clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">

        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-10" aria-labelledby="ui-id-22" aria-selected="false"><a href="#tabs-10" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-22">Resultados</a></li>
        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-11" aria-labelledby="ui-id-23" aria-selected="false"><a href="#tabs-11" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-23">Clasificacion</a></li>

    </ul>

    <div class="tab-container">


        <div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-10" aria-labelledby="ui-id-22" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
            
            <form id="results-form" name="register-form" class="nobottommargin" action="" method="post">

                <?php foreach ($userMatchsByRound as $key => $matches) { ?>
                    <div class="panel panel-primary col_one_third <?php if ($rounds[$key]->number % 3 == 0) echo 'col_last' ?>">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= $rounds[$key]->name ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php foreach ($matches as $m) { ?>
                                <?= $m->name_local ?> 
                                <input type="tel" id="results-score-local<?=$m->match_id?>" name="results-score-local[<?=$m->match_id?>]" value="<?= $m->user_score_local ?>" class="sm-form-control miporraresults required" aria-required="true">
                                -
                                <input type="tel" id="results-score-visitor<?=$m->match_id?>" name="results-score-visitor[<?=$m->match_id?>]" value="<?= $m->user_score_visitor ?>" class="sm-form-control miporraresults required" aria-required="true">
                                <?= $m->name_visitor ?> 
                                <br/>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="col_full nobottommargin">
                    <button class="button button-3d fright nomargin" id="results-submit" name="register-form-submit" value="results">Enviar</button>
                </div>
            </form>
            
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

            </table>
        </div>

    </div>

</div>
