<?php

namespace Drupal\telegram\Controller;

/**
 * @file
 * Contains \Drupal\telegram\Controller\BotManager.
 */

use Drupal\Core\Controller\ControllerBase;

/**
 * Account Manager.
 */
class BotManager extends ControllerBase {

  /**
   * Get Account by Name.
   */
  public static function getAccount($bid, $from) {
    $id = $from['id'];
    $account = self::query($from['id']);
    if (!$account) {
      $account = self::createAccount($from, $bid);
    }
    else {
      self::addBot($account, $bid);
      $account->changed->setValue(REQUEST_TIME);
      $account->save();
    }
    return $account;
  }

  /**
   * Get Create.
   */
  public static function addBot($account, $bid) {
    $bot = \Drupal::entityManager()->getStorage('bot')->load($bid);
    $setbot = TRUE;
    foreach ($account->field_bot as $field) {
      if ($setbot && $bid == $field->entity->id()) {
        $setbot = FALSE;
      }
    }
    if ($setbot) {
      $account->field_bot[] = $bot;
    }
  }

  /**
   * Get Create.
   */
  public static function createAccount($from, $bid) {
    $storage = \Drupal::entityManager()->getStorage('telegramuser');
    $account = $storage->create([
      'name' => "{$from['username']} - {$from['id']}",
      'status' => 1,
      'uid' => $from['id'],
      'username' => $from['username'],
      'firstname' => $from['first_name'],
      'lastname' => $from['last_name'],
      'field_bot' => $bid,
    ]);
    $account->save();
    return $account;
  }

  /**
   * Query.
   */
  public static function query($id) {
    $account = FALSE;
    $query = \Drupal::entityQuery('telegramuser')
      ->condition('status', 1)
      ->condition('uid', $id)
      ->sort('created', 'ASC')
      ->range(0, 1);
    $ids = $query->execute();
    if (!empty($ids)) {
      $uid = array_shift($ids);
      $storage = \Drupal::entityManager()->getStorage('telegramuser');
      $account = $storage->load($uid);
    }
    return $account;
  }

}
