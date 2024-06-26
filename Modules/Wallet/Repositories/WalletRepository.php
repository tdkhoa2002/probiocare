<?php

namespace Modules\Wallet\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface WalletRepository extends BaseRepository
{
    public function getListWalletsCustomerAdmin($customerId, Request $request): LengthAwarePaginator;
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
}
