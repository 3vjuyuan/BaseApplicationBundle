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

namespace Savwy\SuluBundle\BaseApplicationBundle\Component\PHPCR;

use Overtrue\Pinyin\Pinyin;
use Sulu\Component\PHPCR\PathCleanup;

class ExtendedPathCleanup extends PathCleanup
{
    public function cleanup($dirty, $languageCode = null)
    {
        $convertedDirty = '';
        $pinyinSlugifier = new Pinyin();
        $connector = $dirty[0] === '/' ? '/' : '';
        foreach (explode('/', trim($dirty, '/')) as $part) {
            $convertedDirty = $convertedDirty . $connector . implode(' ', $pinyinSlugifier->convert($part));
            $connector = '/';
        }

        return parent::cleanup($convertedDirty, $languageCode);
    }
}
