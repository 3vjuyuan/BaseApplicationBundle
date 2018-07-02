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

namespace Savwy\SuluBundle\BaseApplicationBundle\DataProcessor;

use Sulu\Bundle\MediaBundle\Api\Media;

class PageDataProcessor
{
    public function convertToJsonLdFormat($data, $schema = '', $mediaFields = [], $formats = []) {
        if(empty($schema)) {
            $schema = 'WebPage';
        }

        if (is_object($data)) {
            return json_encode($this->getSerializableData($data, $schema, $mediaFields, $formats), JSON_UNESCAPED_UNICODE);
        }

        $processedData = [];
        foreach ($data as $object) {
            $processedData[] = $this->getSerializableData($object, $schema, $mediaFields, $formats);
        }

        return json_encode($processedData, JSON_UNESCAPED_UNICODE);
    }

    protected function getSerializableData($object, $schema, $mediaFields, $formats)
    {
        $pageData = [
            'name' => $object['excerptTitle'],
            'description' => strip_tags($object['excerptDescription']),
            'inLanguage' => $object['locale'],
            'url' => $object['url']
        ];

        foreach ($mediaFields as $field => $fieldType) {
            if ($field === 'excerptImages' && strtolower($fieldType) === 'media' && !empty($object[$field])) {
                $images = $this->getMediaTypeFieldData($object[$field], $formats);
                $pageData['image'] = $images[0]['url'];
                $pageData['imageFormats'] = $images[0]['formats'];
            }
        }

        $categories = [];
        foreach ($object['excerptCategories'] as $category) {
            $categories[] = [
                'id' => $category['id'],
                'name' => $category['name']
            ];
        }

        $pageData['categories'] = $categories;

        return $this->formatToSchema($pageData, $schema);
    }

    protected function getMediaTypeFieldData($medias, $formats): array
    {
        if (is_object($medias)) {
            return $this->getMediaData($medias, $formats);
        }
        $mediasData = [];
        foreach ($medias as $media) {
            $mediasData[] = $this->getMediaData($media, $formats);
        }

        return $mediasData;
    }

    /**
     * @param Media $media
     * @param array $formats
     * @return array
     */
    protected function getMediaData(Media $media, $formats): array
    {
        $title = $media->getTitle();
        $description = $media->getDescription();

        return [
            'title' => $title,
            'description' => $description ? $description : $title,
            'url' => $media->getUrl(),
            'formats' => array_intersect_key($media->getFormats(), array_fill_keys($formats, ''))
        ];
    }

    protected function formatToSchema($data, $schemaName) {
        return array_merge([
            '@context' => 'http://schema.org',
            '@type' => $schemaName
        ], $data);
    }
}
