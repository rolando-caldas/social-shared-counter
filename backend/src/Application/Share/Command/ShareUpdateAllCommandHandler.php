<?php

namespace App\Application\Share\Command;

use App\Application\CommandHandler;
use App\Domain\Entity\EntityIdFactory;
use App\Domain\Entity\Share\ShareRepository;

final class ShareUpdateAllCommandHandler extends CommandHandler
{
    private $repository;

    public function __construct(EntityIdFactory $entityIdFactory, ShareRepository $repository)
    {
        parent::__construct($entityIdFactory);
        $this->repository = $repository;
    }

    public function handle(ShareUpdateAllCommand $command)
    {
        if (empty($command->date())) {
            new \Exception('Command not valid');
        }

        $shares = $this->repository->getAll();

        foreach ($shares AS $share) {
            $share->updateCounter();
        }

        $this->repository->update($share);
    }
}