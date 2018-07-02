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

class TextMediaDataProcessor
{
    public function convertToJSON($data, $mediaFields = [], $formats = [])
    {
        if (is_object($data)) {
            return json_encode($this->getSerializableData($data, $mediaFields, $formats), JSON_UNESCAPED_UNICODE);
        }

        $processedData = [];
        foreach ($data as $object) {
            $processedData[] = $this->getSerializableData($object, $mediaFields, $formats);
        }

        return json_encode($processedData, JSON_UNESCAPED_UNICODE);
    }

    protected function getSerializableData($object, $mediaFields, $formats)
    {
        foreach ($mediaFields as $field => $fieldType) {
            if (strtolower($fieldType) === 'media' && !empty($object[$field])) {
                $object[$field] = $this->getMediaTypeFieldData($object[$field], $formats);
            }
        }

        return $object;
    }

    protected function getMediaTypeFieldData($medias, $formats): array
    {
        if (is_object($medias)) {
            return $this->getMediaTypeFieldData($medias, $formats);
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
}
