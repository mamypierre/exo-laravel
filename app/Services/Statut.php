<?php namespace App\Services;

use App\Models\Role;

class Statut
{

    const ADMIN_DASHBOARD = 'isAdmin_dashboard';
    const ROLES = 'slug_roles';
    const IS_ADMIN = 'is_admin';

    /**
     * Set the login user statut
     *
     * @param
     * @return void
     */
    public function setLoginStatut($login)
    {
        session()->put(self::IS_ADMIN, $login->user->isAdmin());
        session()->put(self::ADMIN_DASHBOARD, $this->isAdminDashboard());
        session()->put(self::ROLES, $login->user->slugRoles);
    }

    /**
     * Set the visitor user statut
     *
     * @return void
     */
    public function setVisitorStatut()
    {
        session()->put(self::IS_ADMIN, false);
        session()->put(self::ADMIN_DASHBOARD, $this->isAdminDashboard());
        session()->put(self::ROLES, ['visitor' => 'visitor']);
    }

    /**
     * Set the statut
     *
     * @return void
     */
    public function setStatut()
    {


        session()->put(self::ROLES, auth()->check() ? auth()->user()->slugRoles : ['visitor' => 'visitor']);


        session()->put(self::ADMIN_DASHBOARD, $this->isAdminDashboard());


        session()->put(self::IS_ADMIN, auth()->check() ? auth()->user()->isAdmin() : false);

    }

    /**
     * @return bool chef if user can access in AdminDashboard
     */
    private function isAdminDashboard()
    {
        $response = false;
        if (auth()->check()) {
            $roles = auth()->user()->slugRoles;
            if (isset($roles[Role::ROLE_ADMIN]) || isset($roles[Role::ROLE_EDITOR])) {
                $response = true;
            }
        }
        return $response;
    }

}
