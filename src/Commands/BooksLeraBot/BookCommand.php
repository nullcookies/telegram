<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Drupal\node\Entity\Node;
use Drupal\Core\Mail\MailFormatHelper;

/**
 * User "/weather" command.
 *
 * Get weather info for any place.
 * This command requires an API key to be set via command config.
 */
class BookCommand extends UserCommand {
  /**
   * @var string
   */
  protected $name = 'book';

  /**
   * @var string
   */
  protected $description = 'Show the next part of book';

  /**
   * @var string
   */
  protected $usage = '/book <номер главы>';

  /**
   * @var string
   */
  protected $version = '1.0';

  /**
   * Command execute method.
   *
   * @return \Longman\TelegramBot\Entities\ServerResponse
   * @throws \Longman\TelegramBot\Exception\TelegramException
   */
  public function execute() {
    $message = $this->getMessage();
    $chat_id = $message->getChat()->getId();
    $text = '';
    $glava_number = trim($message->getText(TRUE));
    if ($glava_number !== '') {
      // Load Node.
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1)
        ->condition('type', 'glava')
        ->condition('title', $glava_number);
      $ids = $query->execute();
      if (!empty($ids)) {
        $node = Node::load(array_shift($ids));
        $body = $node->body->value;
        $title = $node->title->value;
        // Message.
        $formater = new MailFormatHelper();
        $body = $formater::htmlToText($body);
        $body = $formater::wrapMail($body);
        $text = "Вы запросили: Глава $title\nГлава $glava_number\n{$body}";
      }
      else {
        $text = 'Такой главы нет.';
      }
    }
    else {
      $text = 'Напишите номер главы, которую хотите прочесть, в формате /book <номер главы>';
    }

    $data = [
      'chat_id' => $chat_id,
      'text'    => $text,
    ];

    return Request::sendMessage($data);
  }

}
