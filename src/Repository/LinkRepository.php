<?php

namespace App\Repository;

use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @method Link|null find($id, $lockMode = null, $lockVersion = null)
 * @method Link|null findOneBy(array $criteria, array $orderBy = null)
 * @method Link[]    findAll()
 * @method Link[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkRepository extends ServiceEntityRepository
{
    private $serializer;

    public function __construct(ManagerRegistry $registry, SerializerInterface $serializer)
    {
        parent::__construct($registry, Link::class);
        $this->serializer = $serializer;
    }

    public function fill(string $data): Link
    {
        return $this->serializer->deserialize($data, Link::class, 'json');
    }

    public function create(string $data): Link
    {
        $link = $this->fill($data);
        return $this->save($link);
    }

    public function save(Link $link): Link
    {
        $this->_em->persist($link);
        $this->_em->flush();
        return $link;
    }
}
