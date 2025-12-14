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

/**
 * Result
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Result
{
    public function __construct(private mixed $value = null, private array $errors = [])
    {
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
    
    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getInt(): int
    {
        return (int) $this->value;
    }

    public function getString(): string
    {
        return (string) $this->value;
    }

    public function getFloat(): float
    {
        return (float) $this->value;
    }

    public function getBoolean(): bool
    {
        return (bool) $this->value;
    }

    public function getArray(): array
    {
        return (array) $this->value;
    }

    public function getObject(): object
    {
        return (object) $this->value;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    public function getFirstError(): ?string
    {
        return $this->errors[0] ?? null;
    }

    public function isSuccessful(): bool
    {
        return count($this->errors) == 0;
    }

    public function hasError(): bool
    {
        return count($this->errors) > 0;
    }

    public function __toString()
    {
        return implode(', ', $this->errors);
    }
}
