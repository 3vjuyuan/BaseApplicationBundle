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

namespace Savwy\SuluBundle\BaseApplicationBundle\Twig\DataHelper;

use Savwy\SuluBundle\BaseApplicationBundle\DataProcessor\ContactDataProcessor;
use Savwy\SuluBundle\BaseApplicationBundle\DataProcessor\PageDataProcessor;
use Savwy\SuluBundle\BaseApplicationBundle\DataProcessor\TextMediaDataProcessor;
//use Zend\Hydrator\Reflection as ReflectionHydrator;

class JsonConverterTwigExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('savwy_data_convert_json', [$this, 'convertJsonFunction']),
        ];
    }

    //@todo According to the content type and schema type to convert to json schema

    /**
     * @param $input The input data
     * @param string $schema The schema name
     * @param string $contentType The content type
     * @param array $params The additional parameters
     * @return string
     */
    public function convertJsonFunction($input, $schema = '', $contentType = '', ...$params)
    {
        if(!is_object($input) && !is_array($input) ) {
            return $input;
        }

        if(strlen(trim($schema)) + strlen(trim($contentType)) === 0) {
            return json_encode($input, JSON_UNESCAPED_UNICODE);
        }

        // @todo support all content type
        switch ($contentType) {
            case 'Contact':
                return (new ContactDataProcessor())->convertToJsonLdFormat($input);
            case 'TextMedia':
                $dataProcessor = new TextMediaDataProcessor();
                return call_user_func_array([$dataProcessor, 'convertToJSON'], array_merge([$input], $params));
            case 'Page':
                $dataProcessor = new PageDataProcessor();
                return call_user_func_array([$dataProcessor, 'convertToJsonLdFormat'], array_merge([$input, $schema], $params));
        }

        // Make sure the input data is an array
//        $originalData = (array) $input;
//        $hydrator = new ReflectionHydrator();
//        $obj = $hydrator->hydrate(
//            $originalData[0],
//            (new \ReflectionClass(TextMedia::class))->newInstanceWithoutConstructor()
//        );
//
//        return json_encode($input, JSON_UNESCAPED_UNICODE);
    }

    protected function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
