<?php

/**
 * @file
 * Contains telegramuser.page.inc.
 *
 * Page callback for Telegram User entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Telegram User templates.
 *
 * Default template: telegramuser.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_telegramuser(array &$variables) {
  // Fetch TelegramUser Entity Object.
  $telegramuser = $variables['elements']['#telegramuser'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
