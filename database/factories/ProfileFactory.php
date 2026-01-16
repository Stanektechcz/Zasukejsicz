<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);
        $firstName = fake()->firstName($gender === 'female' ? 'female' : 'male');
        $lastName = fake()->lastName();
        
        // Generate realistic cities from Czech Republic and nearby regions
        $cities = [
            'Praha', 'Brno', 'Ostrava', 'Plzeň', 'Liberec', 'Olomouc', 
            'České Budějovice', 'Hradec Králové', 'Ústí nad Labem', 'Pardubice',
            'Zlín', 'Havířov', 'Kladno', 'Most', 'Opava', 'Frýdek-Místek',
            'Jihlava', 'Teplice', 'Karlovy Vary', 'Děčín'
        ];
        
        // Random availability hours
        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $availabilityHours = [];
        foreach ($weekdays as $day) {
            if (fake()->boolean(70)) { // 70% chance of being available
                $startHour = fake()->numberBetween(8, 14);
                $endHour = fake()->numberBetween($startHour + 4, 23);
                $availabilityHours[$day] = sprintf('%02d:00-%02d:00', $startHour, $endHour);
            }
        }
        
        // Generate price arrays
        $localPrices = [];
        $priceOptions = ['30min', '1hour', '2hours', 'overnight'];
        foreach ($priceOptions as $option) {
            if (fake()->boolean(80)) {
                $basePrice = fake()->numberBetween(1000, 5000);
                $localPrices[$option] = $basePrice;
            }
        }
        
        $globalPrices = [];
        foreach ($priceOptions as $option) {
            if (fake()->boolean(70)) {
                $basePrice = fake()->numberBetween(50, 500);
                $globalPrices[$option] = $basePrice;
            }
        }
        
        // Generate rich content for Filament blocks
        $content = $this->generateBlockContent();

        return [
            'gender' => $gender,
            'display_name' => [
                'en' => $firstName . ' ' . $lastName,
                'cs' => $firstName . ' ' . $lastName,
            ],
            'age' => fake()->numberBetween(18, 55),
            'city' => fake()->randomElement($cities),
            'address' => fake()->streetAddress(),
            'country_code' => fake()->randomElement(['CZ', 'SK', 'PL', 'AT', 'DE']),
            'about' => [
                'en' => $this->generateAboutText('en'),
                'cs' => $this->generateAboutText('cs'),
            ],
            'incall' => fake()->boolean(80),
            'outcall' => fake()->boolean(60),
            'content' => $content,
            'availability_hours' => $availabilityHours,
            'local_prices' => $localPrices,
            'global_prices' => $globalPrices,
            'status' => fake()->randomElement(['draft', 'pending', 'approved', 'rejected']),
            'is_public' => fake()->boolean(80),
            'is_vip' => fake()->boolean(20),
            'verified_at' => fake()->boolean(60) ? now()->subDays(fake()->numberBetween(1, 30)) : null,
        ];
    }
    
    /**
     * Generate realistic about text
     */
    private function generateAboutText(string $locale): string
    {
        if ($locale === 'cs') {
            $intros = [
                'Ahoj! Jsem profesionální společnice s mnohaletými zkušenostmi.',
                'Vítejte na mém profilu. Poskytuju luxusní společenské služby.',
                'Dobrý den, nabízím diskrétní a profesionální služby.',
                'Zdravím Vás, jsem elegantní společnice pro náročné klienty.',
            ];
            
            $qualities = [
                'Mám rád diskrétnost a profesionalitu.',
                'Zajišťuji příjemné a uvolněné prostředí.',
                'Jsem vždy čistý/á, voňavý/á a dobře oblečený/á.',
                'Mám smysl pro humor a ráda bavím.',
                'Jsem komunikativní a otevřený/á.',
            ];
            
            $services = [
                'Nabízím širokou škálu služeb podle Vašich přání.',
                'Rád/a splním Vaše fantazie v rámci mých možností.',
                'Můžeme se sejít u mě nebo přijedu k Vám.',
                'Vždy dodržuji dohodnuté časy a podmínky.',
            ];
        } else {
            $intros = [
                'Hello! I am a professional companion with many years of experience.',
                'Welcome to my profile. I provide luxury companionship services.',
                'Good day, I offer discreet and professional services.',
                'Greetings, I am an elegant companion for discerning clients.',
            ];
            
            $qualities = [
                'I value discretion and professionalism.',
                'I ensure a pleasant and relaxed environment.',
                'I am always clean, fragrant, and well-dressed.',
                'I have a sense of humor and love to entertain.',
                'I am communicative and open-minded.',
            ];
            
            $services = [
                'I offer a wide range of services according to your wishes.',
                'I am happy to fulfill your fantasies within my capabilities.',
                'We can meet at my place or I can come to you.',
                'I always respect agreed times and conditions.',
            ];
        }
        
        $text = fake()->randomElement($intros) . ' ';
        $text .= fake()->randomElement($qualities) . ' ';
        $text .= fake()->randomElement($qualities) . ' ';
        $text .= fake()->randomElement($services) . ' ';
        
        if (fake()->boolean(50)) {
            $text .= fake()->sentence();
        }
        
        return $text;
    }
    
    /**
     * Generate block content for Filament blocks
     */
    private function generateBlockContent(): array
    {
        $blocks = [];
        
        // Add some random blocks
        if (fake()->boolean(60)) {
            $blocks[] = [
                'type' => 'SkyRaptor\\FilamentBlocksBuilder\\Blocks\\Typography\\Paragraph',
                'data' => [
                    'content' => fake()->paragraphs(2, true),
                ],
            ];
        }
        
        if (fake()->boolean(40)) {
            $blocks[] = [
                'type' => 'SkyRaptor\\FilamentBlocksBuilder\\Blocks\\Typography\\Heading',
                'data' => [
                    'content' => fake()->sentence(3),
                    'level' => 'h2',
                ],
            ];
        }
        
        if (fake()->boolean(50)) {
            $blocks[] = [
                'type' => 'SkyRaptor\\FilamentBlocksBuilder\\Blocks\\Typography\\Paragraph',
                'data' => [
                    'content' => '• ' . implode("\n• ", [
                        fake()->sentence(),
                        fake()->sentence(),
                        fake()->sentence(),
                    ]),
                ],
            ];
        }
        
        return $blocks;
    }

    /**
     * Indicate that the profile is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the profile is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }

    /**
     * Indicate that the profile is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }
    
    /**
     * Indicate that the profile is VIP.
     */
    public function vip(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_vip' => true,
            'verified_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }
    
    /**
     * Indicate that the profile is female.
     */
    public function female(): static
    {
        return $this->state(function (array $attributes) {
            $firstName = fake()->firstName('female');
            $lastName = fake()->lastName();
            return [
                'gender' => 'female',
                'display_name' => [
                    'en' => $firstName . ' ' . $lastName,
                    'cs' => $firstName . ' ' . $lastName,
                ],
            ];
        });
    }
    
    /**
     * Indicate that the profile is male.
     */
    public function male(): static
    {
        return $this->state(function (array $attributes) {
            $firstName = fake()->firstName('male');
            $lastName = fake()->lastName();
            return [
                'gender' => 'male',
                'display_name' => [
                    'en' => $firstName . ' ' . $lastName,
                    'cs' => $firstName . ' ' . $lastName,
                ],
            ];
        });
    }
    
    /**
     * Create a complete profile ready for public display.
     */
    public function complete(): static
    {
        return $this->approved()->public()->verified();
    }
    
    /**
     * Indicate the profile is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }
    
    /**
     * Indicate the profile is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'is_public' => false,
        ]);
    }
}
