<?php

class App {

  /**
   * @var array
   */
  protected $settings;

  /**
   * @var mysqli
   */
  protected $mysqli;

  /**
   * @var bool
   */
  protected $mysqliErr = FALSE;

  /**
   * @param $settings
   */
  function __construct($settings) {

    ini_set("session.cookie_lifetime", "108000");
    ini_set("session.gc_maxlifetime", "108000");

    session_start();

    $this->settings = $settings;
  }

  /**
   * App destructor
   */
  function __destruct() {
    if ($mysqli = $this->mysqli()) {
      $mysqli->close();
    }
  }

  /**
   * Handles the request
   *
   * @return string[]
   */
  function handle() {

    // MySQL error
    if (!$this->mysqli()) {
      return ['html' => $this->renderContent('pages/error.php')];
    }

    switch ($_SERVER['REQUEST_URI']) {
      case '/details':
        if (!$this->getState('front-viewed')) {
          return ['url' => $this->settings['base_url'] . '/'];
        }
        return [
          'page_title' => 'Details page',
          'html' => $this->renderContent('pages/details.php'),
        ];
        break;
      case '/form-feedback':
        // A form was submitted
        if (!empty($_POST)) {
          $this->storeFeedback($_POST);
          $this->setState('front-viewed', NULL);
          return [
            'url' => $this->settings['base_url'] . '/',
          ];
        }
        return [
          'page_title' => 'Please give us some feedback',
          'html' => $this->renderContent('pages/form-feedback.php'),
        ];
        break;

      case '/':
        $this->setState('front-viewed', true);
        return [
          'page_title' => 'Interesting front page',
          'html' => $this->renderContent('pages/front.php'),
        ];
        break;
    }

    return [
      'url' => $this->settings['base_url'],
    ];
  }

  /**
   * @param $page
   * @param array $vars
   *
   * @return false|string
   */
  protected function renderContent($page, $vars = []) {

    $base_url = $this->settings['base_url'];

    $app = $this;
    foreach ($vars as $key => $value) {
      $$key = $value;
    }
    ob_start();
    include $page;
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
  }

  /**
   *
   */
  protected function storeFeedback() {
    // Actually stores feedback data in database
  }

  /**
   * Session state getter
   *
   * @param string $item
   *
   * @return mixed|void
   */
  protected function getState($item) {
    if (isset($_SESSION[$item])) {
      return $_SESSION[$item];
    }
  }

  protected function setState($item, $value) {
    $_SESSION[$item] = $value;
  }

  /**
   * @return \mysqli|void
   */
  protected function mysqli() {

    // First connection
    if (!$this->mysqli && !$this->mysqliErr) {
      $this->mysqli = new mysqli($this->settings['db_hostname'], $this->settings['db_username'], $this->settings['db_password'], $this->settings['db_database']);

      // Comprobar conexión
      if ($this->mysqli->connect_errno) {
        $this->mysqliErr = TRUE;
        return;
      }

      // Set DDBB connection
      if (!$this->mysqli->set_charset("utf8")) {
        $this->mysqliErr = TRUE;
        return;
      }
    }

    if (!$this->mysqliErr) {
      return $this->mysqli;
    }
  }

}