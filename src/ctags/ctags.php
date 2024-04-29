<?php

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

namespace puffin\cms\ctags;

global $ctags_definitions;
$ctags_definitions = [];

function ensure_valid_ctag(string $name): callable {
    global $ctags_definitions;

    if ( !isset( $ctags_definitions[ $name ] ) ) {
        throw new \RuntimeException( 'cannot find ctag named "' . $name . '"' );
    }

    return $ctags_definitions[ $name ];
}

function ctag_define(string $name, callable $resolver) {
    global $ctags_definitions;

    $ctags_definitions[ $name ] = $resolver;
}

global $ctags_stack;
$ctags_stack = [];

function push_entry(string $name, array $attrs, callable $resolver): void {
    global $ctags_stack;

    $ctags_stack[] = [ 'name' => $name, 'attrs' => $attrs, 'resolver' => $resolver ];
}

function pop_entry() {
    global $ctags_stack;

    if ( empty( $ctags_stack ) ) {
        throw new \RuntimeException( 'empty ctags instances stack' );
    }

    return array_pop( $ctags_stack );
}

function ctag(string $name, array $attrs = []): string {
    $resolver = ensure_valid_ctag( $name );

    ob_start();
    $resolver( $attrs );
    $contents = ob_get_contents();
    ob_end_clean();

    return $contents;
}

function ctag_open(string $name, array $attrs = []): void {
    $resolver = ensure_valid_ctag( $name );

    push_entry( $name, $attrs, $resolver );

    ob_start();
}

function ctag_close(string $name): string {
    $entry = pop_entry();

    if ( $entry[ 'name' ] != $name ) {
        throw new \RuntimeException( 'unexpected name "' . $name . '"' );
    }

    $resolver = $entry[ 'resolver' ];
    $attrs = $entry[ 'attrs' ];

    $inner = ob_get_contents();
    ob_end_clean();

    ob_start();
    $resolver( $attrs, $inner );
    $contents = ob_get_contents();
    ob_end_clean();

    return $contents;
}

function _ctag(string $name, array $attrs = []): void {
    $resolver = ensure_valid_ctag( $name );

    $resolver( $attrs );
}

function _ctag_close(string $name): void {
    $entry = pop_entry();

    if ( $entry[ 'name' ] != $name ) {
        throw new \RuntimeException( 'unexpected name "' . $name . '"' );
    }

    $resolver = $entry[ 'resolver' ];
    $attrs = $entry[ 'attrs' ];

    $inner = ob_get_contents();
    ob_end_clean();

    $resolver( $attrs, $inner );
}
