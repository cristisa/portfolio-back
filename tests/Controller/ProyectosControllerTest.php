<?php

namespace App\Test\Controller;

use App\Entity\Proyectos;
use App\Repository\ProyectosRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProyectosControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProyectosRepository $repository;
    private string $path = '/proyectos/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Proyectos::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Proyecto index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'proyecto[nombre]' => 'Testing',
            'proyecto[descripcion]' => 'Testing',
            'proyecto[repositorio]' => 'Testing',
            'proyecto[imagen]' => 'Testing',
        ]);

        self::assertResponseRedirects('/proyectos/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Proyectos();
        $fixture->setNombre('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setRepositorio('My Title');
        $fixture->setImagen('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Proyecto');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Proyectos();
        $fixture->setNombre('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setRepositorio('My Title');
        $fixture->setImagen('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'proyecto[nombre]' => 'Something New',
            'proyecto[descripcion]' => 'Something New',
            'proyecto[repositorio]' => 'Something New',
            'proyecto[imagen]' => 'Something New',
        ]);

        self::assertResponseRedirects('/proyectos/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getDescripcion());
        self::assertSame('Something New', $fixture[0]->getRepositorio());
        self::assertSame('Something New', $fixture[0]->getImagen());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Proyectos();
        $fixture->setNombre('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setRepositorio('My Title');
        $fixture->setImagen('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/proyectos/');
    }
}
