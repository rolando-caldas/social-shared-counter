<?php

namespace App\Application\Share\Query;

use App\Domain\Entity\EntityIdFactory;
use App\Domain\Entity\Share\ShareRepository;

final class ShareInfoQueryHandler
{
    private $entityIdFactory;
    private $repository;

    public function __construct(EntityIdFactory $entityIdFactory, ShareRepository $repository)
    {
        $this->entityIdFactory = $entityIdFactory;
        $this->repository = $repository;
    }

    public function handle(ShareInfoQuery $query)
    {
        $share = $this->repository->ofIdOrFail($this->entityIdFactory->shareFromString($query->id()));

        $networks = $share->socialNetwork();
        $socialNetworks = [];
        foreach ($networks AS $network) {
            $socialNetworks[] = [
                'name' => $network->name(),
                'counter' => $network->counter()
            ];
        }

        return [
            'id' => $share->id()->id(),
            'url' => $share->url()->url(),
            'socialNetwork' => $socialNetworks
        ];


    }
}