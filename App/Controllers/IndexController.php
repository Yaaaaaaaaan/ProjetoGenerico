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