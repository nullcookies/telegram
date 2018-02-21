<?php

namespace Drupal\telegramlog;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Telegram User entity.
 *
 * @see \Drupal\telegramlog\Entity\TelegramUser.
 */
class TelegramUserAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\telegramlog\Entity\TelegramUserInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished telegram user entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published telegram user entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit telegram user entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete telegram user entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add telegram user entities');
  }

}
