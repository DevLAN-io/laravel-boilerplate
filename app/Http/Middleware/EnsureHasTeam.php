<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureHasTeam
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isMemberOfATeam()) {
            return redirect()->route('teams.create');
        }
        $this->ensureUserHasCurrentTeamSet();
        return $next($request);
    }

    protected function ensureUserHasCurrentTeamSet(): void
    {
        if (is_null(auth()->user()->current_team_id)) {
            $user = auth()->user();
            $user->current_team_id = $user->allTeams()->first()->id;
            $user->save();
        }
    }
}
