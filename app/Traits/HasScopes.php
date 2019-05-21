<?php

namespace App\Traits;

use App\Repositories\ScopesRepository;

trait HasScopes 
{
    public function getScopesAttribute() {
        $repository = new ScopesRepository();
        $scopes = $repository->getUniqueScopesForUser($this);
        return $scopes;
    }

    public function isAllowed($scope_name) {
        $repository = new ScopesRepository();
        $scope = $repository->getScopeForUser($this, $scope_name);
        return $scope ? true : false;
    }
}