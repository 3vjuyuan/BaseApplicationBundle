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

namespace Savwy\SuluBundle\BaseApplicationBundle\Twig;

use Sulu\Bundle\CategoryBundle\Category\CategoryManagerInterface;
use Sulu\Bundle\CategoryBundle\Entity\Category;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Component\Cache\MemoizeInterface;

class CategoryTreeTwigExtension extends \Twig_Extension
{
    /**
     * @var CategoryManagerInterface
     */
    protected $categoryManager;

    /**
     * @var MediaManagerInterface
     */
    protected $mediaManager;

    /**
     * @var MemoizeInterface
     */
    private $memoizeCache;

    public function __construct(
        CategoryManagerInterface $categoryManager,
        MediaManagerInterface $mediaManager,
        MemoizeInterface $memoizeCache
    )
    {
        $this->categoryManager = $categoryManager;
        $this->mediaManager = $mediaManager;
        $this->memoizeCache = $memoizeCache;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('savwy_data_category_tree', [$this, 'getCategoryTreeFunction']),
        ];
    }

    /**
     * Get the categories tree by the given key or id in specified depth.
     *
     * @param string|int $parent
     * @param int $depth The depth for the tree. if < 0, the full tree will be returned
     * @param bool $byKey
     * @return string|array
     */
    public function getCategoryTreeFunction($parent, int $depth = -1, bool $byKey = true, $locale = '')
    {
        return $this->memoizeCache->memoizeById(
            'savwy_category_tree_' . $parent . '_' . ($depth < 0 ? '' : $depth),
            func_get_args(),
            [$this, 'generateCategoryTree']
        );
    }

    public function generateCategoryTree($parent, int $depth = -1, bool $byKey = true, $locale = '') {
        $categories = $byKey ?
            $this->categoryManager->findChildrenByParentKey($parent) :
            $this->categoryManager->findChildrenByParentId($parent);

        $categoryTree = [];

        /** @var Category $category */
        foreach ($categories as $category) {
            $categoryTree[] = $this->getCategoryData($category, $depth - 1, $locale);
        }

        return $categoryTree;
    }

    protected function getCategoryData(Category $category, int $depth, $locale = '')
    {
        $categoryApiObj = $this->categoryManager->getApiObject($category, $locale);
        $categoryData = [
            'id' => $categoryApiObj->getId(),
            'key' => $categoryApiObj->getKey(),
            'name' => $categoryApiObj->getName(),
            'description' => $categoryApiObj->getDescription(),
            'medias' => $this->getCategoryMediasData($categoryApiObj->getMediasRawData(), $locale),
            'children' => []
        ];

        if ($depth) {
            /** @var Category $child */
            foreach ($category->getChildren() as $child) {
                $categoryData['children'][] = $this->getCategoryData($child, $depth - 1);
            }
        }

        return $categoryData;
    }

    protected function getCategoryMediasData(array $medias, string $locale)
    {
        $mediasData = [];
        /** @var Media $media */
        foreach ($this->mediaManager->getByIds($medias['ids'], $locale) as $media) {
            $mediasData[] = [
                'name' => $media->getName(),
                'url' => $media->getUrl(),
                'formats' => $media->getThumbnails(),
                'mimeType' => $media->getMimeType()
            ];
        }
        return $mediasData;
    }

}
