<?php

namespace App\Infrastructure\Domain\Entity\Share;

use App\Domain\Collection\ShareCollection;
use App\Domain\DomainEventPublisher;
use App\Domain\Entity\Share\ShareRepository;
use App\Domain\Entity\Share\ShareWasPersisted;
use App\Domain\Entity\Share\Share;
use App\Domain\Entity\Share\ShareId;
use App\Domain\ValueObject\Url;
use Doctrine\ORM\EntityRepository;

final class DoctrineShareRepository extends EntityRepository implements ShareRepository
{

    public function nextIdentity(): ShareId
    {
        return new ShareId();
    }

    public function getAll() : ShareCollection
    {
        return (new ShareCollection($this->findAll()));
    }

    public function ofIdOrFail(ShareId $shareId): Share
    {
        $share = $this->find(['id' => $shareId]);

        if ($share === null) {
            throw new \Exception('Share ' . $shareId . ' not found!');
        }

        return $share;
    }

    public function ofUrlOrFail(Url $url): Share
    {
        $share = $this->findOneBy(['url' => $url]);

        if ($share === null) {
            throw new \Exception('Not share for url ' . $url->url());
        }

        return $share;
    }


    public function add(Share $share): Share
    {
        $this->getEntityManager()->persist($share);
        $this->getEntityManager()->flush();

        DomainEventPublisher::instance()->publish(new ShareWasPersisted($share->id()));
        return $share;
    }

    public function update(Share $share): Share
    {
        return $this->add($share);
    }

    public function remove(Share $share): bool
    {
        $this->getEntityManager()->remove($share);
        $this->getEntityManager()->flush();

        return true;
    }

}