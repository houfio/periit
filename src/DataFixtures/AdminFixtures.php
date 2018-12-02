<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\ContactPerson;
use App\Entity\Excursion;
use App\Entity\Level;
use App\Entity\Material;
use App\Entity\Method;
use App\Entity\School;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    private $slugger;

    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $mbo = (new Level())
            ->setName('MBO')
            ->setSlug($this->slugger->slugify('MBO'));
        $manager->persist($mbo);

        $hbo = (new Level())
            ->setName('HBO')
            ->setSlug($this->slugger->slugify('HBO'));
        $manager->persist($hbo);

        $lastMbo = null;
        for ($i = 0; $i < 25; $i++) {
            $name = "Summa College $i";
            $lastMbo = (new School())
                ->setName($name)
                ->setSlug($this->slugger->slugify($name))
                ->addLevel($mbo);
            $manager->persist($lastMbo);
        }

        $lastHbo = null;
        for ($i = 0; $i < 50; $i++) {
            $name = "Fontys Hogeschool $i";
            $lastHbo = (new School())
                ->setName($name)
                ->setSlug($this->slugger->slugify($name))
                ->addLevel($mbo)
                ->addLevel($hbo);
            $manager->persist($lastHbo);
        }

        $programming = (new Method())
            ->setName('Programmeren')
            ->setSlug($this->slugger->slugify('Programmeren'));
        $manager->persist($programming);

        $designing = (new Method())
            ->setName('Designen')
            ->setSlug($this->slugger->slugify('Designen'));
        $manager->persist($designing);

        $computer = (new Material())
            ->setName('Computer')
            ->setSlug($this->slugger->slugify('Computer'));
        $manager->persist($computer);

        $whiteboard = (new Material())
            ->setName('Whiteboard')
            ->setSlug($this->slugger->slugify('Whiteboard'));
        $manager->persist($whiteboard);

        $monitor = (new Material())
            ->setName('Beeldscherm')
            ->setSlug($this->slugger->slugify('Beeldscherm'));
        $manager->persist($monitor);

        $clock = (new Material())
            ->setName('Klok')
            ->setSlug($this->slugger->slugify('Klok'));
        $manager->persist($clock);

        $lastMboCompany = null;
        $lastHboCompany = null;
        for ($i = 0; $i < 100; $i++) {
            $name = "Entec Media $i";
            $company = (new Company())
                ->setName($name)
                ->addLevel($hbo)
                ->addMethod($programming)
                ->addMaterial($computer)
                ->setSlug($this->slugger->slugify($name))
                ->setAddress('Hoogheem 396')
                ->setZipCode('5283BG')
                ->setCity('Boxtel')
                ->setWebsite('http://entecmedia.weebly.com')
                ->setDescription('De onderneming Entec Media is gevestigd op Hoogheem 396 te Boxtel en is actief in de branche Ontwikkelen, produceren en uitgeven van software. Het bedrijf is bij de kamer van koophandel geregistreerd onder kvk nummer 65621794 en is gelegen in Boxtel-Oost in de gemeente Boxtel. Bij Entec Media is 1 persoon werkzaam.');

            if ($i % 2 === 0) {
                $lastMboCompany = $company;
                $company->addLevel($mbo);
                $company->addMaterial($whiteboard);
            }

            if ($i % 3 === 0) {
                $lastHboCompany = $company;
                $company->addMethod($designing);
                $company->addMaterial($monitor);
            }

            if ($i % 4 === 0) {
                $company->addMaterial($clock);
            }

            $manager->persist($company);

            for ($j = 0; $j < 1 + $i % 5; $j++) {
                $contactPerson = (new ContactPerson())
                    ->setCompany($company)
                    ->setEmail("vidal$i$j@gmail.com")
                    ->setFirstName('Vidal')
                    ->setLastName('Spierings')
                    ->setTelephone('0642638585')
                    ->setTelephonePrivate('0642638585')
                    ->setFunction('CEO');
                $manager->persist($contactPerson);
            }
        }

        $excursion = (new Excursion())
            ->setCompany($lastMboCompany)
            ->setSchool($lastMbo)
            ->setVisitorCount(69)
            ->setDate(1543769580);
        $manager->persist($excursion);

        $excursion = (new Excursion())
            ->setCompany($lastHboCompany)
            ->setSchool($lastHbo)
            ->setVisitorCount(70)
            ->setDate(1513720000);
        $manager->persist($excursion);

        $manager->flush();
    }
}
