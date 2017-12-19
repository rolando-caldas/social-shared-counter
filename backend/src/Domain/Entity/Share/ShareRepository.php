<?php

namespace App\Domain\Entity\Share;

use App\Domain\Collection\ShareCollection;
use App\Domain\ValueObject\Url;

interface ShareRepository
{
    public function nextIdentity() : ShareId;
    public function ofIdOrFail(ShareId $id) : Share;
    public function ofUrlOrFail(Url $url) : Share;
    public function add(Share $share) : Share;
    public function update(Share $share) : Share;
    public function remove(Share $share) : bool;
    public function getAll(): ShareCollection;
}