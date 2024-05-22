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
 * Description of AccessDenied
 *
 * @author Alessio
 */
class AccessDenied implements AccessResponse {

    private $resource;
    private $scopes;
    private $meta;

    public function __construct(string $resource, array $scopes, array $meta = []) {
        $this->resource = $resource;
        $this->scopes   = $scopes;
        $this->meta     = $meta;
    }

    public function auth(): int {
        return AccessResponse::DENIED;
    }

    public function resource(): string {
        return $this->resource;
    }

    public function scopes(): array {
        return $this->scopes;
    }

    public function meta(): array {
        return $this->meta;
    }

    public function add_meta(string $key, mixed $value) {
        $this->meta[ $key ] = $value;
    }

}
