<?php

namespace App\Application\Share\Command;

use App\Application\CommandHandler;
use App\Application\SocialNetworkService;
use App\Domain\Entity\EntityIdFactory;
use App\Domain\Entity\Share\Share;
use App\Domain\Entity\Share\ShareRepository;
use App\Domain\ValueObject\Url;

final class ShareRegisterCommandHandler extends CommandHandler
{
    private $repository;

    public function __construct(EntityIdFactory $entityIdFactory, ShareRepository $repository)
    {
        parent::__construct($entityIdFactory);
        $this->repository = $repository;
    }

    public function handle(ShareRegisterCommand $command)
    {
        $share = Share::addWithSocialNetworks(
            $this->entityIdFactory->shareFromString($command->uuid()),
            new Url($command->url()),
            SocialNetworkService::defaultNetworks()
        );

        $this->repository->add($share);
    }
}