<?php

namespace Drupal\telegram\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\synhelper\Controller\AjaxResult;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Yaml\Yaml;
use Longman\TelegramBot\Request;

/**
 * Implements the form controller.
 */
class Settings extends ConfigFormBase {
  /**
   * AJAX Wrapper.
   *
   * @var wrapper
   */
  private $wrapper = 'drupal-results';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'telegram';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['telegram.settings'];
  }

  /**
   * WebhookInfo.
   */
  public function ajaxWebhookInfo(array &$form, $form_state) {
    $otvet = "ajaxSet:\n";
    $config = $this->config('telegram.settings');
    try {
      // Create Telegram API object.
      $telegram = new Telegram($config->get('api-key'), $config->get('botname'));
      // Set webhook.\
      //dsm($telegram);
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
    $otvet = "ajaxSet:\n";
    $config = $this->config('telegram.settings');
    $bot_api_key = $config->get('api-key');
    $bot_username = $config->get('botname');
    $hook_url = $config->get('url');

    try {
      // Create Telegram API object.
      $telegram = new Telegram($bot_api_key, $bot_username);
      // Set webhook.
      $result = $telegram->setWebhook($hook_url);
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
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('telegram.settings');

    $form['mode'] = [
      '#type' => 'details',
      '#title' => $this->t('General settings'),
      '#open' => TRUE,
      'actions' => [
        '#suffix' => "<div id='$this->wrapper'></div>",
        'exec' => AjaxResult::Button('::ajaxSet', 'Set Webhook'),
        'info' => AjaxResult::Button('::ajaxWebhookInfo', 'Webhook Info'),
      ],
    ];
    $form['general'] = [
      '#type' => 'details',
      '#title' => $this->t('General settings'),
      '#open' => TRUE,
    ];
    $form['general']['api-key'] = [
      '#title' => $this->t('API Key'),
      '#default_value' => $config->get('api-key'),
      '#type' => 'textfield',
      '#description' => 'your:bot_api_key',
    ];
    $form['general']['botname'] = [
      '#title' => $this->t('Bot name'),
      '#default_value' => $config->get('botname'),
      '#type' => 'textfield',
      '#description' => 'username_bot',
    ];
    $form['general']['url'] = [
      '#title' => $this->t('Hook path'),
      '#default_value' => $config->get('url'),
      '#type' => 'textfield',
      '#description' => 'https://www.pynicode.name/telegram/v1/json',
    ];
    $form['general']['dbname'] = [
      '#title' => $this->t('Db name'),
      '#default_value' => $config->get('dbname'),
      '#type' => 'textfield',
    ];
    $form['general']['dbuser'] = [
      '#title' => $this->t('Db user'),
      '#default_value' => $config->get('dbuser'),
      '#type' => 'textfield',
    ];
    $form['general']['dbpass'] = [
      '#title' => $this->t('Db pass'),
      '#default_value' => $config->get('dbpass'),
      '#type' => 'textfield',
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * Implements a form submit handler.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('telegram.settings');
    $config
      ->set('api-key', $form_state->getValue('api-key'))
      ->set('botname', $form_state->getValue('botname'))
      ->set('url', $form_state->getValue('url'))
      ->set('dbname', $form_state->getValue('dbname'))
      ->set('dbuser', $form_state->getValue('dbuser'))
      ->set('dbpass', $form_state->getValue('dbpass'))
      ->save();
  }

}
