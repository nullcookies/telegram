<?php

namespace Drupal\telegramlog\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Telegram User entities.
 */
class TelegramUserViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
