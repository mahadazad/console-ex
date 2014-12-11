<?php
/**
* @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) Muhammad Mahad Azad <mahadazad@gmail.com>
*/
namespace ConsoleEx\Prompt;

use Zend\Console\Prompt\AbstractPrompt;
use Zend\Console\Prompt\Line;

/**
 * Takes an input (optional/required) from user and validate it against a callback
 */
class SingleInput extends AbstractPrompt
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $invalidMsg;

    /**
     * @var boolean
     */
    protected $isRequired;

    /**
     * @var null|callable
     */
    protected $validateCallback;

    /**
     * @param string   $message          message shown to the user on input
     * @param string   $invalidMsg       message shown to the user on invalid input
     * @param boolean  $isRequired       is the input mandatory
     * @param callable $validateCallback callback to validate input
     */
    public function __construct($message = 'Please enter value: ', $invalidMsg = 'Please enter a valid value: ', $isRequired = false, $validateCallback = null)
    {
        $this->message = $message;
        $this->invalidMsg = $invalidMsg;
        $this->isRequired = $isRequired;
        $this->validateCallback = $validateCallback;
    }

    /**
     * @return string
     */
    public function show()
    {
        $input = '';
        $valid = '';
        $tmpMsg = $this->message;
        do {
            $input = Line::prompt(
                $tmpMsg,
                !$this->isRequired,
                1500
            );
            $tmpMsg = $this->invalidMsg;

            $isValid = true;
            if (is_callable($this->validateCallback)) {
                $isValid = call_user_func($this->validateCallback, $input);
            }
        } while (!$isValid && $this->isRequired);

        return $this->lastResponse = $input;
    }
}
