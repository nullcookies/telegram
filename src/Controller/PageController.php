<?php

namespace Drupal\telegram\Controller;

use Drupal\Core\Controller\ControllerBase;
use Longman\TelegramBot\Request;
use Drupal\node\Entity\Node;
use Drupal\Core\Mail\MailFormatHelper;

/**
 * Controller routines for page example routes.
 */
class PageController extends ControllerBase {

  /**
   * Debug Page.
   */
  public static function debug() {
    // BOT: lp2Bot.
    $bot_id = 1;
    $bot = \Drupal::entityManager()->getStorage('bot')->load($bot_id);
    $telegram = $bot->telegramInit();
    // USER: Politsyna.
    $tuser_id = 1;
    $tuser = \Drupal::entityManager()->getStorage('telegramuser')->load($tuser_id);
    $firstname = $tuser->firstname->value;
    $lastname = $tuser->lastname->value;
    $uid = $tuser->uid->value;
    // Load Node.
    $node = Node::load(41);
    $body = $node->body->value;
    // Message.
    $message1 = $node->title->value;
    $formater = new MailFormatHelper();
    $body = $formater::htmlToText($body);
    $body = $formater::wrapMail($body);
    dsm($body);
    $text = "Hello, $firstname $lastname!\nГлава $message1\n{$body}";
    $msg = [
      'chat_id' => $uid,
      'text' => $text,
    ];
    $result = Request::sendMessage($msg);
    dsm($result);
    return [
      'ok' => ['#markup' => 'ok'],
    ];
  }

}
