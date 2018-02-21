<?php

namespace Drupal\telegram\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Bot entity entities.
 *
 * @ingroup telegram
 */
interface BotEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Bot entity name.
   *
   * @return string
   *   Name of the Bot entity.
   */
  public function getName();

  /**
   * Sets the Bot entity name.
   *
   * @param string $name
   *   The Bot entity name.
   *
   * @return \Drupal\telegram\Entity\BotEntityInterface
   *   The called Bot entity entity.
   */
  public function setName($name);

  /**
   * Gets the Bot entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Bot entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Bot entity creation timestamp.
   *
   * @param int $timestamp
   *   The Bot entity creation timestamp.
   *
   * @return \Drupal\telegram\Entity\BotEntityInterface
   *   The called Bot entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Bot entity published status indicator.
   *
   * Unpublished Bot entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Bot entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Bot entity.
   *
   * @param bool $published
   *   TRUE to set this Bot entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\telegram\Entity\BotEntityInterface
   *   The called Bot entity entity.
   */
  public function setPublished($published);

}
