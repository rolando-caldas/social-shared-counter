<?php

namespace App\Application\Share\Query;

use App\Domain\Entity\Share\ShareRepository;
use App\Domain\ValueObject\ShareValue;

final class ShareListQueryHandler
{
    private $repository;

    public function __construct(ShareRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ShareListQuery $query) : array
    {

        if (empty($query->date())) {
            new \Exception('Query not valid');
        }

        $shares = $this->repository->getAll();
        $return = [];
        foreach ($shares AS $share) {

            $processed = [
                'id' => $share->id()->id(),
                'url' => $share->url()->url(),
                'socialNetwork' => [],
            ];

            $networks = $share->socialNetwork();
            foreach ($networks AS $network) {
                $processed['socialNetwork'][] = [
                    'name' => $network->name(),
                    'counter' => $network->counter()
                ];
            }

            $return[] = $processed;
        }

        return $return;
    }
}