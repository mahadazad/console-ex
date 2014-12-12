<?php
/**
* @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) Muhammad Mahad Azad <mahadazad@gmail.com>
*/

namespace ConsoleEx\Prompt;

use Zend\Console\Prompt\AbstractPrompt;
use Zend\Console\Prompt\PromptInterface;

/**
 * Callback function on provided prompt output
 */
class Callback extends AbstractPrompt
{
    /**
     * @var PromptInterface
     */
    protected $prompt;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param PromptInterface $prompt
     * @param callable        $callback
     */
    public function __construct(PromptInterface $prompt, callable $callback)
    {
        $this->prompt = $prompt;
        $this->callback = $callback;
    }

    /**
     * @return mix
     */
    public function show()
    {
        $data = $this->prompt->show();

        return call_user_func($this->callback, $data);
    }
}
