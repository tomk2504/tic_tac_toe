<?php
declare(strict_types=1);

namespace App\Tests;

use App\Tests\Helper\TestHelper;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractBaseWebTestCase extends WebTestCase
{
    protected Generator $faker;
    protected KernelBrowser $client;
    protected EntityManagerInterface $entityManager;

    public function setUp(): void {
        $this->client = static::createClient();
        $this->entityManager = self::$container->get('doctrine')->getManager();
        $this->faker = Factory::create();
        $this->helper = new TestHelper(self::$container);

        parent::setUp();
    }
}