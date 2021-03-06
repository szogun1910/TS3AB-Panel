<?php
 /**
  * Information
  * @Author: xares
  * @Date:   21-05-2020 12:59
  * @Filename: Volume.php
  * @Project: xDashTS3AudioBot
  *
  * Contact
  * @Email: xares.scripts@gmail.com
  * @TeamSpeak: x-scripts.pl, jutuby.net
  *
  * Modify
  * @Last Modified by:   xares
  * @Last Modified time: 21-05-2020 13:15
  *
  * @Copyright(C) 2020 x-Scripts
  */

  class Volume extends CI_Controller {
    public function index() {
      $this->output->set_content_type('application/json')->set_status_header(200);
      if(!$this->session->userdata('logged')) {
        return $this->output->set_output(printJson(false,'Najpierw się zaloguj!'));
      }

      $permissions = permission(['editExpertBot','editAdvancedBot','viewAllBots']);
      if(!($permissions['editExpertBot'] || $permissions['editAdvancedBot'])) {
        return $this->output->set_output(printJson(false,'Nie posiadasz dostępu!'));
      }

      $req = request($this->input->post(),['botID','value'],['Podaj id bota!','Podaj domyślną głośność!']);
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

      if(!is_numeric($req['value'])) {
        return $this->output->set_output(printJson(false,'Głośność można podać tylko w liczbach!'));
      }

      $run = json_decode($this->ts3ab->command("settings/bot/set/{$req['botID']}/audio.volume.default/{$req['value']}"),true);
      if(isset($run['ErrorMessage'])) {
        return $this->output->set_output(printJson(false,$run['ErrorMessage']));
      }


      return $this->output->set_output(printJson(true,'Zapisano'));
    }
  }
 ?>
