<?php
declare(strict_types=1);

namespace PhpLint\Linter;

use PhpLint\Ast\SourceContext;
use PhpLint\Configuration\Configuration;
use PhpLint\Rules\RuleLoader;
use PhpParser\Node;

class RuleProcessor
{
    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var RuleLoader
     */
    private $ruleLoader;

    /**
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
        $this->ruleLoader = new RuleLoader($config);
        $this->configureRules();
    }

    /**
     * Loads all rules defined in the configuration and configures them accordingly.
     */
    public function configureRules()
    {
        foreach ($this->config->getRules() as $ruleId => $ruleConfig) {
            $this->ruleLoader->loadRule($ruleId)->configure($ruleConfig);
        }
    }

    /**
     * @param Node $node
     * @param SourceContext $sourceContext
     * @param LintResult $lintResult
     */
    public function runRules(Node $node, SourceContext $sourceContext, LintResult $lintResult)
    {
        foreach ($this->config->getRules() as $ruleId => $ruleConfig) {
            $rule = $this->ruleLoader->loadRule($ruleId);
            if ($rule->canValidateNode($node)) {
                $rule->validate($node, $sourceContext, $lintResult);
            }
        }
    }
}
