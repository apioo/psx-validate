<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * KeyExists
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class KeyExists extends FilterAbstract
{
    private $container;

    public function __construct(array $container)
    {
        $this->container = $container;
    }

    /**
     * Returns true if value is an key in the array $this->container else false
     *
     * @param mixed $value
     * @return boolean
     */
    public function apply($value)
    {
        $key = (string) $value;

        return isset($this->container[$key]);
    }

    public function getErrorMessage()
    {
        return '%s is not valid value';
    }
}
