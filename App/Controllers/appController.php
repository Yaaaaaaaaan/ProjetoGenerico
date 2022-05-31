<?php
 	namespace App\Controllers;
	use MF\Controller\Action;
	use MF\Model\Container;
	
	class appController extends Action{
		public function checkout(){
			$this->validaAutenticacao();
			$this->render('checkout');
		}
		public function info(){
			$this->validaAutenticacao();
			$this->view->erroNewPass =isset($_GET['erroNewPass']) ? $_GET['erroNewPass'] : '';
			$this->view->erroNewPass =false;
			
			$this->view->info=isset($_GET['info']) ? $_GET['info'] :'';
			$this->view->info= false;
			$this->render('info');
			//Precisa criar um mecanismo similar ao de erro de senha, link com session já está funcionando, falta apenas linkar nome da session com as configurações.
		}
		public function inicial(){
			$this->validaAutenticacao();
			
			$this->render('inicial');
		}
		public function pedidos(){
			$this->validaAutenticacao();
			$this->render('pedidos');
		}
		public function validaAutenticacao(){
			session_start();
			if(!isset($_SESSION['id'])||$_SESSION['id'] =='' || !isset($_SESSION['nome'])||$_SESSION['nome'] ==''){
				header("Location: /login?login=erro");
			}
		}
		public function alterarSenha(){
			$this->validaAutenticacao();
			$this->view->erroNewPass =isset($_GET['erroNewPass']) ? $_GET['erroNewPass'] : '';
			$usuario= Container::getModel('Usuario');
			$usuario->__set('idUsuario',$_POST['idUsuario']);
			$usuario->__set('oldpass',md5($_POST['oldpass']));
	 		$usuario->__set('newpass',md5($_POST['newpass']));
			if($usuario->validaNovaSenha()){
				$usuario->salvaNovaSenha();	
				//$this->render('info');
				header('location:/info');
			}else {
				$this->view->usuario=array('oldpass'=>$_POST['oldpass'],'newpass'=>$_POST['newpass'],);
				$this->view->erroNewPass=true;
				$this->render('info');
		}}

		/*public function postProd(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('descProd',$_POST['descProd']);
			$produto->__set('classeProd',$_POST['classeProd']);
			$produto->__set('idUsuario',$_POST['idUsuario']);
			$produto->salvar();
			//$this->render('produtos');
			header("Location: /produtos");
		}*/
	}
?>