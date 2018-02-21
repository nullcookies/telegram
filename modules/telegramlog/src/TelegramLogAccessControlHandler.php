<?php

namespace Drupal\telegramlog;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Telegram log entity.
 *
 * @see \Drupal\telegramlog\Entity\TelegramLog.
 */
class TelegramLogAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\telegramlog\Entity\TelegramLogInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished telegram log entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published telegram log entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit telegram log entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete telegram log entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add telegram log entities');
  }

}
