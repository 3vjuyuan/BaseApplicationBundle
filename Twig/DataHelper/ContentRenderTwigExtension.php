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

class ContentRenderTwigExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('savwy_data_render_bullet_list', [$this, 'renderBulletList']),
        ];
    }

    public function renderBulletList($content = '', $className = '') {
        $response = '';
        $className = trim($className) ? 'class="' . trim($className) . '"' : '';
        foreach (explode("\n", $content) as $item) {
            $item = trim($item);
            if($item) {
                $response .= '<li ' . $className . '>' . $item . '</li>';
            }
        }
        return $response;
    }
}
