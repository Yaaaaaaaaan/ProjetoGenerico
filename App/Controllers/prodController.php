<?php
 	namespace App\Controllers;
	use MF\Controller\Action;
	use MF\Model\Container;
	class prodController extends Action{
		public function validaAutenticacao(){
			session_start();
			if(!isset($_SESSION['id'])||$_SESSION['id'] =='' || !isset($_SESSION['nome'])||$_SESSION['nome'] ==''){
				header("Location: /login?login=erro");
			}
		}
		public function exibeProd(){
			$this->validaAutenticacao();
	 		$produto=Container::getModel('produto');
	 		$totalRegistrosPagina = 10;
	 		$totalRegistrosPaginaI = 10;
	 		$deslocamento = 0;
	 		$deslocamentoI = 0;
	 		$pagina=isset($_GET['pagina']) ? $_GET['pagina'] :1;
	 		$paginaI=isset($_GET['paginaI']) ? $_GET['paginaI'] :1;
	 		$deslocamento=($pagina -1)*$totalRegistrosPagina;
	 		$deslocamentoI=($paginaI -1)*$totalRegistrosPaginaI;
	 		$produtos = $produto->getPorPagina($totalRegistrosPagina, $deslocamento);
	 		$produtosI = $produto->getPorPaginaI($totalRegistrosPaginaI, $deslocamentoI);
	 		$totalProdutos=$produto->getTotalRegistros();
	 		$totalProdutosI=$produto->getTotalRegistrosI();
			$this->view->totalPaginas=ceil($totalProdutos['total']/$totalRegistrosPagina);
			$this->view->totalPaginasI=ceil($totalProdutosI['total']/$totalRegistrosPaginaI);
			$this->view->paginaAtiva=$pagina;
			$this->view->paginaAtivaI=$paginaI;
	 		$this->view->produtos=$produtos;
	 		$this->view->produtosI=$produtosI;
	 		/*demais funções*/
	 		$classeProdTotal=$produto->getTotalClasseBase();
	 		$this->view->classeProdTotal=$classeProdTotal;
	 		$divisaoProdTotal=$produto->getTotalClasseDivisao();
	 		$this->view->divisaoProdTotal=$divisaoProdTotal;
	 		$this->render('produtos');
		}
		public function salvarClasse(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('classeBase',$_POST['classeBase']);
			$produto->__set('classeDivisao',$_POST['classeDivisao']);
			$produto->__set('idUsuarioFkClass',$_POST['idUsuario']);
			$produto->salvarClasse();
			echo '<script>history.go(-1);</script>';
			//$this->render('produtos');
			//header("Location: /produtos");
		}
		public function postProd(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('descProd',$_POST['descProd']);
			$produto->__set('tamProd',$_POST['tamProd']);
			$produto->__set('estMinProd',$_POST['estMinProd']);
			$produto->__set('estMaxProd',$_POST['estMaxProd']);
			$produto->__set('classeProd',$_POST['classeProd']);
			$produto->__set('idUsuario',$_POST['idUsuario']);
			$produto->salvarProd();
			echo '<script>history.go(-1);</script>';
			//$this->render('produtos');
			//header("Location: /produtos");
		}
		public function editProd(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('codProd',$_POST['codProd']);
			$produto->__set('descProd',$_POST['descProd']);
			$produto->__set('tamProd',$_POST['tamProd']);
			$produto->__set('estMinProd',$_POST['estMinProd']);
			$produto->__set('estMaxProd',$_POST['estMaxProd']);
			$produto->__set('classeProd',$_POST['classeProd']);
			$produto->__set('idUsuario',$_POST['idUsuario']);
			$produto->editarProd();
			//$this->render('produtos');
			//header("Location: /produtos");
			echo '<script>history.go(-1);</script>';
		}
		public function deletaProd(){
			$this->validaAutenticacao();
			$codProd = isset($_GET['codProd']) ? $_GET['codProd'] :'';
			$delProd= isset($_GET['delProd']) ? $_GET['delProd'] :'';
			$rprod = Container::getModel("produto");

			if($delProd== 'deleta'){
				$rprod->deletaProd($codProd);
			}
			//header('location:/produtos');
			echo '<script>history.go(-1);</script>';
		}
		public function ativaProd(){
			$this->validaAutenticacao();
			$codProd = isset($_GET['codProd']) ? $_GET['codProd'] :'';
			$delProd= isset($_GET['atiProd']) ? $_GET['atiProd'] :'';
			$aprod = Container::getModel("produto");

			if($delProd== 'ativa'){
				$aprod->ativaProd($codProd);
			}
			//header('location:/produtos');
			echo '<script>history.go(-1);</script>';
		}
		public function exibeEstq(){
			$this->validaAutenticacao();
			$produto=Container::getModel('produto');

		//Historico Estoque
			$totalRegistrosPaginaHE = 10;
	 		$deslocamentoHE = 0;
	 		$paginaHE=isset($_GET['paginaHE']) ? $_GET['paginaHE'] :1;
	 		$deslocamentoHE=($paginaHE -1)*$totalRegistrosPaginaHE;
	 	//metade da paginação
	 		$produtosHE = $produto->getPorPaginaHE($totalRegistrosPaginaHE, $deslocamentoHE);	 		
	 		$totalProdutosHE=$produto->getTotalRegistrosHE();
	 	//Historico Saídas
	 		$totalRegistrosPaginaS = 10;
	 		$deslocamentoS = 0;
	 		$paginaS=isset($_GET['paginaS']) ? $_GET['paginaS'] :1;
	 		$deslocamentoS=($paginaS -1)*$totalRegistrosPaginaS;
	 	//metade da paginação
	 		$produtosS = $produto->getPorPaginaS($totalRegistrosPaginaS, $deslocamentoS);	 	
	 		$totalProdutosS=$produto->getTotalRegistrosS();
	 	//Histórico entrada
	 		$totalRegistrosPaginaE = 10;
	 		$deslocamentoE = 0;
	 		$paginaE=isset($_GET['paginaE']) ? $_GET['paginaE'] :1;
	 		$deslocamentoE=($paginaE -1)*$totalRegistrosPaginaE;
	 	//metade da paginação
	 		$produtosE = $produto->getPorPaginaE($totalRegistrosPaginaE, $deslocamentoE);	 	
	 		$totalProdutosE=$produto->getTotalRegistrosE();
	 	//finalização da paginação
			$this->view->totalPaginasHE=ceil($totalProdutosHE['total']/$totalRegistrosPaginaHE);			
			$this->view->paginaAtivaHE=$paginaHE;
	 		$this->view->produtosHE=$produtosHE;
	 	//finalização da paginação
	 		$this->view->totalPaginaS=ceil($totalProdutosS['total']/$totalRegistrosPaginaS);			
			$this->view->paginaAtivaS=$paginaS;
	 		$this->view->produtosS=$produtosS;
	 	//finalização da paginação
	 		$this->view->totalPaginasE=ceil($totalProdutosE['total']/$totalRegistrosPaginaE);			
			$this->view->paginaAtivaE=$paginaE;
	 		$this->view->produtosE=$produtosE;
	 	//inicio de outros parametros.
	 		$produtosC=$produto->getAllProdutosC();
	 		$this->view->produtosC=$produtosC;
	 		

	 	//rendenização da página.
			$this->render('estoque');
		}
		public function postEntEstq(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('codProd',$_POST['codProd']);
			$produto->__set('qtde',$_POST['qtde']);
			$produto->__set('vlrUnitCom',$_POST['vlrUnitCom']);
			$produto->__set('idUsuario',$_POST['idUsuario']);
			$produto->salvarEntEstq();
			//$this->render('produtos');
			//header("Location: /produtos");
			echo '<script>history.go(-1);</script>';
		}
		public function postSaiEstq(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('codProd',$_POST['codProd']);
			$produto->__set('qtde',$_POST['qtde']);
			$produto->__set('vlrUnit',$_POST['vlrUnit']);
			$produto->__set('idUsuario',$_POST['idUsuario']);
			$produto->salvarSaiEstq();
			//$this->render('produtos');
			//header("Location: /produtos");
			echo '<script>history.go(-1);</script>';
		}
		public function cancelaEstq(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('codProd',$_POST['codProd']);
			$produto->__set('qtde',$_POST['qtde']);
			$produto->__set('vlrUnitCom',$_POST['vlrUnitCom']);
			$produto->__set('vlrUnitVen',$_POST['vlrUnitVen']);
			$produto->__set('idUsuario',$_POST['idUsuario']);
			$produto->cancelaEstq();
			//$this->render('produtos');
			//header("Location: /produtos");
			echo '<script>history.go(-1);</script>';
		}
		public function editEstq(){
			$this->validaAutenticacao();
			$produto= Container::getModel('produto');
			$produto->__set('codProd',$_POST['codProd']);
			$produto->__set('vlrUnitVen',$_POST['vlrUnitVen']);
			$produto->__set('idUsuario',$_POST['idUsuario']);
			$produto->salvaEdicaoEstq();
			//$this->render('produtos');
			//header("Location: /produtos");
			echo '<script>history.go(-1);</script>';
			
		}
	}
?>