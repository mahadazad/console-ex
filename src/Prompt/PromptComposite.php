<?php
/**
* @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) Muhammad Mahad Azad <mahadazad@gmail.com>
*/

namespace ConsoleEx\Prompt;

use Zend\Console\Prompt\AbstractPrompt;
use Zend\Console\Prompt\PromptInterface;

/**
 * Adds multiple prompts and acts like a single prompt
 */
class PromptComposite extends AbstractPrompt implements PromptCompositeInterface
{
    /**
     * @var array
     */
    protected $children = array();

    /**
     * @var string
     */
    protected $promptText;

    /**
     * @param null|string|PromptCompositeInterface|PromptCompositeInterface $option
     */
    public function __construct($option = null)
    {
        if (is_string($option)) {
            $this->setPromptText($option);
        } elseif ($option instanceof PromptComposite) {
            foreach ($option->getChildren() as $child) {
                $this->add($child);
            }
        } elseif ($option instanceof PromptInterface) {
            $this->add($option);
        }
    }

    /**
     * @param  PromptInterface $prompt
     * @return PromptComposite returns $this
     */
    public function add(PromptInterface $prompt)
    {
        $this->children[] = $prompt;

        return $this;
    }

    /**
     * @param  PromptInterface $prompt
     * @return PromptComposite returns $this
     */
    public function remove(PromptInterface $prompt)
    {
        foreach ($this->children as $i => $child) {
            if ($child === $prompt) {
                unset($this->children[$i]);
            }
        }

        return $this;
    }

    /**
     * @return PromptInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param string $promptText
     */
    public function setPromptText($promptText)
    {
        $this->promptText = $promptText;
    }

    /**
     * @return string
     */
    public function getPromptText()
    {
        return $this->promptText;
    }

    /**
     * @return string
     */
    public function show()
    {
        if ($this->promptText) {
            $this->getConsole()->writeLine($this->promptText);
        }

        $results = array();
        if ($this->children) {
            foreach ($this->children as $child) {
                $results[] = $child->show();
            }
        }

        return $this->lastResponse = $results;
    }
}
