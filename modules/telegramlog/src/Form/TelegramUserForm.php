<?php

namespace Drupal\telegramlog\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Telegram User edit forms.
 *
 * @ingroup telegramlog
 */
class TelegramUserForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\telegramlog\Entity\TelegramUser */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Telegram User.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Telegram User.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.telegramuser.canonical', ['telegramuser' => $entity->id()]);
  }

}
