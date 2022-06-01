<?php
namespace App\Models;
use MF\Model\Model;
error_reporting(E_ALL|E_STRICT);
class Produto extends Model{
	private $codProd;
	private $descProd;
	private $tamProd;
	private $estMinProd;
	private $estMaxProd;
	private $classe;
	private $idUsuario;

	public function __get($atributo){
		return $this->$atributo;
	}
	public function __set($atributo, $valor){
		$this->$atributo = $valor;
	}
	public function salvarClasse(){
		$query ="
		BEGIN;
			INSERT INTO classeProd(classeBase,classeDivisao,idUsuarioFkClass) VALUES(:classeBase,:classeDivisao,:idUsuarioFkClass);
			INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('classe',last_insert_id(),'nova classe',:idUsuarioFkProd);
			COMMIT;";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':classeBase',$this->__get('classeBase'));
		$stmt->bindValue(':classeDivisao',$this->__get('classeDivisao'));
		$stmt->bindValue(':idUsuarioFkClass',$this->__get('idUsuarioFkClass'));
		$stmt->execute();
		return $this;
	}
	public function salvarProd(){
		$query ="
			INSERT INTO produto(descProd,tamProd,estMinProd,estMaxProd,classeProd,idUsuarioFkProd) VALUES(:descProd,:tamProd,:estMinProd,:estMaxProd,:classeProd, :idUsuarioFkProd);
			INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('produto',last_insert_id(),'novo produto',:idUsuarioFkProd);
			";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':descProd',$this->__get('descProd'));
		$stmt->bindValue(':tamProd',$this->__get('tamProd'));
		$stmt->bindValue(':estMinProd',$this->__get('estMinProd'));
		$stmt->bindValue(':estMaxProd',$this->__get('estMaxProd'));
		$stmt->bindValue(':classeProd',$this->__get('classeProd'));
		$stmt->bindValue(':idUsuarioFkProd',$this->__get('idUsuario'));
		$stmt->execute();
		return $this;
	}
	public function editarProd(){
		$query ="
		BEGIN;
			update produto set descProd= :descProd ,tamProd= :tamProd ,estMinProd= :estMinProd ,estMaxProd= :estMaxProd ,classeProd= :classeProd where codProd= :codProd;
			insert into historico(nomeTablHist, codLinhaInfoHist, descHist, idUsuarioFkHist) values('produto',:codProd, 'Alteração de dados', :idUsuario);
			COMMIT;";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':codProd',$this->__get('codProd'));
		//$stmt->bindValue(':statusProd',$this->__get('statusProd'));
		$stmt->bindValue(':descProd',$this->__get('descProd'));
		$stmt->bindValue(':tamProd',$this->__get('tamProd'));
		$stmt->bindValue(':estMinProd',$this->__get('estMinProd'));
		$stmt->bindValue(':estMaxProd',$this->__get('estMaxProd'));
		$stmt->bindValue(':classeProd',$this->__get('classeProd'));
		$stmt->bindValue(':idUsuario',$this->__get('idUsuario'));
		$stmt->execute();
		return $this;
	}	
	/*public function getAllProduto(){ 
		$query="
			select 
				codProd,statusProd,descProd,tamProd,estMinProd,estMaxProd,classeProd,idUsuarioFkProd
			from 
				produto 
			order by
				codProd
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}*/

