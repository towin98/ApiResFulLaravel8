<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\AdminAccions;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization, AdminAccions;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $autenticadoUser, User $user)
    {
        return $autenticadoUser->id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $autenticadoUser, User $user)
    {
        return $autenticadoUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $autenticadoUser, User $user)
    {
        /*obtenemos el token, obtenemos el cliente, personal access cliente es verdadero cuando 
        ese cliente puede crear token personales*/
        return $autenticadoUser->id === $user->id && $autenticadoUser->token()->client->personal_access_client;
    }
}
