<?php

namespace Drupal\telegram;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Bot entity entity.
 *
 * @see \Drupal\telegram\Entity\BotEntity.
 */
class BotEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\telegram\Entity\BotEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished bot entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published bot entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit bot entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete bot entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add bot entity entities');
  }

}
