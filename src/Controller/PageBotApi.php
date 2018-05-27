<?php

namespace Drupal\telegram\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;
use Drupal\Component\Serialization\Json;
use Drupal\telegramlog\Controller\LogManager;

/**
 * Controller routines for page example routes.
 */
class PageBotApi extends ControllerBase {

  /**
   * JSON response.
   */
  public function json($bid) {
    $data = Json::decode(\Drupal::request()->getContent());
    $bot = \Drupal::entityManager()->getStorage('bot')->load($bid);
    $path = \Drupal::service('module_handler')->getModule('telegram')->getPath();
    LogManager::msg($bid, $data);
    $message = "";
    try {
      $name = $bot->botname->value;
      $key = $bot->apikey->value;
      $telegram = new Telegram($key, $name);
      // Add commands paths containing your custom commands.
      $commands_paths = [
        DRUPAL_ROOT . "/$path/src/Commands/All",
        DRUPAL_ROOT . "/$path/src/Commands/$name",
      ];
      if (FALSE) {
        // Enable MySQL.
        $config = \Drupal::config('telegram.settings');
        $mysql_credentials = [
          'host'     => 'localhost',
          'user'     => $config->get('dbuser'),
          'password' => $config->get('dbpass'),
          'database' => $config->get('dbname'),
        ];
        $telegram->enableMySql($mysql_credentials);
      }
      $telegram->addCommandsPaths($commands_paths);
      $telegram->enableLimiter();
      $telegram->handle();
    }
    catch (\Exception $e) {
      \Drupal::logger('telegram')->error(($e->getMessage()));
    }
    $json = Json::encode($message, JSON_UNESCAPED_UNICODE);
    $response = new Response($json);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  /**
   * Send.
   */
  public static function send($bid, $uid, $message) {
    $bot = \Drupal::entityManager()->getStorage('bot')->load($bid);
    $telegram = $bot->telegramInit();
    $user = \Drupal::entityManager()->getStorage('telegramuser')->load($uid);
    $msg = [
      'chat_id' => $user->uid->value,
      'text' => $message,
    ];
    $result = Request::sendMessage($msg);
  }

}
