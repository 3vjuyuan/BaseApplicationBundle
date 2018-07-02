<?php
/**
 * Copyright (c) 2014-present, San Wei Ju Yuan Tech Ltd. <https://www.3vjuyuan.com>
 * This file is part of BaseApplicationBundle
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 *
 * For more details:
 * https://www.3vjuyuan.com/licenses.html
 *
 * @author Team Delta <delta@3vjuyuan.com>
 */

namespace Savwy\SuluBundle\BaseApplicationBundle\Content\Schemas;


class PersonSchema extends BaseSchema
{
    const TYPE = 'Person';

    protected $familyName= '';

    protected $givenName = '';

    protected $additionalName = '';

    protected $jobTitle = '';

    protected $email = '';

    protected $telephone = '';

    /**
     * @param string $familyName
     * @return PersonSchema
     */
    public function setFamilyName(string $familyName): PersonSchema
    {
        $this->familyName = $familyName;
        return $this;
    }

    /**
     * @param string $givenName
     * @return PersonSchema
     */
    public function setGivenName(string $givenName): PersonSchema
    {
        $this->givenName = $givenName;
        return $this;
    }

    /**
     * @param string $additionalName
     * @return PersonSchema
     */
    public function setAdditionalName(string $additionalName): PersonSchema
    {
        $this->additionalName = $additionalName;
        return $this;
    }

    /**
     * @param string $jobTitle
     * @return PersonSchema
     */
    public function setJobTitle(string $jobTitle): PersonSchema
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    /**
     * @param string $email
     * @return PersonSchema
     */
    public function setEmail(string $email): PersonSchema
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $telephone
     * @return PersonSchema
     */
    public function setTelephone(string $telephone): PersonSchema
    {
        $this->telephone = $telephone;
        return $this;
    }
}
