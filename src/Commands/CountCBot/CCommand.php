<?php

namespace Longman\TelegramBot\Commands\UserCommands;

/**
 * This file is part of the TelegramBot package.
 */
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Drupal\node\Entity\Node;

/**
 * User "/cal" command.
 */
class CCommand extends UserCommand {

  /**
   * @var string
   */
  protected $name = 'c';
  protected $description = 'Калории';
  protected $usage = '/c <ccal>';
  protected $version = '1.0.0';

  /**
   * Command execute method.
   */
  public function execute() {
    $message = $this->getMessage();
    $chat_id = $message->getChat()->getId();
    $uid = self::query($chat_id);
    $sum_day = self::queryEveryday($uid);
    $ostatok = 2200 - $sum_day;
    $text = '';
    $cal = trim($message->getText(TRUE));
    if (is_numeric($cal)) {
      // Create node object with attached file.
      $noderaw = [
        'title'       => 'Title',
        'type'        => 'log',
        'field_log_user' => $uid,
        'field_log_kalorii' => $cal,
      ];
      $node = Node::create($noderaw);
      $node->save();
      $ostatok = $ostatok - $cal;
      $text = "Введено $cal ккал. Осталось за день: $ostatok";
    }
    else {
      $text = "Калорий за день: $sum_day. Осталось: $ostatok";
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
    $cal = 0;
    if (!empty($ids)) {
      foreach ($storage->loadMultiple($ids) as $id => $node) {
        $entities[$id] = $node;
        $cal_node = $node->field_log_kalorii->value;
        $cal = $cal_node + $cal;
      }
    }
    return $cal;
  }

}
