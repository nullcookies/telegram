<?php

namespace Drupal\telegram\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\synhelper\Controller\AjaxResult;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Yaml\Yaml;

/**
 * Implements the form controller.
 */
class BotForm extends FormBase {

  /**
   * AJAX Wrapper.
   *
   * @var wrapper
   */
  private $wrapper = 'telegram-results';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'telegram-form';
  }

  /**
   * WebhookInfo.
   */
  public function ajaxWebhookInfo(array &$form, $form_state) {
    $otvet = "WebhookInfo:\n";
    try {
      $telegram = new Telegram($form_state->key, $form_state->name);
      // Set webhook.
      $otvet .= "<b>Comands:</b>\n";
      $comands = $telegram->getCommandsList();
      $otvet .= Yaml::dump($comands);
      $otvet .= "<b>Updates:</b>\n";
      $updates = $telegram->handleGetUpdates();
      $otvet .= Yaml::dump($updates);
    }
    catch (\Exception $e) {
      $otvet .= $e->getMessage();
    }
    return AjaxResult::ajax($this->wrapper, $otvet);
  }

  /**
   * F ajaxSet.
   */
  public function ajaxSet(array &$form, $form_state) {
    $otvet = "Set:\n";
    $url = $form_state->site . $form_state->path;
    $otvet .= "$url\n";

    try {
      $telegram = new Telegram($form_state->key, $form_state->name);
      $result = $telegram->setWebhook($url);
      if ($result->isOk()) {
        $otvet .= $result->getDescription();
      }
    }
    catch (\Exception $e) {
      $otvet .= $e->getMessage();
    }
    return AjaxResult::ajax($this->wrapper, $otvet);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $extra = NULL) {
    $bot = $extra;
    $id = $bot->id();
    $form_state->setCached(FALSE);
    $form_state->site = 'https://' . \Drupal::request()->getHost();
    $form_state->path = "/telegram/v1/{$id}/json";
    $form_state->name = $bot->botname->value;
    $form_state->key = $bot->apikey->value;

    $form['telegram'] = [
      '#type' => 'details',
      '#title' => $this->t('Telegram settings'),
      '#open' => TRUE,
      'actions' => [
        '#suffix' => "<div id='$this->wrapper'></div>",
        'exec' => AjaxResult::Button('::ajaxSet', 'Set Webhook'),
        'info' => AjaxResult::Button('::ajaxWebhookInfo', 'Webhook Info'),
      ],
    ];
    return $form;
  }

  /**
   * Implements a form submit handler.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);
  }

}
