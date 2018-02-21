<?php

namespace Drupal\telegramlog;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Telegram User entities.
 *
 * @ingroup telegramlog
 */
class TelegramUserListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('TUser ID');
    $header['name'] = $this->t('Name');
    $header['userid'] = $this->t('uid');
    $header['username'] = $this->t('Username');
    $header['firstname'] = $this->t('Firstname');
    $header['lastname'] = $this->t('Lastname');
    $header['bots'] = $this->t('Bots');
    $header['access'] = $this->t('Access');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\telegramlog\Entity\TelegramUser */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.telegramuser.edit_form',
      ['telegramuser' => $entity->id()]
    );
    $row['uid'] = $entity->uid->value;
    $row['username'] = "";
    if ($entity->username->value) {
      $name = $entity->username->value;
      $row['username'] = [
        'data' => ['#markup' => "<a href='https://t.me/$name'>t.me/$name</a>"],
      ];
    }
    $row['firstname'] = $entity->firstname->value;
    $row['lastname'] = $entity->lastname->value;
    $bots = [];
    if (count($entity->field_bot)) {
      foreach ($entity->field_bot as $key => $bot) {
        $bots[] = $bot->entity->name->value;
      }
    }
    $row['bots'] = implode(", ", $bots);
    $row['access'] = format_date($entity->changed->value, 'custom', 'd M Y - H:i:s');
    return $row + parent::buildRow($entity);
  }

}
