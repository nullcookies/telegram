<?php

namespace Longman\TelegramBot\Commands\UserCommands;

/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * User "/run" command.
 */
class RunCommand extends UserCommand {
  /**
   * @var string
   */
  protected $name = 'run';

  /**
   * @var string
   */
  protected $description = 'Run test';

  /**
   * @var string
   */
  protected $usage = '/run <text>';

  /**
   * @var string
   */
  protected $version = '1.1.0';

  /**
   * Command execute method
   *
   * @return \Longman\TelegramBot\Entities\ServerResponse
   * @throws \Longman\TelegramBot\Exception\TelegramException
   */
  public function execute() {
    $message = $this->getMessage();
    $chat_id = $message->getChat()->getId();
    $text    = trim($message->getText(TRUE));

    if ($text === '') {
      $text = 'Command usage: ' . $this->getUsage();
    }
    file_get_contents('http://synapse-home.keenetic.link:3000/start');
    $text = 'Run test';

    $data = [
      'chat_id' => $chat_id,
      'text'    => $text,
    ];

    return Request::sendMessage($data);
  }

}
