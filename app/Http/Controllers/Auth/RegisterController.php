<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Where to redirect users after registration.
     */
    protected string $redirectTo = '/account';

    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        try {
            Log::info('Registration attempt started', ['email' => $request->email]);

            $this->validator($request->all())->validate();
            Log::info('Validation passed', ['email' => $request->email]);

            $user = $this->create($request->all());
            Log::info('User created successfully', ['user_id' => $user->id, 'email' => $user->email]);

            // Try to send verification email, but don't let it break registration
            try {
                event(new Registered($user));
                Log::info('Registered event fired', ['user_id' => $user->id]);
            } catch (\Exception $e) {
                // Log email sending failure but continue with registration
                Log::error('Failed to send verification email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage(),
                ]);
                // You might want to show a flash message to the user
                session()->flash('warning', 'Your account was created, but we couldn\'t send the verification email. Please contact support.');
            }

            Auth::login($user);
            Log::info('User logged in', ['user_id' => $user->id]);

            // Redirect based on gender
            if ($user->isMale()) {
                return redirect('/account/member');
            }
            return redirect($this->redirectTo);
        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }


    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return validator($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users'],
            'gender' => ['required', 'in:male,female'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('user');

        return $user;
    }
}