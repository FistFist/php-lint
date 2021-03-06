<?php
declare(strict_types=1);

namespace PhpLint\Plugin;

use PhpLint\Configuration\Configuration;
use PhpLint\Rules\Rule;

/**
 * Extends this class in a class named 'Rules' in the namespace PhpLint\Plugin\<VENDOR>\<NAME>, e.g.:
 *
 *  namespace PhpLint\Plugin\Acme\MyPlugin;
 *
 *  class Rules extends PhpLint\Plugin\AbstractRulesPlugin {}
 */
abstract class AbstractRulesPlugin implements RulesPlugin
{
    /**
     * @inheritdoc
     */
    abstract public function getName(): string;

    /**
     * @inheritdoc
     */
    abstract public function getPlugins(): array;

    /**
     * @inheritdoc
     */
    abstract public function hasRule(string $ruleId): bool;

    /**
     * @inheritdoc
     */
    abstract public function loadRule(string $ruleId): Rule;

    /**
     * @inheritdoc
     */
    public function getDependencies(): array
    {
        return $this->getPlugins();
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            Configuration::KEY_PLUGINS => $this->getPlugins(),
        ];
    }
}
