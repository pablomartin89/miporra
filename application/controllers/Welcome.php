<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MS_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('team');
        $this->load->model('season');
        $this->load->model('match');
        $this->load->model('round');
        $this->load->model('competition');
        $this->load->model('user_match');
        $this->load->model('group_competition');
    }

    public function index() {

        $this->_assign(array(
            'menu' => $this->load->view($this->front_folder . 'layout/menu', $this->data, true),
        ));

        if (!$this->session->has_userdata('LoggedIN')) {
            $this->_assign(array(
                'slider' => $this->load->view($this->front_folder . 'layout/slider', $this->data, true),
                'pageContent' => $this->load->view($this->front_folder . 'index', $this->data, true),
            ));
        } else {
            $dataIndex = array('processNewRegister' => $this->load->view($this->front_folder . 'module/process_new_register', $this->data, true));
            $this->_assign(array(
                'pageContent' => $this->load->view($this->front_folder . 'index-register', $dataIndex, true),
            ));
        }

        $this->load->view($this->front_folder . 'layout/layout', $this->data);
    }

    public function scrapMarcaLiga() {

        /*
         *  $email ='adiaz@gmail.com';
          $password ='test1234';
          $user = $this->user->fill(array('email'=>$email,'password'=>hash('sha512',$password)),true);

          if(!$user){
          $user = new User();

          }
          $user->email=$email;
          $user->password = hash('sha512',$password);
          $user->nick = 'ADiaz';
          $user->firstname = 'Arturo';
          $user->lastname = 'Diaz';
          $user->save();
         * 
          $matches = $this->match->fill();


          foreach ($matches as $m){
          $userMatch = new UserMatch();
          $group_competition = $m->getRoundId()->getCompetitionId();

          $userMatch = $this->user_match->fill(array('group_competition'=>$group_competition,'match_id'=>$m->id,'user_id'=>$user->id),true);
          if(!$userMatch){
          $userMatch = new UserMatch();
          }
          $userMatch->group_competition = $group_competition;
          $userMatch->match_id = $m->getId();
          $userMatch->user_id = $user->getId();
          $userMatch->score_local = rand(0, 5);
          $userMatch->score_visitor = rand(0, 5);
          $userMatch->save();


          } */

        $this->load->library('simple_html_dom_node');

        $teams = $this->team->fill();

        $teamsAux = array();
        $fillTeamsAux = true;
        $html = file_get_html('http://www.marca.com/futbol/primera/calendario.html');

        if (count($html->find('div[class=contenedorCalendarioInt]')) == 0) {
            exit("correo a Arturo0");
        }

        foreach ($html->find('div[class=contenedorCalendarioInt]') as $calendario) {
            if (count($calendario->find('div[class=jornadaCalendario]')) == 0) {
                exit("correo a Arturo1");
            }
            foreach ($calendario->find('div[class=jornadaCalendario]') as $jornada) {
                if (count($jornada->find('div[class=datosJornada] h2')) == 0) {
                    exit("correo a Arturo2");
                }
                foreach ($jornada->find('div[class=datosJornada] h2') as $numeroJornada) {
                    echo "<br/>";
                    $round_name = trim($numeroJornada->plaintext);
                    echo $round_name;


                    $round = $this->round->fill(array('name' => $round_name, 'competition_id' => 1), true);

                    if (!$round) {
                        $round = new Round();
                    }

                    $round->competition_id = 1;
                    $round->name = $round_name;
                    $round->number = preg_match('!\d+!', $round_name);
                    $round->save();
                }
                foreach ($jornada->find('ul[class=partidoJornada] li') as $partidoJornada) {
                    echo "<br/>";
                    $match = new Match();


                    $local = trim($partidoJornada->find('span.local', 0)->plaintext);
                    $visitante = trim($partidoJornada->find('span.visitante', 0)->plaintext);
                    $resultado = trim($partidoJornada->find('span.resultado', 0)->plaintext);
                    $scoreLocal = substr($resultado, 0, strpos($resultado, '-'));
                    $scoreVisitor = substr($resultado, strpos($resultado, '-') + 1);


                    if ($fillTeamsAux) {
                        foreach ($teams as $t) {
                            if ($t->scrap_name == $local) {
                                $teamsAux[$local] = $t->id;
                            }
                            if ($t->scrap_name == $visitante) {
                                $teamsAux[$visitante] = $t->id;
                            }
                        }
                    }

                    $match->competition_id = '559844244ce225b277bd5f60';

                    if (!isset($teamsAux[$local])) {
                        $team_local = new Team();
                        $team_local->sport_id = 1;
                        $team_local->name = $local;
                        $team_local->scrap_name = $local;
                        $team_local->save();
                        $teamsAux[$local] = $team_local->id;
                    }
                    if (!isset($teamsAux[$visitante])) {

                        $team_visitor = new Team();
                        $team_visitor->sport_id = 1;
                        $team_visitor->name = $visitante;
                        $team_visitor->scrap_name = $visitante;
                        $team_visitor->save();
                        $teamsAux[$visitante] = $team_visitor->id;
                    }
                    $match->round_id = $round->id;
                    $match->team_local = $teamsAux[$local];
                    $match->team_visitor = $teamsAux[$visitante];
                    $match->score_local = $scoreLocal;
                    $match->score_visitor = $scoreVisitor;

                    echo "Jornada: " . $round->id . " - ";
                    echo $local . ' (' . $teamsAux[$local] . ')  - ';
                    echo $visitante . ' (' . $teamsAux[$visitante] . ') ';

                    echo $scoreLocal . "-" . $scoreVisitor;
                    $match->save();
                }



                echo "<br/>";
                $fillTeamsAux = true;
            }
        }
    }

    public function scrapMarcaPremier() {
        $this->load->library('simple_html_dom_node');

        $teams = $this->team->fill();

        $teamsAux = array();
        $fillTeamsAux = true;
        $html = file_get_html('http://www.marca.com/deporte/central-de-datos/futbol/premier-league/2015-2016/calendario.html');

        if (count($html->find('div[class=contenedorCalendarioInt]')) == 0) {
            exit("correo a Arturo0");
        }

        foreach ($html->find('div[class=contenedorCalendarioInt]') as $calendario) {

            if (count($calendario->find('div[class=calendarioInternacional]')) == 0) {
                exit("correo a Arturo1");
            }
            foreach ($calendario->find('div[class=calendarioInternacional]') as $jornada) {

                if (count($jornada->find('span[class=jornada-calendario]')) == 0) {
                    exit("correo a Arturo2");
                }
                foreach ($jornada->find('span[class=jornada-calendario]') as $numeroJornada) {
                    echo "<br/>";
                    $date = DateTime::createFromFormat('d.m.Y', substr($jornada->find('th', 1)->plaintext, 0, 10))->format('Y-m-d');

                    $round_name = trim($numeroJornada->plaintext);
                    echo $round_name . "-" . $date;


                    $round = $this->round->fill(array('name' => $round_name, 'competition_id' => 2), true);

                    if (!$round) {
                        $round = new Round();
                    }

                    $round->competition_id = 2;
                    $round->name = $round_name;
                    $round->number = preg_match('!\d+!', $round_name);
                    $round->date = $date;
                    $round->save();
                }
                foreach ($jornada->find('td.local') as $partidoJornada) {
                    $partido = $partidoJornada->parent();

                    echo "<br/>";
                    $match = new Match();


                    $local = trim($partido->find('span', 0)->plaintext);
                    $visitante = trim($partido->find('span', 1)->plaintext);
                    //$resultado = trim($partido->find('span', 0)->plaintext);
                    //$scoreLocal = substr($resultado, 0, strpos($resultado, '-'));
                    //$scoreVisitor = substr($resultado, strpos($resultado, '-') + 1);


                    if ($fillTeamsAux) {
                        foreach ($teams as $t) {
                            if ($t->scrap_name == $local) {
                                $teamsAux[$local] = $t->id;
                            }
                            if ($t->scrap_name == $visitante) {
                                $teamsAux[$visitante] = $t->id;
                            }
                        }
                    }

                    $match->competition_id = '2';
                    $match->season_id = '2';

                    if (!isset($teamsAux[$local])) {
                        $team_local = new Team();
                        $team_local->sport_id = 1;
                        $team_local->name = $local;
                        $team_local->scrap_name = $local;
                        $team_local->save();
                        $teamsAux[$local] = $team_local->id;
                    }
                    if (!isset($teamsAux[$visitante])) {

                        $team_visitor = new Team();
                        $team_visitor->sport_id = 1;
                        $team_visitor->name = $visitante;
                        $team_visitor->scrap_name = $visitante;
                        $team_visitor->save();
                        $teamsAux[$visitante] = $team_visitor->id;
                    }
                    $match->round_id = $round->id;
                    $match->team_local = $teamsAux[$local];
                    $match->team_visitor = $teamsAux[$visitante];
                    $match->is_result_by_time = 0;
                    //$match->score_local = $scoreLocal;
                    //$match->score_visitor = $scoreVisitor;

                    echo "Jornada: " . $round->id . " - ";
                    echo $local . ' (' . $teamsAux[$local] . ')  - ';
                    echo $visitante . ' (' . $teamsAux[$visitante] . ') ';


                    $match->save();
                }



                echo "<br/>";
                $fillTeamsAux = true;
            }
        }
    }

    public function scrapUefaChampion() {
        $this->load->library('simple_html_dom_node');

        $teams = $this->team->fill();

        $teamsAux = array();
        $fillTeamsAux = true;



        for ($day = 1; $day <= 13; $day++) {
             
            
            for ($session = 1; $session <= 4; $session++) {
                

                if (($day != 13 || $session < 2)) {
                    $html = file_get_html('http://es.uefa.com/uefachampionsleague/season=2015/matches/library/fixtures/day=' . $day . '/session=' . $session . '/_matchesbydate.html?_=1436380234990');


                    if (count($html->find('table')) == 0) {
                        exit("correo a Arturo0");
                    }


                    foreach ($html->find('table') as $table) {
                        $date = DateTime::createFromFormat('Ymd', substr($table->getAttribute('class'), 4))->format('Y-m-d 20:45');

                        echo "<br/><br/><br/>" . $date . "<br/>";
                        foreach ($table->find('.match_res') as $DOMMatch) {
                            $DOMMatchParent = $DOMMatch->parent();
                            
                            $round_name = trim($DOMMatchParent->find('.rname a', 0)->plaintext);
                            echo $round_name;


                            $round = $this->round->fill(array('name' => $round_name, 'competition_id' => 3), true);

                            if (!$round) {
                                $round = new Round();
                            }

                            $round->competition_id = 3;
                            $round->name = $round_name;
                            
                            $round->save();
                            
                            
                            $groupName = $DOMMatchParent->find('.gname a', 0);
                            if ($groupName) {
                                $group_stage =  trim(preg_replace('/\bGrupo\b/', '', $groupName->plaintext));
                                echo '<br/><br/>' . var_dump($group_stage) . "<br/>";
                            } else {
                                $group_stage = null;
                                echo '<br/><br/>' . $round_name . "<br/>";
                            }
                            
                           
                            
                            
                            $local = trim($DOMMatch->find('a', 0)->plaintext);
                            $visitante = trim($DOMMatch->find('a', 4)->plaintext);
                            
                            
                            $resultado = trim($DOMMatch->find('a', 2)->plaintext);
                            $scoreLocal = substr($resultado, 0, strpos($resultado, '-'));
                            $scoreVisitor = substr($resultado, strpos($resultado, '-') + 1);


                            if ($fillTeamsAux) {
                                foreach ($teams as $t) {
                                    if ($t->scrap_name == $local) {
                                        $teamsAux[$local] = $t->id;
                                    }
                                    if ($t->scrap_name == $visitante) {
                                        $teamsAux[$visitante] = $t->id;
                                    }
                                }
                            }
                            
                            if (!isset($teamsAux[$local])) {
                                $team_local = new Team();
                                $team_local->sport_id = 1;
                                $team_local->name = $local;
                                $team_local->scrap_name = $local;
                                $team_local->save();
                                $teamsAux[$local] = $team_local->id;
                            }
                            if (!isset($teamsAux[$visitante])) {

                                $team_visitor = new Team();
                                $team_visitor->sport_id = 1;
                                $team_visitor->name = $visitante;
                                $team_visitor->scrap_name = $visitante;
                                $team_visitor->save();
                                $teamsAux[$visitante] = $team_visitor->id;
                            }
                            
                            $match = $this->match->fill(array('round_id'=>$round->id,'team_local'=> $teamsAux[$local],'team_visitor'=> $teamsAux[$visitante]),true);
                            if(!$match){
                                $match = new Match();
                            }

                            $match->group_stage = $group_stage;
                            $match->competition_id = '3';
                            $match->season_id = '3';
                            $match->date = $date;
                            

                            
                            $match->round_id = $round->id;
                            $match->team_local = $teamsAux[$local];
                            $match->team_visitor = $teamsAux[$visitante];
                            $match->is_result_by_time = 0;
                            $match->score_local = $scoreLocal;
                            $match->score_visitor = $scoreVisitor;
                            $match->save();

                            //echo "Jornada: " . $round->id . " - ";
                            echo $local . ' (' . $teamsAux[$local] . ')  - ';
                            echo $visitante . ' (' . $teamsAux[$visitante] . ') ';
                            echo $scoreLocal . "-" . $scoreVisitor;
                            
                            echo $DOMMatch;
                        }
                    }
                }
            }
        }





        exit("asd");

    }

}
