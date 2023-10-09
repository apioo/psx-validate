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

use PSX\Validate\Filter\Alnum;
use PSX\Validate\Filter\ArrayFilter;
use PSX\Validate\Filter\Sha1;

/**
 * ArrayFilterTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ArrayFilterTest extends FilterTestCase
{
    public function testFilter()
    {
        $filter = new ArrayFilter(new Alnum());

        $this->assertEquals(true, $filter->apply(array('foo')));
        $this->assertEquals(false, $filter->apply(array('12 3')));
        $this->assertEquals(false, $filter->apply(array('foo', '12 3')));
        $this->assertEquals(false, $filter->apply('foo'));

        $filter = new ArrayFilter(new Sha1());

        $this->assertEquals(array('0beec7b5ea3f0fdbc95d0dd47f3c5bc275da8a33'), $filter->apply(array('foo')));

        // test error message
        $this->assertErrorMessage($filter->getErrorMessage());
    }
}
