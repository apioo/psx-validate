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

use PSX\Validate\FilterAbstract;
use PSX\Validate\FilterInterface;

/**
 * Collection
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Collection extends FilterAbstract
{
    /**
     * @var FilterInterface[]
     */
    private array $filters;

    /**
     * @param FilterInterface[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Returns true if all filters allow the value
     */
    public function apply(mixed $value): mixed
    {
        $modified = false;

        foreach ($this->filters as $filter) {
            $result = $filter->apply($value);

            if ($result === false) {
                return false;
            } elseif ($result === true) {
            } else {
                $modified = true;
                $value    = $result;
            }
        }

        return $modified ? $value : true;
    }

    public function getErrorMessage(): ?string
    {
        return '%s contains invalid values';
    }
}
