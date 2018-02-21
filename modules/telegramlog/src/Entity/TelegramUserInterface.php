<?php

namespace Drupal\telegramlog\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Telegram User entities.
 *
 * @ingroup telegramlog
 */
interface TelegramUserInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Telegram User name.
   *
   * @return string
   *   Name of the Telegram User.
   */
  public function getName();

  /**
   * Sets the Telegram User name.
   *
   * @param string $name
   *   The Telegram User name.
   *
   * @return \Drupal\telegramlog\Entity\TelegramUserInterface
   *   The called Telegram User entity.
   */
  public function setName($name);

  /**
   * Gets the Telegram User creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Telegram User.
   */
  public function getCreatedTime();

  /**
   * Sets the Telegram User creation timestamp.
   *
   * @param int $timestamp
   *   The Telegram User creation timestamp.
   *
   * @return \Drupal\telegramlog\Entity\TelegramUserInterface
   *   The called Telegram User entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Telegram User published status indicator.
   *
   * Unpublished Telegram User are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Telegram User is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Telegram User.
   *
   * @param bool $published
   *   TRUE to set this Telegram User to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\telegramlog\Entity\TelegramUserInterface
   *   The called Telegram User entity.
   */
  public function setPublished($published);

}
