<?php
/**
* @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) Muhammad Mahad Azad <mahadazad@gmail.com>
*/

namespace ConsoleEx\Prompt;

use Zend\Console\Prompt\PromptInterface;

interface PromptCompositeInterface extends PromptInterface
{
    /**
     * @param string $promptText
     */
    public function setPromptText($promptText);

    /**
     * @return string
     */
    public function getPromptText();

    /**
     * @param  PromptInterface $prompt
     * @return PromptComposite returns $this
     */
    public function add(PromptInterface $prompt);

    /**
     * @param  PromptInterface $prompt
     * @return PromptComposite returns $this
     */
    public function remove(PromptInterface $prompt);

    /**
     * @return PromptInterface[]
     */
    public function getChildren();
}
