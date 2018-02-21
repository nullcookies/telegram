<?php

/**
 * @file
 * Contains bot.page.inc.
 *
 * Page callback for Bot entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Bot entity templates.
 *
 * Default template: bot.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_bot(array &$variables) {
  // Fetch BotEntity Entity Object.
  $bot = $variables['elements']['#bot'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
