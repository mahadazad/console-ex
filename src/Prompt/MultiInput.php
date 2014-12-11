<?php
/**
* @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) Muhammad Mahad Azad <mahadazad@gmail.com>
*/
namespace ConsoleEx\Prompt;

use Zend\Console\Prompt\AbstractPrompt;
use Zend\Console\Prompt\Line;
use Zend\Console\Prompt\Char;

/**
 * Takes multiple input (required/optional) from the user also validate it against a callback
 */
class MultiInput extends AbstractPrompt
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $invalidMessage;

    /**
     * @var boolean
     */
    protected $isOptional;

    /**
     * @var null|callable
     */
    protected $validateCallback;

    /**
     * @param string   $message          message shown to the user on input
     * @param string   $invalidMsg       message shown to the user on invalid input
     * @param boolean  $isOptional       is the input optional
     * @param callable $validateCallback callback to validate input
     * @param string   $moreMessage      message shown on more prompt
     */
    public function __construct($message = 'Please enter value: ', $invalidMessage = 'Please enter a valid value: ', $isOptional = true, $validateCallback = null, $moreMessage = 'more? [y,n]')
    {
        $this->message = $message;
        $this->invalidMessage = $invalidMessage;
        $this->isOptional = $isOptional;
        $this->validateCallback = $validateCallback;
    }

    /**
     * @return array
     */
    public function show()
    {
        $inputs = array();
        $more = 'n';
        $valid = '';

        do {
            $tmpMsg = $this->message;
            do { // for input
                $input = Line::prompt(
                    $tmpMsg,
                    $this->isOptional,
                    1500
                );
                $tmpMsg = $this->invalidMessage;

                $isValid = true;
                if (is_callable($this->validateCallback)) {
                    $isValid = call_user_func($this->validateCallback, $input);
                    if ($isValid) { // is valid and callable given
                        $inputs[] = $input;
                    }
                } else { // callable not given, store the input as is.
                    $inputs[] = $input;
                }
            } while (!$isValid && !empty($input) && $this->isOptional);
            // valid property given now continue

            if (!empty($input)) {
                // ask fore more
                $more = Char::prompt(
                    $moreMessage,
                    'yn',
                    true,
                    false,
                    false
                );
            }
        } while ($more == 'y' && !empty($input));

        return $this->lastResponse = $inputs;
    }
}
