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

/**
 *
 * @author Alessio
 */
class AccessRedirect {

    public const SEND_LOGIN         = 'login'; // Send to the login, if the login is publicy accessible
    public const SEND_MORE_AUTH     = 'more_auth'; // Seek a stronger authentication than the currently used, i.e. an api key can't, but a human user can
    public const SEND_REQUEST_GRANT = 'request_grant'; // Request a grant to someone who has grants right for X, might be a form

    public function __construct(private string $key, private string $target, private array $hints = []) {

    }

    public function key(): string {
        return $this->key;
    }

    public function target(): string {
        return $this->target;
    }

    public function hints(): array {
        return $this->hints;
    }

}
