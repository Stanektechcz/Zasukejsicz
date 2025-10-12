<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterModal extends Component
{
    // Modal state
    public bool $showModal = false;
    public int $currentStep = 1;
    public int $totalSteps = 2;

    // Step 1: Gender selection
    #[Validate('required|in:male,female')]
    public string $gender = '';

    // Step 2: Registration form
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|email|max:255|unique:users')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required|string|same:password')]
    public string $password_confirmation = '';

    protected $listeners = ['show-register-modal' => 'show', 'hide-register-modal' => 'hide'];

    /**
     * Show the registration modal
     */
    public function show()
    {
        $this->showModal = true;
        $this->currentStep = 1;
        $this->dispatch('modal-opened', 'register');
    }

    /**
     * Hide the registration modal
     */
    public function hide()
    {
        $this->showModal = false;
        $this->reset([
            'currentStep', 'gender', 'name', 'email', 
            'phone', 'password', 'password_confirmation'
        ]);
        $this->resetErrorBag();
        $this->dispatch('modal-closed', 'register');
    }

    /**
     * Go to next step
     */
    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validateOnly('gender');
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    /**
     * Go to previous step
     */
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Select gender and proceed to next step
     */
    public function selectGender($gender)
    {
        $this->gender = $gender;
        $this->nextStep();
    }

    /**
     * Register a new user
     */
    public function register()
    {
        $phoneValidation = ['nullable', 'string', 'max:20'];
        
        // Only add unique validation if phone is not empty
        if (!empty($this->phone)) {
            $phoneValidation[] = 'unique:users,phone';
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => $phoneValidation,
            'password' => ['required', 'string', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'gender' => ['required', 'in:male,female'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => !empty($this->phone) ? $this->phone : null,
            'password' => Hash::make($this->password),
        ]);

        // Create the profile with gender
        Profile::create([
            'user_id' => $user->id,
            'gender' => $this->gender,
            'display_name' => $this->name,
            'status' => 'pending',
            'is_public' => false,
        ]);

        // Fire the registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        $this->hide();

        // Redirect to profile completion or dashboard
        $this->redirect(route('account.dashboard'));
    }

    /**
     * Get the progress percentage
     */
    public function getProgressPercentage()
    {
        return round(($this->currentStep / $this->totalSteps) * 100);
    }

    public function render()
    {
        return view('livewire.register-modal');
    }
}