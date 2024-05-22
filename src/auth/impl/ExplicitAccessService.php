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

namespace puffin\cms\auth\impl;

use puffin\auth\Login;
use puffin\cms\auth\{
    AccessService,
    AccessResponse,
    AccessAllowed,
    AccessDenied
};

/**
 * Description of ExplicitAccessService
 *
 * @author Alessio
 */
class ExplicitAccessService implements AccessService {

    private $entries;

    public function __construct() {
        $this->entries = [];
    }

    public function add_entry(ACLEntry $entry): void {
        $this->entries[] = $entry;
    }

    public function submit_request_for(string $resource, array|string $scopes, Login $by): AccessResponse {
        $leftovers = $scopes;

        $entries = $this->filter_entries( $resource, $by );

        // TODO add expand "MACROS" round, like "public_fields", "private_fields" to the real list
        foreach ( $entries as $entry ) {
            $result = $this->apply_rule( $resource, $leftovers, $entry );

            if ( ! is_array( $result ) ) {
                $result->add_meta( 'realms', $by->auth_realms() );
                $result->add_meta( 'grants', $by->grants() );
                return $result;
            }

            $leftovers = $result;
        }

        if ( count( $leftovers ) > 0 ) {
            return new AccessDenied( $resource, $scopes, [ 'unresolved' => $leftovers ] );
        }

        return new AccessAllowed( $resource, $scopes );
    }

    public function redirect_targets(AccessDenied $denied): array {
        $meta = $denied->meta();

        if ( isset( $meta[ 'unresolved' ] ) ) {
            return [];
        }

        if ( isset( $meta[ 'denied_by' ] ) ) {
            // TODO look for a public knowledge realm to login to
            // TODO look for a obtainable grant
        }
    }

    private function apply_rule(string $resource, array $scopes, ACLEntry $entry): array|object {
        $leftovers    = $scopes;
        $entry_scopes = $entry->scopes();

        foreach ( $scopes as $scope => $queued_fields ) {
            if ( ! isset( $entry_scopes[ $scope ] ) ) {
                continue;
            }

            $fields = array_intersect( $entry_scopes[ $scope ], $queued_fields );
            if ( count( $fields ) === 0 ) {
                continue;
            }

            if ( $entry->policy() === AccessResponse::DENIED ) {
                return new AccessDenied( $resource, [ $scope => $fields ], [ 'denied_by' => $entry->id() ] );
            }

            if ( $entry->policy() === AccessResponse::ALLOWED ) {
                $leftovers_fields = array_diff( $queued_fields, $fields );
                if ( count( $leftovers_fields ) > 0 ) {
                    $leftovers[ $scope ] = $leftovers_fields;
                }
            }
        }

        return $leftovers;
    }

    private function filter_entries(string $resource, Login $applicant): array {
        $filtered = [];

        foreach ( $this->entries as $entry ) {
            if ( $entry->resource() !== $resource && $entry->resource() !== '*' ) {
                if ( ! str_ends_with( $entry->resource(), '*' ) ) {
                    continue;
                }
                $partial = substr( $entry->resource(), 0, -1 );
                if ( ! str_starts_with( $resource, $partial ) ) {
                    continue;
                }
            }

            if ( ! empty( $entry->applicant() ) && $applicant->acting_self() !== $entry->applicant() ) {
                continue;
            }

            if ( ! empty( $entry->realm() ) && ! in_array( $entry->realm(), $applicant->auth_realms() ) ) {
                continue;
            }

            if ( ! empty( $entry->grant() ) && ! in_array( $entry->grant(), $applicant->grants() ) ) {
                continue;
            }

            $filtered[] = $entry;
        }

        return $filtered;
    }

}
