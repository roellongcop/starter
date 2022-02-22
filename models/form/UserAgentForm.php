<?php

namespace app\models\form;

use Yii;
/**
 * Ip Information
 */
class UserAgentForm extends \yii\base\Model
{
	public $ip;
	public $userAgent;
	public $purpose = 'location';
	public $deep_detect = true;
	public $api = 'http://www.geoplugin.net/json.gp?ip=';

	private $browser = 'Browser not detected';
	private $os = 'OS not detected';
	private $device = 'Device not detected';

	const CONTINENTS = [
		"AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
	];

	const SUPPORTS = [
		"country", 
		"countrycode", 
		"state", 
		"region", 
		"city", 
		"location", 
		"address"
	];

	const BROWSERS = [
		"/firefox/i" 	=> "Firefox",
		"/safari/i"  	=> "Safari",
		"/chrome/i"  	=> "Chrome",
		"/opr/i"     	=> "Opera",
		"/opera/i"   	=> "Opera",
		"/edge/i"    	=> "Edge",
		"/ie/i"      	=> "Internet Explorer",
		"/trident/i" 	=> "Internet Explorer",
		"/net/i"     	=> "Internet Explorer",
		"/ucbrowser/i"  => "UC Browser",
		"/brave/i" 	    => "Brave",
		"/duckduckgo/i" => "Duckduck Go",
	];

	const OS = [
		"/mac os/i"  => "MacOS",
		"/android/i" => "Android",
		"/linux/i"   => "Linux",
		"/ubuntu/i"  => "MacOS",
		"/windows/i" => "Windows",
		"/win/i"     => "Windows",
		"/iphone/i"  => "iOS",
	];

	const DEVICES = [
        "Computer" => [
        	"msie 10", 
        	"msie 9",
        	"msie 8", 
        	"windows.*firefox", 
        	"windows.*chrome", 
        	"x11.*chrome", 
        	"x11.*firefox", 
        	"macintosh.*chrome", 
        	"macintosh.*firefox", 
        	"opera"
        ],
        "Tablet" => [
        	"tablet", 
        	"android", 
        	"ipad", 
        	"tablet.*firefox"
        ],
        "Mobile" => [
        	"mobile ", 
        	"android.*mobile", 
        	"iphone", "ipod", 
        	"opera mobi", 
        	"opera mini"
        ],
        "Bot" => [
        	"googlebot", 
        	"mediapartners-google", 
        	"adsbot-google", 
        	"duckduckbot", 
        	"msnbot", 
        	"bingbot", 
        	"ask", 
        	"facebook", 
        	"yahoo", 
        	"addthis"
        ]
    ];

	 /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['ip', 'purpose', 'api', 'userAgent'], 'required'],
            ['deep_detect', 'safe'],
            ['ip', 'ip'],
            [['purpose', 'api'], 'string'],
        ];
    }

    public function init()
    {
    	parent::init();
    	$this->ip = Yii::$app->request->userIp ?: '000.000.0.0';
    	$this->userAgent = Yii::$app->request->userAgent;
    }

    private function filterUserAgent($array)
    {
    	return array_filter($array,
            function($value, $key) {
                preg_match($key, $this->userAgent, $match);  
				if($match) {
					return $value;
				}
            }, 
            ARRAY_FILTER_USE_BOTH
        );
    }

    public function getBrowser()
	{  
		$browser = $this->filterUserAgent(self::BROWSERS);
		return ($browser)? end($browser): $this->browser;
	}

	public function GetOs()
	{   
		$os = $this->filterUserAgent(self::OS);
		return ($os)? end($os): $this->os;
	}

	public function getDevice()
	{
	    $userAgent = $this->userAgent;
	    $device = $this->device;

	    foreach (self::DEVICES as $mainDevice => $devices) {
	    	foreach ($devices as $value) {
	    		if(preg_match("/{$value}/i", $userAgent)) {
	    			$device = $mainDevice;
	    		} 
	    	}
	    }

	    return $device;
	}

	public function getIpInformation($purpose='')
	{
		$purpose = $purpose ?: $this->purpose;
		$output = '';

		try {
	    	$ip = $this->ip;
	    	
	        $output = NULL;
	        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
	            $ip = $_SERVER["REMOTE_ADDR"];
	            if ($this->deep_detect) {
	                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
	                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
	                    $ip = $_SERVER['HTTP_CLIENT_IP'];
	            }
	        }
	        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));

	        $continents = self::CONTINENTS;

	        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, self::SUPPORTS)) {
	            $ipdat = @json_decode(file_get_contents($this->api . $ip));
	            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
	                switch ($purpose) {
	                    case "location":
	                        $output = array(
	                            "city"           => @$ipdat->geoplugin_city,
	                            "state"          => @$ipdat->geoplugin_regionName,
	                            "country"        => @$ipdat->geoplugin_countryName,
	                            "country_code"   => @$ipdat->geoplugin_countryCode,
	                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
	                            "continent_code" => @$ipdat->geoplugin_continentCode
	                        );
	                        break;
	                    case "address":
	                        $address = array($ipdat->geoplugin_countryName);
	                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
	                            $address[] = $ipdat->geoplugin_regionName;
	                        if (@strlen($ipdat->geoplugin_city) >= 1)
	                            $address[] = $ipdat->geoplugin_city;
	                        $output = implode(", ", array_reverse($address));
	                        break;
	                    case "city":
	                        $output = @$ipdat->geoplugin_city;
	                        break;
	                    case "state":
	                        $output = @$ipdat->geoplugin_regionName;
	                        break;
	                    case "region":
	                        $output = @$ipdat->geoplugin_regionName;
	                        break;
	                    case "country":
	                        $output = @$ipdat->geoplugin_countryName;
	                        break;
	                    case "countrycode":
	                        $output = @$ipdat->geoplugin_countryCode;
	                        break;
	                }
	            }
	        }
	        return $output;
        } catch (\yii\base\ErrorException $e) {
	        return $output;
    	}
	}
}