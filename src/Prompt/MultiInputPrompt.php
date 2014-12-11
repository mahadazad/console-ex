<?php
/**
* @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) Muhammad Mahad Azad <mahadazad@gmail.com>
*/
namespace ConsoleEx\Prompt;

use Zend\Console\Prompt\AbstractPrompt;
use Zend\Console\Prompt\PromptInterface;
use Zend\Console\Prompt\Char;

/**
 * Takes multiple input using prompt object. Asks for more (y/n) otherwise used given messages
 */
class MultiInputPrompt extends AbstractPrompt
{
    /**
     * @var PromptInterface
     */
    protected $prompt;

    /**
     * @var array
     */
    protected $msgs;

    /**
     * @param PromptInterface $prompt
     * @param array           $messages
     * @param string          $moreMessage message shown on more prompt
     */
    public function __construct(PromptInterface $prompt, $messages = array(), $moreMessage = 'more? [y,n]')
    {
        $this->prompt = $prompt;
        $this->msgs = $messages;
    }

    /**
     * @return array
     */
    public function show()
    {
        $inputs = array();
        $more = 'n';
        $msgsGiven = count($this->msgs) > 0;

        $isRequired = false;
        if (method_exists($this->prompt, 'getAllowEmpty')) {
            $isRequired = !$this->prompt->getAllowEmpty();
        }

        do {
            if ($msgsGiven) {
                $msg = array_shift($this->msgs);
            } elseif (method_exists($this->prompt, 'getPromptText') && method_exists($this->prompt, 'setPromptText')) {
                $msg = $this->prompt->getPromptText();
                $this->prompt->setPromptText($msg);
            }

            do {
                $input = $this->prompt->show();
                $inputs[] = $input;
            } while ($isRequired && empty($input));

            if (!$msgsGiven) {
                $more = Char::prompt(
                    $moreMessage,
                    'yn',
                    true,
                    false,
                    false
                );
            }
        } while ($more == 'y' || ($msgsGiven && !empty($this->msgs)));

        return $this->lastResponse = $inputs;
    }
}
