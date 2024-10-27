<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use App\Entity\Season;
use App\Enum\MediaTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SerieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // First Serie with Seasons
        $serie1 = new Serie();
        $serie1->setName('Breaking Bad');
        $serie1->setMediaType(MediaTypeEnum::SERIE);
        $serie1->setShortDescription('A high school chemistry teacher turned methamphetamine producer.');
        $serie1->setLongDescription('Walter White, a struggling teacher, teams up with a former student to make and sell meth.');
        $serie1->setReleaseDate(new \DateTime('2008-01-20'));
        $serie1->setCoverImage('breaking_bad_cover.jpg');
        $serie1->setStaff(['Creator: Vince Gilligan', 'Executive Producer: Mark Johnson']);

        $manager->persist($serie1);

        // Second Serie with Seasons
        $serie2 = new Serie();
        $serie2->setName('Stranger Things');
        $serie2->setMediaType(MediaTypeEnum::SERIE);
        $serie2->setShortDescription('A group of kids uncover supernatural events in their small town.');
        $serie2->setLongDescription('In the 1980s, a group of kids discover a parallel dimension as they search for their missing friend.');
        $serie2->setReleaseDate(new \DateTime('2016-07-15'));
        $serie2->setCoverImage('stranger_things_cover.jpg');
        $serie2->setStaff(['Creators: The Duffer Brothers', 'Producer: Shawn Levy']);

        $manager->persist($serie2);

        // Flush all persisted objects to the database
        $manager->flush();
    }
}
