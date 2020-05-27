<?php

namespace App\DataFixtures;


use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class EmployeFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $employe = new Employe();
        $employe->setSecteur('Direction');
        $employe->setEmail('admin@deloitte.com');
        $employe->setNom('admin');
        $employe->setPrenom('admin');
        $employe->setRoles(['ROLE_TECHNICIEN']);
        $employe->setPhoto('images/avatar.png');


        $password = $this->encoder->encodePassword($employe, 'admin123@');
        $employe->setPassword($password);

        $manager->persist($employe);
        $manager->flush();


        $employe = new Employe();
        $employe->setSecteur('Technicien');
        $employe->setEmail('technicien@deloitte.com');
        $employe->setNom('technicien');
        $employe->setPrenom('technicien');
        $employe->setRoles(['ROLE_TECHNICIEN']);
        $employe->setPhoto('images/avatar.png');


        $password = $this->encoder->encodePassword($employe, 'technicien123@');
        $employe->setPassword($password);

        $manager->persist($employe);
        $manager->flush();



        $employe = new Employe();
        $employe->setSecteur('Secretaire');
        $employe->setEmail('secretaire@deloitte.com');
        $employe->setNom('secretaire');
        $employe->setPrenom('secretaire');
        $employe->setRoles(['ROLE_COMPTABILITE']);
        $employe->setPhoto('images/avatar.png');


        $password = $this->encoder->encodePassword($employe, 'secretaire123@');
        $employe->setPassword($password);

        $manager->persist($employe);
        $manager->flush();
    }
}
?>