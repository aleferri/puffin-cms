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

namespace puffin\cms\auth;

use puffin\auth\Grant;

/**
 * Description of ACL
 *
 * @author Alessio
 */
class ACL {

    public function __construct(private $entries = [], private $is_sorted = false, private $resource = '*') {

    }

    public function add_entry(ACLEntry $entry): self {
        $this->entries[] = $entry;
    }

    public function compute_policy(string $resource, string $applicant, Grant $grant): Policy|false {
        if ( $this->resource !== '*' && $this->resource !== $resource ) {
            return false;
        }

        foreach ( $this->entries as $entry ) {

        }
    }

}
