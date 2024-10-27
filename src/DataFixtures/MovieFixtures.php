<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Enum\MediaTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture // Updated class name here
{
    public function load(ObjectManager $manager): void
    {
        $movie1 = new Movie();
        $movie1->setName('The Shawshank Redemption');
        $movie1->setMediaType(MediaTypeEnum::MOVIE);
        $movie1->setShortDescription('Two imprisoned men bond over a number of years.');
        $movie1->setLongDescription('A banker is sentenced to life in Shawshank State Penitentiary for the murder of his wife and her lover, despite his claims of innocence.');
        $movie1->setReleaseDate(new \DateTime('1994-09-23'));
        $movie1->setCoverImage('shawshank_cover.jpg');
        $movie1->setStaff(['Director: Frank Darabont', 'Producer: Niki Marvin']);
        $movie1->setMCast(['Tim Robbins', 'Morgan Freeman']);

        $manager->persist($movie1);

        $movie2 = new Movie();
        $movie2->setName('Inception');
        $movie2->setMediaType(MediaTypeEnum::MOVIE);
        $movie2->setShortDescription('A thief who steals corporate secrets through dream-sharing technology.');
        $movie2->setLongDescription('Dom Cobb is a skilled thief, the best in the art of extraction. He steals valuable secrets from within the subconscious during the dream state.');
        $movie2->setReleaseDate(new \DateTime('2010-07-16'));
        $movie2->setCoverImage('inception_cover.jpg');
        $movie2->setStaff(['Director: Christopher Nolan', 'Producer: Emma Thomas']);
        $movie2->setMCast(['Leonardo DiCaprio', 'Joseph Gordon-Levitt']);

        $manager->persist($movie2);

        $manager->flush();
    }
}
