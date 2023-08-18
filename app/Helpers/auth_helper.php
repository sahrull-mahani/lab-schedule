<?php

use App\Libraries\IonAuth;

if (!function_exists('logged_in')) {
    /**
     * Checks to see if the user is logged in.
     *
     * @return bool
     */
    function logged_in(){
        $ionAuth = new IonAuth;
        return $ionAuth->loggedIn();
    }
}

if (!function_exists('is_admin')) {
    /**
     * Returns the User instance for the current logged in user.
     *
     * @return User|null
     */
    function is_admin()
    {
        $ionAuth = new IonAuth;
        return $ionAuth->isAdmin();
    }
}

if (!function_exists('user_id')) {
    /**
     * Returns the User ID for the current logged in user.
     *
     * @return int|null
     */
    function user_id()
    {
        $ionAuth = new IonAuth;
        return $ionAuth->getUserId();
    }
}

if (!function_exists('in_groups')) {
    /**
     * Ensures that the current user is in at least one of the passed in
     * groups. The groups can be passed in as either ID's or group names.
     * You can pass either a single item or an array of items.
     *
     * Example:
     *  in_groups([1, 2, 3]);
     *  in_groups(14);
     *  in_groups('admins');
     *  in_groups( ['admins', 'moderators'] );
     *
     * @param mixed  $groups
     *
     * @return bool
     */
    function in_groups($groups,$id=0): bool
    {
        $ionAuth = new IonAuth;
        if (logged_in()) {
            return $ionAuth->inGroup($groups,$id);
        }
        return false;
    }
}
