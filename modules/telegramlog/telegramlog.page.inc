<?php

/**
 * @file
 * Contains telegramlog.page.inc.
 *
 * Page callback for Telegram log entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Telegram log templates.
 *
 * Default template: telegramlog.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_telegramlog(array &$variables) {
  // Fetch TelegramLog Entity Object.
  $telegramlog = $variables['elements']['#telegramlog'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
