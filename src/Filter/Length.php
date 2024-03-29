<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Validate\Filter;

use PSX\Validate\FilterAbstract;

/**
 * Length
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Length extends FilterAbstract
{
    protected int|float $min;
    protected int|float|null $max;

    public function __construct(int|float $min, int|float|null $max = null)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * If $value is an integer or float the $min and $max value is meaned as
     * the current value. If it is a string it is meaned as the length of
     * $value. If its an array $min and $max relate to the array size.
     */
    public function apply(mixed $value): bool
    {
        if (is_int($value) || is_float($value)) {
            return $this->compare($value);
        } elseif (is_array($value)) {
            return $this->compare(count($value));
        } else {
            $value = (string) $value;

            return $this->compare(strlen($value));
        }
    }

    public function getErrorMessage(): ?string
    {
        if ($this->max === null) {
            return '%s has an invalid length max ' . $this->min . ' signs';
        } else {
            return '%s has an invalid length min ' . $this->min . ' and max ' . $this->max . ' signs';
        }
    }

    private function compare($len): bool
    {
        if ($this->max === null) {
            return $len <= $this->min;
        } else {
            return $len >= $this->min && $len <= $this->max;
        }
    }
}
