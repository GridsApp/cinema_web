<?php

namespace App\Helpers\Timezone;

class TimezoneMapper
{
	protected $timezones;
	
	protected $lookup;
	
	public function mapCoordinates(float $latitude, float $longitude, string $fallback = null) : ?string
	{
		if (null === $this->lookup) {
			$this->timezones = (new Timezones)->get();
	
			$this->lookup = new PolygonLookup(Initializer::initialize());
		}
		
		$index = $this->lookup->lookup($latitude, $longitude);
		
		if (!$index || !isset($this->timezones[$index])) {
			return $fallback;
		}
		
		return $this->timezones[$index];
	}
}
