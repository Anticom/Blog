<?php

namespace Anticom\ShowcaseBundle\DataFixtures\ORM;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\Comment;
use Anticom\ShowcaseBundle\Entity\User;
use DateTime;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class LoadSampleData implements FixtureInterface, ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        #region init
        /** @var EncoderFactoryInterface $factory */
        $factory = $this->container->get('security.encoder_factory');
        #endregion

        #region users
        $user1   = new User();
        $encoder = $factory->getEncoder($user1);
        $user1->setUsername('demo1');
        $user1->setEmail('demo1@example.com');
        $user1->setPassword(
            $encoder->encodePassword('demo1', $user1->getSalt())
        );
        $user1->setIsActive(true);

        $user2   = new User();
        $encoder = $factory->getEncoder($user2);
        $user2->setUsername('demo2');
        $user2->setEmail('demo2@example.com');
        $user2->setPassword(
            $encoder->encodePassword('demo2', $user2->getSalt())
        );
        $user2->setIsActive(true);
        #endregion

        #region blog entries
        $be1 = new BlogEntry();
        $be1->setAuthor($user1);
        $be1->setDateTimeCreated(new DateTime());
        $be1->setTitle('Demo Eintrag 1');
        $be1->setBody('Das ist der Body vom Demo Eintrag 1');

        $be2 = new BlogEntry();
        $be2->setAuthor($user2);
        $be2->setDateTimeCreated(new DateTime());
        $be2->setTitle('Demo Eintrag 2');
        $be2->setBody('Das ist der Body vom Demo Eintrag 2. Dieser hat auch <strong>fett gedruckten</strong> text.');
        #endregion

        #region comments
        $comment1 = new Comment();
        $comment1->setBlogEntry($be1);
        $comment1->setAuthor($user2);
        $comment1->setDateTimeCreated(new DateTime());
        $comment1->setBody('Comment 1');

        $comment1_1 = new Comment();
        $comment1_1->setBlogEntry($be1);
        $comment1_1->setAuthor($user1);
        $comment1_1->setDateTimeCreated(new DateTime());
        $comment1_1->setBody('Comment 1-1');
        $comment1_1->setParent($comment1);

        $comment2 = new Comment();
        $comment2->setBlogEntry($be1);
        $comment2->setAuthor($user2);
        $comment2->setDateTimeCreated(new DateTime());
        $comment2->setBody('Comment 2');

        $be1->addComment($comment1);
        $be1->addComment($comment2);
        #endregion

        #region orm
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($be1);
        $manager->persist($be2);
        $manager->persist($comment1);
        $manager->persist($comment1_1);
        $manager->persist($comment2);

        $manager->flush();
        #endregion
    }
} 