<?php

	require_once __DIR__ . '/vendor/autoload.php';

	use Goutte\Client;

	
	class app {

		const COOKIEFILE = '/tmp/cookies2.txt';


		public function __construct(){

		}

		private function login(){

			$arr = array();

			$client = new Client(); //Goutte client

			$crawler = $client->request('GET', 'http://ingressos.biotur.tur.br/Reservas/Nova');
			
			$form = $crawler->selectButton('Entrar')->form();
			
			$crawler = $client->submit($form, array('Email' => 'b8215040@urhen.com', 'Password' => '123456')); 

		} //end login()



		private function getCookie(){

			$this->login(); //you cannot get the cookie without logging in first

			$cookieJar = $client->getCookieJar(); //getting the cookie jar from website
			
			$cookie = $this->filterCookie($cookieJar); //filter the cookie jar to get the .AspNet.ApplicationCookie

			$this->storeCookie($cookie); //store the .AspNet.ApplicationCookie value in a file

			return $cookie;

		} //end getCookie()



		private function storeCookie(String $cookie){

			file_put_contents(self::COOKIEFILE, serialize($cookie)); //storing the cookie in a file

			//$cookie = unserialize(file_get_contents(self::COOKIEFILE)); //retrieving the cookies

		} //end storeCookie()



		private function filterCookie(Object $cookieJar){

			$cookieJarArray = (Array)$cookieJar; //casting cookie jar object to array to access protected properties
			
			$arrayIngressos = $cookieJarArray["\0*\0" . 'cookieJar']['ingressos.biotur.tur.br']['/']['.AspNet.ApplicationCookie'];
			
			$aspNetApplicationCookie = (Array)$arrayIngressos; //casting cookie object to array to access protected property
			
			$cookieValue = $aspNetApplicationCookie["\0*\0" . 'value']; //getting the value of the property 'value'

			return $cookieValue;

		} //end filterCookie()



		private function checkCookie(){

			$cookieFileContent = file_get_contents(self::COOKIEFILE);

			$cookieAvailable = strlen($cookieFileContent) > 0 ? $cookieFileContent : 0; //checks if there is content in the cookie file

			return $cookieAvailable;

		} //end checkCookie()




		public function checkAvailability(String $date = "", Int $destination = 0){

			$cookie = $this->checkCookie();

			if($cookie === 0){

				$cookie = $this->getCookie(); //if cookie file is empty, get a new cookie

			}

			

			$date = array("data" => "2019-12-20", "destinoId" => 8);

			$data_string = json_encode($data);


			//check cookie file, if it has content, use the content, otherwise, login and get a new cookie

			//






		} //end checkAvailability()




		public function makeBooking(){


		} //end makeBooking()



	} //end class



	$bla = new app();
	echo "<pre>";
	print_r($bla->login());
	echo "</pre>";



?>