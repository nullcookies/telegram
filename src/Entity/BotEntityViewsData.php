<?php

namespace Drupal\telegram\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Bot entity entities.
 */
class BotEntityViewsData extends EntityViewsData {

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
