<?php

namespace Drupal\telegramlog;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Telegram log entities.
 *
 * @ingroup telegramlog
 */
class TelegramLogListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Log ID');
    $header['name'] = $this->t('Name');
    $header['user_id'] = $this->t('User');
    $header['bot'] = $this->t('Bot');
    $header['chat'] = $this->t('Chat');
    $header['chatinfo'] = $this->t('ChatInfo');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\telegramlog\Entity\TelegramLog */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.telegramlog.edit_form',
      ['telegramlog' => $entity->id()]
    );
    $row['user'] = "guest";
    if ($entity->user_id->entity) {
      $user = $entity->user_id->entity;
      $row['user'] = Link::createFromRoute(
        $user->label(),
        'entity.telegramuser.canonical',
        ['telegramuser' => $user->id()]
      );
    }
    $row['bot'] = "";
    if ($entity->bot->entity) {
      $bot = $entity->bot->entity;
      $row['bot'] = Link::createFromRoute(
        $bot->label(),
        'entity.bot.canonical',
        ['bot' => $bot->id()]
      );
    }
    $row['chat'] = $entity->chat->value;
    $row['chatinfo'] = $entity->chatinfo->value;
    return $row + parent::buildRow($entity);
  }

}
