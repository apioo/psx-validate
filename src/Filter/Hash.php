<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

use InvalidArgumentException;
use PSX\Validate\FilterAbstract;

/**
 * Hash
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Hash extends FilterAbstract
{
    private string $algo;

    public function __construct(string $algo = 'sha1')
    {
        if (in_array($algo, hash_algos())) {
            $this->algo = $algo;
        } else {
            throw new InvalidArgumentException('Unsupported hash algorithm');
        }
    }

    /**
     * Returns a representation of $value depending on the selected algorithm
     */
    public function apply(mixed $value): string|bool
    {
        return hash($this->algo, (string) $value);
    }
}
