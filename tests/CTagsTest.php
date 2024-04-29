<?php

/*
 * Copyright 2021 alessioferri.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use PHPUnit\Framework\TestCase;
use function puffin\cms\ctags\{ctag,_ctag,ctag_open,ctag_close,ctag_define};

final class CTagsTest extends TestCase {

    public function testCTags(): void {

        ctag_define('atom', function($attrs = []) {
            echo "ATOM";
        });

        $atom = ctag('atom');

        $this->assertEquals( $atom, 'ATOM' );
    }

    public function testCTagsStack(): void {

        ctag_define('atom', function($attrs = []) {
            echo "ATOM";
        });

        ctag_define('comment', function($attrs = [], ?string $inner = '') {
            echo "<!--" . $inner . "-->" ;
        });

        ctag_open('comment');
        _ctag('atom');
        $result = ctag_close('comment');

        $this->assertEquals( $result, '<!--ATOM-->' );
    }

}
