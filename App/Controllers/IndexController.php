<?php
 	namespace App\Controllers;
	use MF\Controller\Action;
	use MF\Model\Container;
	
	 class IndexController extends Action{
	 	public function login(){
	 		$this->view->login =isset($_GET['login']) ? $_GET['login'] : '';
	 		$this->render('login');
	 	}
	 	public function novo(){
	 		$this->view->usuario=array('nome'=>'','email'=>'','nick'=>'','senha'=>'',);
	 		$this->view->erroCadastro=false;
			$this->render('novo');
		}
		public function index(){
			//Inicia com o controle dos dados
			$produto=Container::getModel('produto');
			$totalRegistrosPaginaHE = 7;
	 		$deslocamentoHE = 0;
	 		$paginaHE=isset($_GET['produtosRecentes']) ? $_GET['produtosRecentes'] :1;
	 		$deslocamentoHE=($paginaHE -1)*$totalRegistrosPaginaHE;
	 		//metade da paginação
	 		$produtosHE = $produto->getPorPaginaHE($totalRegistrosPaginaHE, $deslocamentoHE);	 		
	 		$totalProdutosHE=$produto->getTotalRegistrosHE();
	 		//finalização da paginação
			$this->view->totalPaginasHE=ceil($totalProdutosHE['total']/$totalRegistrosPaginaHE);			
			$this->view->paginaAtivaHE=$paginaHE;
	 		$this->view->produtosHE=$produtosHE;

			//Rendeniza a index
			$this->render('index');
		}

		public function registrar(){
			$usuario= Container::getModel('Usuario');
			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('nick', $_POST['nick']);
			$usuario->__set('email', $_POST['email']);
			$usuario->__set('senha',md5($_POST['senha']));
			//$usuario->__set('cpfUsuario',md5($_POST['cpfUsuario']));
			//$usuario->__set('rgUsuario',md5($_POST['rgUsuario']));

			if($usuario->validarcadastro() && count($usuario->getUsuarioPorEmail())==0){
				$usuario->salvar();	
				$this->render('cadastro');
			}else {
				$this->view->usuario=array('nome'=>$_POST['nome'],'nick'=>$_POST['nick'],'email'=>$_POST['email'],'senha'=>$_POST['senha'],);
				$this->view->erroCadastro=true;
				$this->render('novo');
			}
		}
 	}
?>