<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ScopesRepository implements RepositoryInterface {
	
	public function getUniqueScopesForUser($user) {
		
		$result = DB::table('scopes')
            ->select(['scopes.scope', 'scopes.descripcion'])
            ->distinct()
            ->join('rol_scope', 'rol_scope.scope_scope', '=', 'scopes.scope')
            ->join('rol_user', 'rol_user.rol_id', '=', 'rol_scope.rol_id')
            ->where('rol_user.user_id', '=', $user->id)
			->get();

		$scopes = \App\Auth\Scope::hydrate($result->all());

		return $scopes;
	}

}