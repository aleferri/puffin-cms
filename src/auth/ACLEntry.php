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

use basin\attributes\MapSource;
use basin\attributes\MapPrimitive;

/**
 * Description of ACLEntry
 *
 * @author Alessio
 */
#[MapSource(context: 'sql', source: 'sec_acl_entries', settings: [])]
class ACLEntry {

    public function __construct(
        #[MapPrimitive(context: 'sql', kind: 'text', settings: [])]
        private $resource = '*',
        #[MapPrimitive(context: 'sql', kind: 'text', settings: [])]
        private $applicant = '*',
        #[MapPrimitive(context: 'sql', kind: 'text', settings: [])]
        private $grant = '*',
        #[MapPrimitive(context: 'sql', kind: 'int', settings: [])]
        private $policy = 0,
        #[MapPrimitive(context: 'sql', kind: 'int', settings: [])]
        private $priority = 100,
        #[MapPrimitive(context: 'sql', kind: 'datetime', settings: [])]
        private $created_at = new \DateTimeImmutable(),
        #[MapPrimitive(context: 'sql', kind: 'datetime', settings: [])]
        private $updated_at = new \DateTimeImmutable(),
    ) {

    }

    public function resource(): string {
        return $this->resource;
    }

    public function applicant(): string {
        return $this->applicant;
    }

    public function grant(): string {
        return $this->grant;
    }

    public function policy(): int {
        return $this->policy;
    }

    public function priority(): int {
        return $this->priority;
    }

    public function created_at(): \DateTimeImmutable {
        return $this->created_at;
    }

    public function updated_at(): \DateTimeImmutable {
        return $this->updated_at;
    }

}
