<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    { 
        // Array of users for populate user table
        $arUsers = [
            [
                "firstName" => "AdminFirstName",
                "lastName" => "AdminLastName",
                "email" => "admin@gmail.com",
                "password" => "admin",
                "phoneNumber" => "0433221100",
                "roles" => [User::ROLE_ADMIN]
            ],
            [
                "firstName" => "Client1FirstName",
                "lastName" => "Client1LastName",
                "email" => "client_1@gmail.com",
                "password" => "client1",
                "phoneNumber" => "0444332211",
                "roles" => [User::ROLE_CLIENT, User::ROLE_CLIENT_EXTENDED]
            ],
            [
                "firstName" => "Client2FirstName",
                "lastName" => "Client2LastName",
                "email" => "client_2@gmail.com",
                "password" => "client2",
                "phoneNumber" => "0455443322",
                "roles" => [User::ROLE_CLIENT]
            ],
        ];

        // Array of company for populate company table
        $arCompanies = [
            [
                "name" => "Danone",
                "siren" => 552032534,
                "activityArea" => "Alimentaire",
                "Address" => "17 BD HAUSSMANN",
                "cp" => "75009",
                "city" => "PARIS",
                "country" => "France",
                "nic" => "00646",
                "userId" => 2,
            ],
            [
                "name" => "Mondelez",
                "siren" => 808234801,
                "activityArea" => "Commerce de gros",
                "Address" => "6 AV REAUMUR",
                "cp" => "92140",
                "city" => "CLAMART",
                "country" => "France",
                "nic" => "00013",
                "userId" => 3,
            ]
        ];
        // Create users
        foreach ($arUsers as $userData) {
            $user = new User(); 

            $user->setPlainTextPassword($userData['password'])
            ->setFirstName($userData['firstName'])
            ->setLastName($userData['lastName'])
            ->setEmail($userData['email'])
            ->setRoles($userData['roles'])
            ->setPhoneNumber($userData['phoneNumber']);

            $manager->persist($user);
            $manager->flush($user);
        }
        // Create companies
        foreach ($arCompanies as $key => $companyData) {
            $company = new Company();

            $company->setName($companyData['name'])
            ->setSiren($companyData['siren'])
            ->setActivityArea($companyData['activityArea'])
            ->setAddress($companyData['Address'])
            ->setCp($companyData['cp'])
            ->setCity($companyData['city'])
            ->setCountry($companyData['country'])
            ->setNic($companyData['nic']);
            $company->setUser($manager->getRepository(User::class)->find($key + 2));
            $manager->persist($company);
            $manager->flush($company);
        }
            $firstClient = new User();
            $secondClient = new User();
            $firstClient = $manager->getRepository(User::class)->find(2)->setCompany($manager->getRepository(Company::class)->find(1));
            $secondClient = $manager->getRepository(User::class)->find(3)->setCompany($manager->getRepository(Company::class)->find(2));
         

            $manager->persist($firstClient);
            $manager->flush($firstClient);
            $manager->persist($secondClient);
            $manager->flush($secondClient);


    }
}
