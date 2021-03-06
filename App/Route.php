<?php
	namespace App;
	
	use MF\Init\Bootstrap;

	class Route extends Bootstrap{
		protected function initRoutes(){
	//indexController				
//<--
			$routes['home'] = array(
				'route' =>'/',
				'controller'=>'indexController',
				'action'=>'index'
			);
			$routes['login'] = array(
				'route' =>'/login',
				'controller'=>'indexController',
				'action'=>'login'
			);
			$routes['novo'] = array(
				'route' =>'/novo',
				'controller'=>'indexController',
				'action'=>'novo'
			);
			$routes['registrar'] = array(
				'route' =>'/registrar',
				'controller'=>'indexController',
				'action'=>'registrar'
			);
	//authController				
//<--		
			$routes['autenticar'] = array(
				'route' =>'/autenticar',
				'controller'=>'authController',
				'action'=>'autenticar'
			);
			$routes['sair'] = array(
				'route' =>'/sair',
				'controller'=>'authController',
				'action'=>'sair'
			);
//appController
//<--				
			$routes['inicial'] = array(
				'route' =>'/inicial',
				'controller'=>'appController',
				'action'=>'inicial'
			);
			$routes['info'] = array(
				'route' =>'/info',
				'controller'=>'appController',
				'action'=>'info'
			);
			$routes['alterarSenha'] = array(
				'route' =>'/alterarSenha',
				'controller'=>'appController',
				'action'=>'alterarSenha'
			);
			$routes['checkout'] = array(
				'route' =>'/checkout',
				'controller'=>'appController',
				'action'=>'checkout'
			);
			$routes['pedidos'] = array(
				'route' =>'/Pedidos',
				'controller'=>'appController',
				'action'=>'pedidos'
			);

	// Produtos 
//<--
			$routes['produtosAtivos'] = array(
				'route' =>'/produtosAtivos',
				'controller'=>'prodController',
				'action'=>'exibeProd'
			);
			$routes['produtosInativos'] = array(
				'route' =>'/produtosInativos',
				'controller'=>'prodController',
				'action'=>'exibeProd'
			);
			$routes['salvarClasse'] = array(
				'route' =>'/salvarClasse',
				'controller'=>'prodController',
				'action'=>'salvarClasse'
			);
			$routes['postProd'] = array(
				'route' =>'/postProd',
				'controller'=>'prodController',
				'action'=>'postProd'
			);
			$routes['editProd'] = array(
				'route' =>'/editProd',
				'controller'=>'prodController',
				'action'=>'editProd'
			);
			$routes['deletaProd'] = array(
				'route' =>'/deletaProd',
				'controller'=>'prodController',
				'action'=>'deletaProd'
			);
			$routes['ativaProd'] = array(
				'route' =>'/ativaProd',
				'controller'=>'prodController',
				'action'=>'ativaProd'
			);
			$routes['historicoEstoque'] = array(
				'route' =>'/historicoEstoque',
				'controller'=>'prodController',
				'action'=>'exibeEstq'
			);
			$routes['historicoEntrada'] = array(
				'route' =>'/historicoEntrada',
				'controller'=>'prodController',
				'action'=>'exibeEstq'
			);
			$routes['detalhehistoricoEntrada'] = array(
				'route' =>'/infoProduto',
				'controller'=>'prodController',
				'action'=>'exibeEstq'
			);
			$routes['historicoSaida'] = array(
				'route' =>'/historicoSaida',
				'controller'=>'prodController',
				'action'=>'exibeEstq'
			);
			$routes['postEntEstq'] = array(
				'route' =>'/postEntEstq',
				'controller'=>'prodController',
				'action'=>'postEntEstq'
			);
			$routes['postSaiEstq'] = array(
				'route' =>'/postSaiEstq',
				'controller'=>'prodController',
				'action'=>'postSaiEstq'
			);
			$routes['editEstq'] = array(
				'route' =>'/editEstq',
				'controller'=>'prodController',
				'action'=>'editEstq'
			);
			$this->setRoutes($routes);
		}
	}
 ?>