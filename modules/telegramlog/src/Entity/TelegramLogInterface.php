<?php

namespace Drupal\telegramlog\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Telegram log entities.
 *
 * @ingroup telegramlog
 */
interface TelegramLogInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Telegram log name.
   *
   * @return string
   *   Name of the Telegram log.
   */
  public function getName();

  /**
   * Sets the Telegram log name.
   *
   * @param string $name
   *   The Telegram log name.
   *
   * @return \Drupal\telegramlog\Entity\TelegramLogInterface
   *   The called Telegram log entity.
   */
  public function setName($name);

  /**
   * Gets the Telegram log creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Telegram log.
   */
  public function getCreatedTime();

  /**
   * Sets the Telegram log creation timestamp.
   *
   * @param int $timestamp
   *   The Telegram log creation timestamp.
   *
   * @return \Drupal\telegramlog\Entity\TelegramLogInterface
   *   The called Telegram log entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Telegram log published status indicator.
   *
   * Unpublished Telegram log are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Telegram log is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Telegram log.
   *
   * @param bool $published
   *   TRUE to set this Telegram log to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\telegramlog\Entity\TelegramLogInterface
   *   The called Telegram log entity.
   */
  public function setPublished($published);

}
