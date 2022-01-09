<?php

namespace App\Listeners;


use App\Models\Role;
use Illuminate\Auth\Events\Registered;

class DefaultRoleUser
{
    /**
     * @var Role
     */
    private $role;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        /** @var Role $roleEditor */
        $roleEditor = $this->role->firstOrCreate(
            ['title'=>Role::ROLE_EDITOR],
            [
                'slug'=>Role::$roleTittles[Role::ROLE_EDITOR]
            ]
        );
        $event->user->roles()->sync([$roleEditor->getAttribute('id')]);
    }
}
