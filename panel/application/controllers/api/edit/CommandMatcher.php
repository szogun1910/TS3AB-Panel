<?php
 /**
  * Information
  * @Author: xares
  * @Date:   21-05-2020 13:22
  * @Filename: CommandMatcher.php
  * @Project: xDashTS3AudioBot
  *
  * Contact
  * @Email: xares.scripts@gmail.com
  * @TeamSpeak: x-scripts.pl, jutuby.net
  *
  * Modify
  * @Last Modified by:   xares
  * @Last Modified time: 21-05-2020 13:25
  *
  * @Copyright(C) 2020 x-Scripts
  */

  class commandMatcher extends CI_Controller {
    public function index() {
      $this->output->set_content_type('application/json')->set_status_header(200);
      if(!$this->session->userdata('logged')) {
        return $this->output->set_output(printJson(false,'Najpierw się zaloguj!'));
      }

      $permissions = permission(['editExpertBot','viewAllBots']);
      if(!$permissions['editExpertBot']) {
        return $this->output->set_output(printJson(false,'Nie posiadasz dostępu!'));
      }

      $req = request($this->input->post(),['botID','value'],['Podaj id bota!','Podaj rodzaj dopasowania!']);
      if(!$req['success']) {
        return $this->output->set_output(printJson(false,$req['response']));
      }
      $req = $req['response'];

      if(!$permissions['viewAllBots']) {
        if(!$this->db->query("SELECT * FROM `xDashBotsUsers` WHERE `username` = '{$this->session->userdata('login')}' AND `botID` = '{$req['botID']}'")->num_rows()) {
          return $this->output->set_output(printJson(false,'Nie znaleziono bota!'));
        }
      }

      if(!$this->db->query("SELECT * FROM `xDashBotList` WHERE `id` = '{$req['botID']}'")->num_rows()) {
        return $this->output->set_output(printJson(false,'Nie znaleziono bota!'));
      }

      $run = json_decode($this->ts3ab->command("settings/bot/set/{$req['botID']}/commands.matcher/{$req['value']}"),true);
      if(isset($run['ErrorMessage'])) {
        return $this->output->set_output(printJson(false,$run['ErrorMessage']));
      }

      return $this->output->set_output(printJson(true,'Zapisano'));
    }
  }
 ?>
