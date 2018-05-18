<?php
/**
 * Copyright (c) 2014-present, San Wei Ju Yuan Tech Ltd. <https://www.3vjuyuan.com>
 * This file is part of fangjialaw.com
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

namespace Savwy\SuluBundle\BaseApplicationBundle\DataProcessor;

use Savwy\SuluBundle\BaseApplicationBundle\Content\Schemas\PersonSchema;

class ContactDataProcessor
{
    const JSON_LD_SCHEMA = 'Person';

    public function convertToJsonLdFormat($contacts) {
        $contactsJSONData = [];
        foreach ($contacts as $contact) {
            $contactsJSONData[] = (new PersonSchema())
                ->setFamilyName((string) $contact['lastName'])
                ->setGivenName((string) $contact['firstName'])
                ->setAdditionalName((string) $contact['middleName'])
                ->setEmail(count($contact['emails']) ? reset($contact['emails'])['email'] : '')
                ->setJobTitle(is_null($contact['position']) ? '' : $contact['position']['position'])
                ->setName($contact['lastName'].$contact['firstName'])
                ->setDescription(count($contact['notes']) ? reset($contact['notes'])['value'] : '');
        }

        return json_encode($contactsJSONData, JSON_UNESCAPED_UNICODE);
    }
}
