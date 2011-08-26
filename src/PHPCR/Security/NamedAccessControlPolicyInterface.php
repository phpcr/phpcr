<?php

/**
 * This file is part of the PHPCR API and was originally ported from the Java
 * JCR API to PHP by Karsten Dambekalns for the FLOW3 project.
 *
 * Copyright 2008-2011 Karsten Dambekalns <karsten@typo3.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License 2.0
 * @link http://phpcr.github.com/
*/

namespace PHPCR\Security;

/**
 * A NamedAccessControlPolicy is an opaque access control policy that is
 * described by a JCR name and optionally a description.
 *
 * NamedAccessControlPolicy are immutable and can therefore be directly applied
 * to a node without additional configuration step.
 *
 * @package phpcr
 * @subpackage interfaces
 * @api
 */
interface NamedAccessControlPolicyInterface extends \PHPCR\Security\AccessControlPolicyInterface
{
    /**
     * Returns the name of the access control policy, which is JCR name and
     * should be unique among the choices applicable to any particular node.
     *
     * @return string the name of the access control policy. A JCR name.
     *
     * @throws \PHPCR\RepositoryException - if an error occurs.
     *
     * @api
     */
    function getName();
}
