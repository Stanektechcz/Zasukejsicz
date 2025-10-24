<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
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
        // Immediately hide modal without server round trip
        $this->showModal = false;
        
        // Reset form data without triggering loading states
        $this->currentStep = 1;
        $this->gender = '';
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->password_confirmation = '';
        
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
        // Validate all fields at once for better performance
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'gender' => ['required', 'in:male,female'],
        ]);

        try {
            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => !empty($validated['phone']) ? $validated['phone'] : null,
                'password' => Hash::make($validated['password']),
            ]);

            // Create the profile with gender
            Profile::create([
                'user_id' => $user->id,
                'gender' => $validated['gender'],
                'display_name' => $validated['name'],
                'status' => 'pending',
                'is_public' => false,
            ]);

            // Fire the registered event
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            // Hide modal immediately
            $this->showModal = false;

            // Redirect to profile completion or dashboard
            $this->redirect(route('account.dashboard'));
            
        } catch (\Exception $e) {
            $this->addError('registration', __('auth.register.error'));
        }
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

    public function placeholder()
    {
        $loadingText = __('auth.register.loading') ?: 'Loading...';

        return <<<HTML
        <div class="fixed inset-0 z-50 flex items-center justify-center p-2">
            <div class="fixed inset-0 backdrop-blur-lg" style="background-color: rgba(92, 45, 98, 0.8);"></div>
            <div class="relative w-lg bg-white rounded-3xl p-10 py-16 pb-7 shadow-xl">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary mx-auto"></div>
                    <p class="mt-4 text-gray-600">{$loadingText}</p>
                </div>
            </div>
        </div>
        HTML;
    }
}