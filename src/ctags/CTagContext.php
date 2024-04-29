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

/**
 * Description of CTagContext
 *
 * @author Alessio
 */
class CTagContext {

    private $ns;
    private $defs;

    public function __construct(array $ns, array $defs) {
        $this->ns = $ns;
        $this->defs = $defs;
    }

    /**
     * find definition for a ctag name
     * @param string $name
     * @return type
     * @throws \RuntimeException
     */
    public function definition(string $name) {
        foreach ( $this->ns as $ns ) {
            $cname = $ns . '/' . $name;

            if ( isset( $this->defs[ $cname ] ) ) {
                return $this->defs[ $cname ];
            }
        }

        if ( isset( $this->defs[ $name ] ) ) {
            return $this->defs[ $name ];
        }

        throw new \RuntimeException( 'cannot find ctag named "' . $name . '"' );
    }
}
