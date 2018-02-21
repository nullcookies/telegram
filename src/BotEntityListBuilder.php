<?php

namespace Drupal\telegram;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Bot entity entities.
 *
 * @ingroup telegram
 */
class BotEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('bID');
    $header['name'] = $this->t('Name');
    $header['botname'] = $this->t('Bot Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\telegram\Entity\BotEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.bot.edit_form',
      ['bot' => $entity->id()]
    );
    $name = $entity->botname->value;
    $row['botname'] = [
      'data' => ['#markup' => "<a href='https://t.me/$name'>t.me/$name</a>"],
    ];
    return $row + parent::buildRow($entity);
  }

}
