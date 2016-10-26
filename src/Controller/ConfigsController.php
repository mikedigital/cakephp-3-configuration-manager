<?php
namespace ConfigManager\Controller;

use ConfigManager\Controller\AppController;

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

/**
 * Configs Controller
 *
 * @property \ConfigManager\Model\Table\ConfigsTable $Configs
 */
class ConfigsController extends AppController {

  public function initialize() {
      parent::initialize();

      $config_exists = Configure::check('ConfigManager');

      if(!$config_exists) {
        return $this->redirect(['action' => 'index']);
      }

      $this->set(compact('config_exists'));
  }
  /**
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index()
  {
      $config = Configure::read('ConfigManager');

      $this->set(compact('config'));
      $this->set('_serialize', ['config']);
  }

  /**
   * View method
   *
   * @param string|null $id Config id.
   * @return \Cake\Network\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null)
  {
      $config = $this->Configs->get($id, [
          'contain' => []
      ]);

      $this->set('config', $config);
      $this->set('_serialize', ['config']);
  }

  /**
   * Edit method
   *
   * @param string|null $key Config key.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($key = null)
  {
    # Check if they supplied a key
    if(!$key) {
      $this->Flash->set('You did not provide a setting', ['key' => 'ConfigManager']);
      return $this->redirect(['action' => 'index']);
    }

    # Check to see if that key is in the list of available config settings
    $exists = Configure::check('ConfigManager.'.$key);

    if(!$exists) {
      $this->Flash->set('You did not provide a valid setting', ['key' => 'ConfigManager']);
      return $this->redirect(['action' => 'index']);
    }

    $setting = Configure::read('ConfigManager.'.$key);

    if($this->request->is('post')) {
      # Update the configuration file
      $value = $this->Configs->formatData($this->request->data);
      Configure::write('ConfigManager.'.$key.'.value', $value);
      Configure::write('ConfigManager.'.$key.'.modified', time());
      Configure::dump(
        CONFIG_FILENAME,
        'default',
        [
          'ConfigManager'
        ]
      );

      # Requery the config since this changed it
      // Configure::load(CONFIG_FILENAME);

      $this->Flash->set('Update successful', ['key' => 'ConfigManager']);
      return $this->redirect(['action' => 'index']);
    } else {
      $this->request->data = $setting;
    }

    $this->set(compact('key', 'setting'));
  }
}