<?php
	
	namespace Source\Controllers;
	
	use CoffeeCode\Optimizer\Optimizer;
	use CoffeeCode\Router\Router;
	use League\Plates\Engine;
	
	/**
	 * Class Controller
	 * @package Source\Controllers
	 */
	abstract class Controller
	{
		/** @var Engine */
		protected Engine $view;
		
		/** @var Router */
		protected Router $router;
		
		/** @var Optimizer */
		protected Optimizer $seo;
		
		
		/**
		 * @param $router
		 */
		public function __construct($router)
		{
			$this->router = $router;
			$this->view = Engine::create(dirname(__DIR__, 2) . "/views", "php");
			$this->view->addData(["router" => $this->router]);

			$this->seo = new Optimizer();
			$this->seo->openGraph(site("name"), site("locale"), "")
				->publisher(SOCIAL["facebook_page"], SOCIAL["facebook_author"])
				->twitterCard(SOCIAL["twitter_creator"], SOCIAL["twitter_site"], site("domain"))
				->facebook(SOCIAL["facebook_appId"]);
		}
		
		/**
		 * @param string $params
		 * @param array $values
		 * @return string
		 */
		public function ajaxResponse(string $params, array $values): string
		{
			return json_encode([$params => $values]);
		}
	}