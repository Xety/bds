<?php

use BDS\Models\Site;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * All the sites that below to the authenticated user.
     *
     * @var null|stdClass|array
     */
    public null|stdClass|array $weather = null;


    public function mount(): void
    {
        //
        $site = Site::find(getPermissionsTeamId());

        $this->weather = Cache::remember(
            'Weather.current.' . $site->getKey(),
            config('bds.cache.weather_timeout'),
            function () use ($site) {
                $response = null;

                try {
                    $response = Http::timeout(3)->accept('application/json')->get('https://api.weatherapi.com/v1/current.json', [
                        'key' => config('bds.weather.api_key'),
                        'q' => "{$site->zip_code} {$site->city}, France",
                        'aqi' => 'yes',
                        'lang' => 'fr'
                    ]);

                    $response = json_decode($response->getBody()->getContents());
                } catch (\Illuminate\Http\Client\ConnectionException $e ) { }

                return $response;
            }
        );

    }
}; ?>

<div>
    @if($weather && !isset($weather->error))
        {{dd($weather)}}
        <div class="flex items-center w-max tooltip tooltip-bottom" data-tip="{{ $weather->current->condition->text }}">
            <div>
                <img class="w-14 h-14" src="{{ $weather?->current->condition->icon }}" alt="{{ $weather?->current->condition->text }}">
            </div>
            <div class="font-bold text-2xl">
                {{ $weather?->current->temp_c }}°
            </div>
        </div>
    @endif
</div>
