<?php 
namespace App\Models;
use MF\Model\Model;

class transacao extends Model{
	private $codProd;
	private $;
	private $;
	private $;
	function saidaProd(){
		$query="insert into saidaproduto(codProdFk,qtde,vlrUnit) values (:codProd, :qtde, :vlrUnit )";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':codProd', $this->__get("codProd"));
		$stmt->bindValue(':qtde', $this->__get("qtde"));
		$stmt->bindValue(':vlrUnit', $this->__get("vlrUnit"));
		$stmt->execute();
		return $this;
		$this::atualizaEstoqueVenda();
	}
	function atualizaEstoqueVenda(){
		$query="if(select codProdFk from estoque where :codProdFk > 0 )
		begin
			update estoque(
				codProdFk,qtde,vlrUnit
			)values((
				select codProd from produto where codProd = :codProd
				), 
				qtde - (
					select qtde from saidaproduto where codProdFk = :codProdFk
				), 
				:vlrProd
			)
		end
		else
		begin
			insert into estoque(codProdFk,qtde,vlrUnit) values ((select codProd from produto where codProd = :codProd), qtde - (select qtde from saidaproduto where codProdFk = :codProdFk), :vlrProd)
		end";
			$stmt= $this->db->prepare($query);
		$stmt->bindValue(':codProd', $this->__get("codProd"));
		$stmt->bindValue(':qtde', $this->__get("qtde"));
		$stmt->bindValue(':vlrUnit', $this->__get("vlrUnit"));
		$stmt->execute();
		return $this;
	}
	function entradaProd(){  // antes da entrada tem que ter a query inserindo status, descProd estMinProd estMaxProd idUsuarioFK (tudo da tabela Produto)
		$query="insert into entradaProduto(codProdFk,qtde,vlrUnit) values (:codProd, :qtde, :vlrUnit )";
			$stmt= $this->db->prepare($query);
		$stmt->bindValue(':codProd', $this->__get("codProd"));
		$stmt->bindValue(':qtde', $this->__get("qtde"));
		$stmt->bindValue(':vlrUnit', $this->__get("vlrUnit"));
		$stmt->execute();
		return $this;
		$this::atualizaEstoqueCompra();
	}
	function atualizaEstoqueCompra(){
		$query="if(select codProdFk from estoque where :codProdFk > 0 )
		begin
			update estoque(
				codProdFk,qtde,vlrUnit
			)values((
				select codProd from produto where codProd = :codProd
				), 
				qtde + (
					select qtde from entradaProduto where codProdFk = :codProdFk
				), 
				:vlrProd
			)
		end
		else
		begin
			insert into estoque(codProdFk,qtde,vlrUnit) values ((select codProd from produto where codProd = :codProd), qtde + (select qtde from entradaProduto where codProdFk = :codProdFk), :vlrProd)
		end";
			$stmt= $this->db->prepare($query);
		$stmt->bindValue(':codProd', $this->__get("codProd"));
		$stmt->bindValue(':qtde', $this->__get("qtde"));
		$stmt->bindValue(':vlrUnit', $this->__get("vlrUnit"));
		$stmt->execute();
		return $this;
	}
}
/* Desenhando a manipulação de dados ;
	1º pegar os dados inseridos no formulário (Código do produto, quantidade comprada, qtd em estoque)
	2º inserir esses dados em 
 */
?>


