<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Repositories\Tools;

class Metadata
{
    public function __invoke(array $allRules): array
    {
        $metadata = [];

        foreach ($allRules as $value => $rules) {
            $metadata[$value]['type'] = 'string';

            foreach (explode('|', $rules) as $rule) {
                switch ($rule) {
                case 'required':
                    $metadata[$value]['required'] = true;
                    break;
                case 'nullable':
                    $metadata[$value]['required'] = false;
                    break;
                case 'numeric':
                    $metadata[$value]['type'] = 'integer';
                    break;
                case 'boolean':
                    $metadata[$value]['type'] = 'boolean';
                    break;
                case 'email':
                    $metadata[$value]['content'] = 'email';
                    break;
                case 'array':
                    $metadata[$value]['type'] = 'array';
                    break;
                case $this->isRuleType($rule, 'in'):
                    $metadata[$value]['type'] = 'enum';
                    $metadata[$value]['values'] = $this->explodeEnums($this->takeValue($rule));
                    break;
                case $this->isRuleType($rule, 'max'):
                    $metadata[$value]['max'] = (int) $this->takeValue($rule);
                    break;
                case $this->isRuleType($rule, 'min'):
                    $metadata[$value]['min'] = (int) $this->takeValue($rule);
                    break;
                }
            }
        }

        return $metadata;
    }

    private function isRuleType(string $rule, string $type): bool
    {
        return 0 === mb_strpos($rule, $type);
    }

    private function takeValue(string $rule): string
    {
        return explode(':', $rule)[1];
    }

    private function explodeEnums(string $enums): array
    {
        return explode(',', $enums);
    }
}
