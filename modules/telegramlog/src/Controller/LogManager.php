<?php

namespace Drupal\telegramlog\Controller;

/**
 * @file
 * Contains \Drupal\telegramlog\Controller\BotManager.
 */

use Drupal\Core\Controller\ControllerBase;
use Drupal\telegram\Controller\BotManager;
use Drupal\Component\Utility\Unicode;
use Symfony\Component\Yaml\Yaml;

/**
 * Account Manager.
 */
class LogManager extends ControllerBase {

  /**
   * Message.
   */
  public static function msg($bid, $data) {
    $msg = $data['message'];
    $bot = \Drupal::entityManager()->getStorage('bot')->load($bid);
    $user = BotManager::getAccount($bid, $data['message']['from']);
    $storage = \Drupal::entityManager()->getStorage('telegramlog');
    if (!$text = $msg['text']) {
      if (!$text = Yaml::dump($msg['sticker'])) {
        $text = Yaml::dump($data);
      }
    }

    $chat = $msg['chat']['id'];
    unset($msg['chat']['id']);
    $log = $storage->create([
      'name' => Unicode::substr($msg['text'], 0, 60),
      'created' => $msg['date'],
      'user_id' => $user->id(),
      'bot' => $bot,
      'chat' => $chat,
      'chatinfo' => implode("|", $msg['chat']),
      'field_message' => $text,
    ]);
    $log->save();
    return $user;
  }

}
