<?php
namespace App\Services\Validation\Infrastructure\Services;

use App\Services\Validation\Domain\Services\RuleFormaterInterface;
use App\Services\Validation\Infrastructure\Services\Exceptions\InvalidValidateFormatException;
use Illuminate\Support\Facades\Log;

class RuleFormater implements RuleFormaterInterface
{

    /**
     * @param array $rule ['max:255', 'required']
     * @return array [{name:'max', rule:'max:255'}, {name:'required', rule:'required'}]
     */
    public function arrayFormater(array $rule): array
    {
        try {
            $data = [];

            foreach ($rule as $value) {
                if (is_callable($value)) {
                    continue;
                }
                if (strpos($value, ':') !== false) {
                    /** Это простейшая реализация, ри необходимости можно менять */
                    $data[] = ['name' => explode(':', $value)[0], 'rule' => $value];
                } else {
                    $data[] = ['name' => $value, 'rule' => $value];
                }
            }

            return $data;
        } catch (\Throwable $th) {
            Log::error('[Services][Validation][RuleFormater][arrayFormater] '.$th->getMessage().$th->getTraceAsString());
            throw new InvalidValidateFormatException();
        }
    }

    /**
     * @param string $rule 'max:255|required'
     * @return array [{name:'max', rule:'max:255'}, {name:'required', rule:'required'}]
     */
    public function stringFormater(string $rule): array
    {
        try {
            return $this->arrayFormater(explode('|', $rule));
        } catch (\Throwable $th) {
            Log::error('[Services][Validation][RuleFormater][stringFormater] '.$th->getMessage().$th->getTraceAsString());
            throw new InvalidValidateFormatException();
        }
    }
}
