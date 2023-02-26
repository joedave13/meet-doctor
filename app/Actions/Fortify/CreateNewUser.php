<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'age' => ['required', 'integer', 'min:0']
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::query()->create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password'])
            ]), function (User $user) use ($input) {
                $user_detail = new UserDetail;
                $user_detail->user_id = $user->id;
                $user_detail->user_type_id = 3;
                $user_detail->age = $input['age'];
                $user_detail->contact = null;
                $user_detail->address = null;
                $user_detail->photo = null;
                $user_detail->save();

                $user->roles()->sync(5);
            });
        });
    }
}