	public function getPorPagina($limit, $offset){
		$query="
			select 
				codProd,statusProd,descProd,tamProd,estMinProd,estMaxProd,classeProd,idUsuarioFkProd
			from 
				produto
			where 
				statusProd = 'A'
			order by
				codProd asc
				limit
					$limit
				offset
					$offset
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getTotalRegistros(){
		$query="
			select 
				count(*) as total 
				from 
				produto
				WHERE statusProd ='A'	
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function getPorPaginaI($limit, $offset){
		$query="
			select 
				codProd,statusProd,descProd,tamProd,estMinProd,estMaxProd,classeProd,idUsuarioFkProd
			from 
				produto
			where 
				statusProd = 'I'
			order by
				codProd asc
				limit
					$limit
				offset
					$offset
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getTotalRegistrosI(){
		$query="
			select 
				count(*) as total 
				from 
				produto
				WHERE statusProd ='I'	
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function ativaProd($codProd){
		$query = "
			BEGIN;
				update produto set statusProd = 'A' where codProd = :codProd;
				insert into historico(nomeTablHist, codLinhaInfoHist, descHist, idUsuarioFkHist) values('produto',:codProd, 'Ativação de produto', :idUsuario);
			COMMIT;";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':codProd', $codProd);
			$stmt->bindValue(':idUsuario',$_SESSION['id']);
			$stmt->execute();
			return true;
	}
	public function deletaProd($codProd){
		$query = "
			BEGIN;
				update produto set statusProd = 'I' where codProd = :codProd;
				insert into historico(nomeTablHist, codLinhaInfoHist, descHist, idUsuarioFkHist) values('produto',:codProd, 'Inativação de produto', :idUsuario);
			COMMIT;";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':codProd', $codProd);
			$stmt->bindValue(':idUsuario',$_SESSION['id']);
			$stmt->execute();
			return true;
	}
	public function getAllProdutosC(){ 
		$query="
			select 
				codProd,descProd,tamProd
			from 
				produto where statusProd='A'
			order by
				codProd
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function salvarEntEstq(){
		$query="
			BEGIN;
			INSERT INTO entradaProduto(codProdFkEnt,qtde,vlrUnit,idUsuarioFkEnt) VALUES (:codProd,:qtde,:vlrUnitCom, :idUsuario); 
			
			INSERT INTO estoque(codProdFkEst,qtde,vlrUnitCom) VALUES(:codProd,:qtde,:vlrUnitCom) ON DUPLICATE KEY UPDATE qtde=(qtde+ :qtde), vlrUnitCom=:vlrUnitCom;

			INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist)
				VALUES('entradaProduto',last_insert_id(),'Entrada de estoque',:idUsuario);
			COMMIT;";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':codProd',$this->__get('codProd'));
		$stmt->bindValue(':qtde',$this->__get('qtde'));
		$stmt->bindValue(':vlrUnitCom',$this->__get('vlrUnitCom'));
		$stmt->bindValue(':idUsuario',$this->__get('idUsuario'));
		$stmt->execute();
		return $this;
	}
	public function salvaEdicaoEstq(){
		$query ="
		COMMIT;
			UPDATE
				estoque SET vlrUnitVen = :vlrUnitVen WHERE codProdFkEst= :codProd;
				INSERT INTO historico(nomeTablHist, codLinhaInfoHist, descHist, idUsuarioFkHist, infoAnte) VALUES('estoque',:codProd, 'Alteração de preço de venda', :idUsuario,(SELECT vlrUnitVen from estoque WHERE codLinhaInfoHist = codProd));
				BEGIN;
			";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':vlrUnitVen',$this->__get('vlrUnitVen'));
		$stmt->bindValue(':codProd',$this->__get('codProd'));
		$stmt->bindValue(':idUsuario',$this->__get('idUsuario'));
		$stmt->execute(); 
		return $this;
	}	
	/*public function getAllProdutoEs(){ 
		//Por hora sem utilidade.
		$query="
			SELECT 
				P.codProd,P.descProd,P.tamProd,E.codProdFkEst,E.qtde,E.vlrUnit
			FROM 
				produto P
			INNER JOIN 
				estoque E ON P.codProd = E.codProdFkEst
			WHERE P.statusProd ='A' 
			order by
				P.codProd
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}*/

	public function getPorPaginaHE($limit, $offset){
		$query="
			SELECT 
				P.codProd,P.descProd,P.tamProd,P.estMinProd,P.estMaxProd,E.codProdFkEst,E.qtde,E.vlrUnitVen,E.vlrUnitCom,max(N.dataEnt)
			FROM 
				produto P
			INNER JOIN 
				estoque E ON P.codProd = E.codProdFkEst
			INNER JOIN
				entradaProduto N ON P.codProd = N.codProdFkEnt
			WHERE 
				P.statusProd = 'A'
			GROUP BY N.codProdFkEnt
			ORDER BY
				N.dataEnt desc
				LIMIT
					$limit
				OFFSET
					$offset
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getTotalRegistrosHE(){
		$query="
			select 
				count(*) as total 
				from 
				estoque	
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	/*public function getAllProdutoE(){ 
		$query="
			select 
				codProd,statusProd,descProd,tamProd,estMinProd,estMaxProd,classeProd,idUsuarioFkProd
			from 
				produto 
			order by
				codProd
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}*/

	public function getPorPaginaE($limit, $offset){
		//criar link no código, ou botão "exibir +", para assim listar os valores repetidos discriminados por código.
		$query="
			SELECT 
				P.codProd,P.descProd,P.tamProd,E.qtde,E.vlrUnitCom,N.codEntProd,N.codProdFkEnt,N.qtde,N.vlrUnit,N.dataEnt,N.idUsuarioFkEnt
			FROM 
				produto P
			INNER JOIN 
				estoque E ON P.codProd = E.codProdFkEst
			INNER JOIN
				entradaProduto N ON P.codProd = N.codProdFkEnt
			WHERE 
				P.statusProd = 'A'
			GROUP BY 
				N.codProdFkEnt
			ORDER BY
				P.codProd asc
				LIMIT
					$limit
				OFFSET
					$offset
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getTotalRegistrosE(){
		$query="
			select 
				count(*) as total 
				from 
				entradaProduto	
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/*public function getAllProdutoS(){ 
		$query="
			select 
				codProd,statusProd,descProd,tamProd,estMinProd,estMaxProd,classeProd,idUsuarioFkProd
			from 
				produto 
			order by
				codProd
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}*/

	public function getPorPaginaS($limit, $offset){
		$query="
			SELECT 
				P.codProd,P.descProd,P.tamProd,E.qtde,E.vlrUnitVen,S.codSaiProd,S.codProdFkSai,S.qtde,S.vlrUnit,S.dataSai,S.idUsuarioFkSai
			FROM 
				produto P
			INNER JOIN 
				estoque E ON P.codProd = E.codProdFkEst
			INNER JOIN
				saidaProduto S ON P.codProd = S.codProdFkSai
			WHERE 
				P.statusProd = 'A'
			ORDER BY
				P.codProd asc
				LIMIT
					$limit
				OFFSET
					$offset
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getTotalRegistrosS(){
		$query="
			select 
				count(*) as total 
				from 
				saidaProduto	
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
}
?>