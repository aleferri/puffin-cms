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

use puffin\auth\Login;

/**
 *
 * @author Alessio
 */
interface AccessService {

    public const REMEDY_LOGIN          = 'login';
    public const REMEDY_STRONGER_AUTH  = 'inc_auth';
    public const REMEDY_REQUEST_ACCESS = 'req_access';

    /**
     *
     * @param string $resource resource identification, like users/1 or pages/3, etc
     * @param array|string $scopes scopes as a map, like [ 'view' => [ 'public fields' ], 'edit' => [ 'name' ] ]
     * @param Login $by client of the request, note that a user may be authorized, but a stronger auth is required
     * @return AccessResponse either AccessAllowed or AccessDenied
     */
    public function submit_request_for(string $resource, array|string $scopes, Login $by): AccessResponse;

    /**
     *
     * @param AccessDenied $denied
     * @return array
     */
    public function redirect_targets(AccessDenied $denied): array;

}
