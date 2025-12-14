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

namespace PSX\Validate;

use InvalidArgumentException;

/**
 * This class offers methods to sanitize values that came from untrusted
 * sources
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Validate
{
    public const TYPE_INTEGER = 'integer';
    public const TYPE_STRING  = 'string';
    public const TYPE_FLOAT   = 'float';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_ARRAY   = 'array';
    public const TYPE_OBJECT  = 'object';
    public const TYPE_ANY     = 'any';

    /**
     * Applies filter on the given value and returns the value on success or throws an exception if an error occurred
     */
    public function apply(mixed $value, string|DataType $type = DataType::STRING, array $filters = [], ?string $title = null, bool $required = true): mixed
    {
        $result = $this->validate($value, $type, $filters, $title, $required);

        if ($result->hasError()) {
            throw new ValidationException($result->getFirstError(), $title, $result);
        } elseif ($result->isSuccessful()) {
            return $result->getValue();
        }

        return null;
    }

    /**
     * Applies the $filter array containing PSX\Validate\FilterInterface on the $value. Returns a result object which
     * contains the value and error messages from the filter. If $required is set to true an error will be added if the
     * $value is null
     */
    public function validate(mixed $value, string|DataType $type = DataType::STRING, array $filters = [], ?string $title = null, bool $required = true): Result
    {
        if (is_string($type)) {
            $type = DataType::from($type);
        }

        $result = new Result();

        if ($title === null) {
            $title = 'Unknown';
        }

        if ($value === null) {
            if ($required === true) {
                $result->addError(sprintf('%s is not set', $title));

                return $result;
            } elseif ($required === false) {
                return $result;
            }
        } else {
            $value = $this->transformType($value, $type);
        }

        foreach ($filters as $filter) {
            $error = null;

            if ($filter instanceof FilterInterface) {
                $return = $filter->apply($value);
                $error  = $filter->getErrorMessage();
            } elseif (is_callable($filter)) {
                $return = call_user_func_array($filter, array($value));
            } else {
                throw new InvalidArgumentException('Filter must be either a callable or instanceof PSX\Validate\FilterInterface');
            }

            if ($return === false) {
                if ($error === null) {
                    $error = '%s is not valid';
                }

                $result->addError(sprintf($error, $title));

                return $result;
            } elseif ($return === true) {
                // the filter returns true so the validation was successful
            } else {
                $value = $return;
            }
        }

        $result->setValue($value);

        return $result;
    }

    private function transformType(mixed $value, DataType $type): mixed
    {
        return match ($type) {
            DataType::INTEGER => (int) $value,
            DataType::STRING => (string) $value,
            DataType::FLOAT => (float) $value,
            DataType::BOOLEAN => (bool) $value,
            DataType::ARRAY => (array) $value,
            DataType::OBJECT => (object) $value,
            default => $value,
        };
    }
}
