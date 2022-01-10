<?php

namespace App\Console\Commands;

use App\Http\Requests\RuleValidator\Register;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class CreateUserAdmin extends Command
{
    use Register;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:creat:admin
                            {--last_name= : Last name string 150}
                            {--first_name= : First name string 150}
                            {--user_name= : User name string 30 not include special character}
                            {--email= : email string 255}
                            {--password= : Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character }
                             ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creat new user admin';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $validator = $this->validator();
        if ($validator->fails()) {
            $this->showError($validator->messages());
            exit();
        }
        $this->createAdminUser();

        $this->alert(__('admin creat successful'));
    }

    private function validator(): \Illuminate\Contracts\Validation\Validator
    {
        $rules = $this->rules();
        /**
         * remove confirmed password
         */
        $passwordRule = $rules['password'];
        $key = array_search('confirmed', $passwordRule);
        unset($passwordRule[$key]);
        $rules['password'] = $passwordRule;

        return Validator::make(
            $this->options(),
            $rules
        );
    }

    /**
     * Show error message
     * @param MessageBag $messageBag
     * @return void
     */
    private function showError(MessageBag $messageBag)
    {
        foreach ($messageBag->getMessages() as $message) {
            if (isset($message[0])) {
                $this->error($message[0]);
            }
        }
    }

    /**
     * creat admin user
     * @return void
     */
    private function createAdminUser()
    {
        $user = $this->create($this->options()) ;
        /** @var Role $roleEditor */
        $roleEditor = Role::firstOrCreate(
            ['slug' => Role::ROLE_ADMIN],
            [
                'title' => Role::$roleTittles[Role::ROLE_ADMIN]
            ]
        );
        $user->roles()->sync([$roleEditor->getAttribute('id')]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);
    }
}
