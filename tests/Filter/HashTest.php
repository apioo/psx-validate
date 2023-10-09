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

namespace PSX\Validate\Tests\Filter;

use PSX\Validate\Filter\Hash;

/**
 * HashTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class HashTest extends FilterTestCase
{
    public function testFilter()
    {
        $filter = new Hash();

        $this->assertEquals('0beec7b5ea3f0fdbc95d0dd47f3c5bc275da8a33', $filter->apply('foo'));

        $filter = new Hash('sha256');

        $this->assertEquals('2c26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae', $filter->apply('foo'));
    }

    public function testFilterUnknownHashAlgo()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Hash('foo');
    }
}
