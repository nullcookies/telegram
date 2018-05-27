<?php

namespace Longman\TelegramBot\Commands\UserCommands;

/**
 * This file is part of the TelegramBot package.
 */
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Drupal\node\Entity\Node;

/**
 * User "/voda" command.
 */
class VCommand extends UserCommand {

  /**
   * @var string
   */
  protected $name = 'v';
  protected $description = 'Вода';
  protected $usage = '/v <ml>';
  protected $version = '1.0.0';

  /**
   * Command execute method.
   */
  public function execute() {
    $message = $this->getMessage();
    $chat_id = $message->getChat()->getId();
    $uid = self::query($chat_id);
    $sum_day = self::queryEveryday($uid);
    $ostatok = 1200 - $sum_day;
    $text = '';
    $voda = trim($message->getText(TRUE));
    if (is_numeric($voda)) {
      // Create node object with attached file.
      $noderaw = [
        'title'       => 'Title',
        'type'        => 'log',
        'field_log_user' => $uid,
        'field_log_voda' => $voda,
      ];
      $node = Node::create($noderaw);
      $node->save();
      $ostatok = $ostatok - $voda;
      $text = "Введено $voda мл. Осталось за день: $ostatok";
    }
    else {
      $text = "Жидкости за день: $sum_day. Осталось: $ostatok";
    }

    \Drupal::logger('telegram')->notice($text);
    $data = [
      'chat_id' => $chat_id,
      'text'    => $text,
    ];

    return Request::sendMessage($data);
  }

  /**
   * Query.
   */
  public static function query($id) {
    $entities = [];
    $entity_type = 'telegramuser';
    $storage = \Drupal::entityManager()->getStorage($entity_type);
    $query = \Drupal::entityQuery($entity_type)
      ->condition('uid', $id);
    $ids = $query->execute();
    if (!empty($ids)) {
      foreach ($storage->loadMultiple($ids) as $id => $entity) {
        $entities[$id] = $entity;
      }
    }
    return array_shift($ids);
  }

  /**
   * Query.
   */
  public static function queryEveryday($id) {
    $entities = [];
    $entity_type = 'node';
    $storage = \Drupal::entityManager()->getStorage($entity_type);
    $time = strtotime('today');
    $query = \Drupal::entityQuery($entity_type)
      ->condition('field_log_user', $id)
      ->condition('created', $time, '>')
      ->condition('status', 1)
      ->condition('type', 'log');
    $ids = $query->execute();
    $voda = 0;
    if (!empty($ids)) {
      foreach ($storage->loadMultiple($ids) as $id => $node) {
        $entities[$id] = $node;
        $voda_node = $node->field_log_voda->value;
        $voda = $voda_node + $voda;
      }
    }
    return $voda;
  }

}
