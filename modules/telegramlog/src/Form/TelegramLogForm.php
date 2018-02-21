<?php

namespace Drupal\telegramlog\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Telegram log edit forms.
 *
 * @ingroup telegramlog
 */
class TelegramLogForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\telegramlog\Entity\TelegramLog */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Telegram log.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Telegram log.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.telegramlog.canonical', ['telegramlog' => $entity->id()]);
  }

}
