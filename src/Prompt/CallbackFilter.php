<?php
/**
* @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) Muhammad Mahad Azad <mahadazad@gmail.com>
*/

namespace ConsoleEx\Prompt;

use Zend\Console\Prompt\AbstractPrompt;
use Zend\Console\Prompt\PromptInterface;

/**
 * Filters the data with callback
 */
class CallbackFilter extends AbstractPrompt
{
    /**
     * @var PromptInterface
     */
    protected $prompt;

    /**
     * @var callable
     */
    protected $filter;

    /**
     * @param PromptInterface $prompt
     * @param callable        $filter
     */
    public function __construct(PromptInterface $prompt, callable $filter)
    {
        $this->prompt = $prompt;
        $this->filter = $filter;
    }

    /**
     * @return mix
     */
    public function show()
    {
        $data = $this->prompt->show();

        return call_user_func($this->filter, $data);
    }
}
