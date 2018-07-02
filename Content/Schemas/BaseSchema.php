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

/**
 * Class BaseSchema
 * @package Savwy\SuluBundle\BaseApplicationBundle\Content\Schemas
 *
 * @todo Add support to additional properties
 */
class BaseSchema implements \JsonSerializable
{
    const CONTEXT = 'http://schema.org';
    const TYPE = 'context';

    protected $identifier = '';

    protected $name = '';

    protected $description = '';

    protected $image = '';

    protected $url = '';

    protected $_additionalProperties = [];

    public function __set($name, $value)
    {
        $this->_additionalProperties[$name] = $value;
        return $this;
    }

    /**
     * @param string $identifier
     * @return BaseSchema
     */
    public function setIdentifier(string $identifier): BaseSchema
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @param string $name
     * @return BaseSchema
     */
    public function setName(string $name): BaseSchema
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $description
     * @return BaseSchema
     */
    public function setDescription(string $description): BaseSchema
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $image
     * @return BaseSchema
     */
    public function setImage(string $image): BaseSchema
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param string $url
     * @return BaseSchema
     */
    public function setUrl(string $url): BaseSchema
    {
        $this->url = $url;
        return $this;
    }

    public function jsonSerialize()
    {
        return array_merge(
            [
                '@context' => static::CONTEXT,
                '@type' => static::TYPE
            ],
            get_object_vars($this),
            $this->_additionalProperties);
    }
}
