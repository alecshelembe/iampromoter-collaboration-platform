<?php

if (!function_exists('getSectorIcon')) {
    function getSectorIcon($sector)
    {
        // Normalize the key (convert to lowercase and replace hyphens with spaces)

        $icons = [
            // manual add
            'play-area' => 'fa-solid fa-child',
            'dogs-allowed' => 'fa-solid fa-dog',
            'parking' => 'fa-solid fa-square-parking',
            'outdoor-seating' => 'fa-solid fa-chair',
            'wheelchair-accessible' => 'fa-solid fa-wheelchair',
            'food-available' => 'fa-solid fa-utensils',
            'alcohol-served' => 'fa-solid fa-wine-glass',
            'bike-racks' => 'fa-solid fa-bicycle',
            'charging-stations' => 'fa-solid fa-bolt',
            'live-music' => 'fa-solid fa-music',
            'sports-screening' => 'fa-solid fa-tv',
            'smoking-area' => 'fa-solid fa-smoking',


            // Technology & IT
            'technology' => 'fa-laptop-code',
            'software' => 'fa-code',
            'cybersecurity' => 'fa-shield-alt',
            'networking' => 'fa-network-wired',
            'cloud computing' => 'fa-cloud',
            'ai & machine learning' => 'fa-robot',
            'wifi' => 'fa-wifi',

            // Finance & Business
            'finance' => 'fa-dollar-sign',
            'banking' => 'fa-university',
            'investment' => 'fa-chart-line',
            'cryptocurrency' => 'fa-coins', // Replaced invalid `fa-bitcoin`
            'insurance' => 'fa-file-invoice-dollar',

            // Healthcare & Accessibility
            'healthcare' => 'fa-heartbeat',
            'pharmaceuticals' => 'fa-pills',
            'medical devices' => 'fa-stethoscope',
            'dentistry' => 'fa-tooth',
            'mental health' => 'fa-brain',
            'wheelchair access' => 'fa-wheelchair',

            // Education & Training
            'education' => 'fa-book',
            'e-learning' => 'fa-laptop',
            'research' => 'fa-flask',
            'university' => 'fa-graduation-cap',

            // Entertainment & Media
            'entertainment' => 'fa-film',
            'gaming' => 'fa-gamepad',
            'music' => 'fa-music',
            'theater' => 'fa-masks-theater',
            'streaming' => 'fa-tv',

            // Retail & E-Commerce
            'retail' => 'fa-shopping-cart',
            'e-commerce' => 'fa-shopping-bag',
            'fashion' => 'fa-tshirt',
            'jewelry' => 'fa-gem',
            'luxury goods' => 'fa-crown',

            // Automotive & Transportation
            'automotive' => 'fa-car',
            'trucking' => 'fa-truck',
            'airlines' => 'fa-plane',
            'maritime' => 'fa-ship',
            'railways' => 'fa-train',
            'bicycle rentals' => 'fa-bicycle',
            'electric charging' => 'fa-bolt',

            // Real Estate & Construction
            'real estate' => 'fa-building',
            'construction' => 'fa-hard-hat',
            'architecture' => 'fa-drafting-compass',
            'interior design' => 'fa-couch',

            // Energy & Environment
            'energy' => 'fa-bolt',
            'renewable energy' => 'fa-solar-panel',
            'oil & gas' => 'fa-gas-pump',
            'water management' => 'fa-faucet',
            'waste management' => 'fa-recycle',

            // Agriculture & Food
            'agriculture' => 'fa-seedling',
            'farming' => 'fa-tractor',
            'food & beverage' => 'fa-utensils',
            'restaurants' => 'fa-wine-glass-alt',
            'baking' => 'fa-bread-slice',

            // Manufacturing & Industry
            'manufacturing' => 'fa-industry',
            'mining' => 'fa-mountain',
            'metallurgy' => 'fa-tools',
            'chemical industry' => 'fa-vial',

            // Travel & Hospitality
            'tourism' => 'fa-map-marked-alt',
            'hotels' => 'fa-bed',
            'event planning' => 'fa-calendar-check',

            // Legal & Government
            'law' => 'fa-gavel',
            'government' => 'fa-landmark',
            'military' => 'fa-shield-halved',
            'politics' => 'fa-balance-scale',

            // Sports & Fitness
            'sports' => 'fa-football-ball',
            'fitness' => 'fa-dumbbell',
            'martial arts' => 'fa-hand-rock',
            'yoga' => 'fa-om',

            // Logistics & Supply Chain
            'logistics' => 'fa-boxes',
            'supply chain' => 'fa-truck-moving',
            'shipping' => 'fa-ship',
            'warehousing' => 'fa-warehouse',

            // Social & Non-Profit
            'non-profit' => 'fa-hands-helping',
            'charity' => 'fa-hand-holding-heart',
            'volunteering' => 'fa-users',
            'religious' => 'fa-church',

            // Science & Research
            'science' => 'fa-atom',
            'space' => 'fa-rocket',
            'biotechnology' => 'fa-dna',
            'environmental science' => 'fa-leaf',

            // Miscellaneous
            'telecommunications' => 'fa-phone',
            'marketing' => 'fa-bullhorn',
            'consulting' => 'fa-user-tie',
            'freelancing' => 'fa-laptop',
            'security' => 'fa-lock',

            // Family & Pets
            'child friendly' => 'fa-child',
            'pets allowed' => 'fa-dog',

            // Hospitality & Amenities
            'parking' => 'fa-square-parking',
            'seating' => 'fa-chair',
            'smoking area' => 'fa-smoking',
            'wine & drinks' => 'fa-wine-glass',
        ];

        return $icons[$sector] ?? 'fa-question-circle'; // Default icon if not found
    }
}
