<?php

namespace App\Application\Share\Command;

use App\Application\CommandHandler;
use App\Domain\Entity\EntityIdFactory;
use App\Domain\Entity\Share\ShareRepository;

final class ShareRemoveCommandHandler extends CommandHandler
{
    private $repository;

    public function __construct(EntityIdFactory $entityIdFactory, ShareRepository $repository)
    {
        parent::__construct($entityIdFactory);
        $this->repository = $repository;
    }

    public function handle(ShareRemoveCommand $command)
    {
        $share = $this->repository->ofIdOrFail($this->entityIdFactory->shareFromString($command->uuid()));
        $this->repository->remove($share);
    }
}