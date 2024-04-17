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

namespace puffin\cms\pages;

use puffin\auth\Realm;
use puffin\auth\Login;

/**
 * Description of Pages
 *
 * @author Alessio
 */
abstract class PrivateArea implements Realm {

    private $pages;

    public function __construct(private string $name, private string $slug) {
        $this->pages = [];
    }

    public function name(): string {
        return $this->name;
    }

    public function slug(): string {
        return $this->slug;
    }

    public abstract function guarded_routes(): array;

    public function pages(): array {
        return $this->pages;
    }

    public function add_page(Page $page): void {
        $this->pages[] = $page;
    }

    public function is_permitted(Login $login, string $method, string $uri, array $params): bool {
        return in_array( $this->slug, $login->auth_realms() );
    }

}
