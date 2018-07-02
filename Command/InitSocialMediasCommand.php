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

namespace Savwy\SuluBundle\BaseApplicationBundle\Command;

use Doctrine\ORM\EntityManager;
use Sulu\Bundle\ContactBundle\Entity\SocialMediaProfileType;
use Sulu\Bundle\ContactBundle\Entity\SocialMediaProfileTypeRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Initialize and insert the preconfigured social media profile types into database
 *
 * Class InitSocialMediasCommand
 * @package Savwy\SuluBundle\BaseApplicationBundle\Command
 */
class InitSocialMediasCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('baseApp:initSocialMedias')
            ->setDescription('Initialize the supported social media types.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $configuredProfileTypes = $container->getParameter('base_application.social_media_profile_types');

        /** @var EntityManager $entityManager */
        $entityManager = $container->get('doctrine.orm.entity_manager');

        /** @var SocialMediaProfileTypeRepository $profileTypesRepository */
        $profileTypesRepository = $entityManager->getRepository('SuluContactBundle:SocialMediaProfileType');

        array_map(function (SocialMediaProfileType $profileType) use (&$configuredProfileTypes){
            $profileTypeName = strtolower($profileType->getName());
            foreach ($configuredProfileTypes as $key => $configuredProfileType) {
                if(strtolower($configuredProfileType) === $profileTypeName) {
                    unset($configuredProfileTypes[$key]);
                    break;
                }
            }
        }, $profileTypesRepository->findAll());

        foreach ($configuredProfileTypes as $profileTypeName) {
            $profileType = new SocialMediaProfileType();
            $profileType->setName($profileTypeName);
            $entityManager->persist($profileType);
            $entityManager->flush();
        }

        if(count($configuredProfileTypes)) {
            $output->writeLn('Social media profile types: ' . implode(', ', $configuredProfileTypes) . ' are inserted into database');
        }
    }
}
