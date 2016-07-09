<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MS_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('user_group');
    }

    public function index() {

        $this->form_validation->set_error_delimiters('<div class="style-msg errormsg"> <div class="sb-msg"><i class="icon-remove"></i>', '</div></div>');

        $errors = array();


        /**
         * Login / Register
         */
        if ($this->input->post()) {
            // Login
            if ($this->input->post('login-form-submit')) {
                $user = $this->user->fill(array(
                    'nick' => $this->input->post('login-form-username'),
                    'password' => hash('sha512', $this->input->post('login-form-password'))), true);

                if ($user) {
                    $this->session->set_userdata(array('id' => $user->id, 'nick' => $user->nick, 'firstname' => $user->firstname, 'email' => $user->email, 'LoggedIN' => TRUE));
                } else {
                    $this->_assign(array('loginfailed' => 'Authentication Failed'));
                }

                // Register
            } else if ($this->input->post('register-form-submit')) {
                $this->form_validation->set_rules('register-form-firstname', 'Username', 'required');
                $this->form_validation->set_rules('register-form-lastname', 'Lastname', 'required');
                $this->form_validation->set_rules('register-form-username', 'Nick', 'required|callback__username_check');
                $this->form_validation->set_rules('register-form-email', 'Email', 'required|callback__email_check');
                $this->form_validation->set_rules('register-form-password', 'Password', 'required');


                if ($this->form_validation->run() == FALSE) {
                    $this->_assign(array('errors' => 'There are errors'));
                } else {
                    $user = new User();
                    $user->firstname = $this->input->post('register-form-firstname');
                    $user->lastname = $this->input->post('register-form-lastname');
                    $user->nick = $this->input->post('register-form-username');
                    $user->email = $this->input->post('register-form-email');
                    $user->password = hash('sha512', $this->input->post('register-form-password'));
                    $user->save();

                    /**
                     * Experimentalmente metemos a los usuarios en un grupo y competicion.
                     * Las invitaciones las hará una persona, e invitara al grupo en el que esté inscrito.
                     */
                    $usergroup = new UserGroup();
                    $usergroup->group_id = 1; // Sustituir por el grupo del que invita, posteriormente dejar vacío.
                    $usergroup->user_id = $user->id;
                    $usergroup->save();



                    $this->session->set_userdata(array('id' => $user->id, 'nick' => $user->nick, 'firstname' => $user->firstname, 'email' => $user->email, 'LoggedIN' => TRUE, 'newLogin' => TRUE));
                    // Registrado, envio a la home.
                    // Inicialmente se quedarán en mi cuenta
                    // redirect(''); 
                }
            }
        }



        // Logueado
        if (!$this->session->has_userdata('LoggedIN')) {
            $this->_assign(array(
                'breadcrump' => array('pagename' => 'Mi cuenta', 'section' => 'Mi cuenta'),
                'menu' => $this->load->view($this->front_folder . 'layout/menu', $this->data, true),
                'pageTitle' => $this->load->view($this->front_folder . 'layout/pagetitle', $this->data, true),
                'pageContent' => $this->load->view($this->front_folder . 'login', $this->data, true),
            ));
            $this->load->view($this->front_folder . 'layout/layout', $this->data);
            
        } else {
            redirect('myaccount');
        }
        
    }

    public function logout() {
        $array_items = array('id', 'nick', 'firstname', 'email', 'LoggedIN', 'newLogin');
        $this->session->unset_userdata($array_items);
        redirect('myaccount');
    }

    public function _username_check($nick) {
        if ($this->user->fill(array('nick' => $nick))) {
            $this->form_validation->set_message('_username_check', '{field} must be unique');
            return FALSE;
        }

        return TRUE;
    }

    public function _email_check($email) {
        if ($this->user->fill(array('email' => $email))) {
            $this->form_validation->set_message('_email_check', '{field} must be unique');
            return FALSE;
        }

        return TRUE;
    }

}
