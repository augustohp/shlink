<?php
namespace Shlinkio\Shlink\Core\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Shlinkio\Shlink\Common\Repository\PaginableRepositoryInterface;

interface ShortUrlRepositoryInterface extends ObjectRepository, PaginableRepositoryInterface
{
}
