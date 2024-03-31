<?php

/*
 * Copyright 2024 Alessio.
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

namespace puffin\cms\search;

use basin\attributes\MapSource;
use basin\attributes\MapPrimitive;

/**
 * Description of IndexEntry
 *
 * @author Alessio
 */
#[MapSource(context: 'sql', source: 'idx_index', settings: [])]
class IndexEntry {

    public function __construct(
        #[MapPrimitive(context: 'sql', kind: 'text', settings: [])]
        private $scope,
        #[MapPrimitive(context: 'sql', kind: 'text', settings: [])]
        private $key,
        #[MapPrimitive(context: 'sql', kind: 'text', settings: [])]
        private $value,
        #[MapPrimitive(context: 'sql', kind: 'text', settings: [])]
        private $uri,
    ) {

    }

    public function scope(): string {
        return $this->scope;
    }

    public function key(): string {
        return $this->key;
    }

    public function value(): string {
        return $this->value;
    }

    public function uri(): string {
        return $this->uri;
    }

}
