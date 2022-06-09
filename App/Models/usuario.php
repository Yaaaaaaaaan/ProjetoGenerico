<?php
namespace App\Models;
use MF\Model\Model;
class Usuario extends Model{
	private $id;
	private $email;
	private $nome;
	private $nick;
	private $senha;
	public function __get($atributo){
		return $this->$atributo;
	}
	public function __set($atributo,$valor){
		$this->$atributo=$valor;
	}
	public function salvarNovoUsuario(){
		$query="BEGIN; 
		INSERT INTO usuario (nomeUsuario,nickUsuario,emailUsuario,senhaUsuario) values (:nome,:nick,:email,:senha);
		INSERT INTO dadosUsFo (idDadosUsFoFk,rankDados) VALUES (last_insert_id(), '1');
		INSERT INTO historico (nomeTablHist, codLinhaInfoHist, descHist, idUsuarioFkHist) VALUES ('usuario',last_insert_id(), 'Cadastro no sistema', last_insert_id());
		COMMIT;";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get("nome"));
		$stmt->bindValue(':nick', $this->__get("nick"));
		$stmt->bindValue(':email', $this->__get("email"));
		$stmt->bindValue(':senha', $this->__get("senha"));
		$stmt->execute();
		return $this;
	}
	public function validarcadastro(){
		$valido = true;
		if(strlen($this->__get('nome')) <3){
			$valido=false;
		}
		if(strlen($this->__get('nick')) <3){
			$valido=false;
		}
		if(strlen($this->__get('email')) <3){
			$valido=false;
		}
		if(strlen($this->__get('senha')) <3){
			$valido=false;
		}
		return $valido;
	}
	public function getUsuarioPorEmail(){
		$query = "select nomeUsuario, nickUsuario, emailUsuario from usuario where emailUsuario= :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getUsuarioPorNick(){
		$query = "select nomeUsuario, nickUsuario, emailUsuario from usuario where nickUsuario= :nick";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nick', $this->__get('nick'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function autenticar(){
		$query= "select idUsuario, nomeUsuario, nickUsuario, emailUsuario, rankDados from usuario JOIN dadosUsFo on idUsuario = idDadosUsFoFk where senhaUsuario = :senha and (:email = nickUsuario OR emailUsuario = :email)";
		$stmt=$this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();
		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
		if($usuario['idUsuario'] !='' && $usuario['nomeUsuario'] != ''){ 
			$this->__set('id', $usuario['idUsuario']);
			$this->__set('nome', $usuario['nomeUsuario']);
			$this->__set('rank', $usuario['rankDados']);
			$query=" 
		INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('usuario',:id,'Login no sistema',:id)";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':id', $usuario['idUsuario']);
		$stmt->execute();
		return $this;
		}
		return $this;
	}
	public function sair(){
		$query=" 
		INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('usuario',:id,'Logout no sistema',:id)";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $this;
	}
	public function salvaNovaSenha(){
		$query="
			UPDATE usuario SET senhaUsuario = :newpass WHERE senhaUsuario = :oldpass;	 
			INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('usuario',:idUsuario,'Alteração de senha',:idUsuario)
				";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':newpass', $this->__get("newpass"));
		$stmt->bindValue(':oldpass', $this->__get("oldpass"));
		$stmt->bindValue(':idUsuario', $this->__get("idUsuario"));
		$stmt->execute();
		return $this;
	}
	public function validaNovaSenha(){
		$query= "select senhaUsuario,idUsuario from usuario where senhaUsuario = :oldpass and idUsuario = :idUsuario";
		$stmt=$this->db->prepare($query);
		$stmt->bindValue(':oldpass', $this->__get('oldpass'));
		$stmt->bindValue(':idUsuario', $this->__get('idUsuario'));
		$stmt->execute();
		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
		if(strlen($this->__get('newpass')) <3 || $usuario['senhaUsuario'] != $this->__get('oldpass')){
			$valido=false;
			return $valido;
		}else{
			$valido = true;
			return $valido;
		}	
	}
	public function salvarDadosUsuario(){
		$query="
			UPDATE dadosUsFo(
				cpfDadosUsFo,rgDadosUsFo,dataNasc
					) VALUES (:cpfUs,:rgUs,:dataNasc) WHERE idDadosUsFoFk = :idUsuario;
				INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('Dados de usuario',:idUsuario,'Inserção de dados',:idUsuario)
				";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':cpfUs', $this->__get("cpfUs"));
		$stmt->bindValue(':rgUs', $this->__get("rgUs"));
		$stmt->bindValue(':dataNasc', $this->__get("dataNasc"));
		$stmt->bindValue(':idUsuario', $this->__get("idUsuario"));
		$stmt->execute();
		return $this;
	}
	public function salvarDadosFornecedor(){
		$query="
		INSERT INTO fornecedor(
			nomeFornecedor)
			VALUES(:nomeForn);
			INSERT into dadosUsFo(
				cnpjDadosUsFo,codDadosUsFoFk,dataNasc
					) VALUES (:cnpjForn,last_insert_id(),:dataNasc); 
				INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('Dados de usuario',:idUsuario,'Inserção de dados',:idUsuario)
				";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':cpfUs', $this->__get("cpfUs"));
		$stmt->bindValue(':rgUs', $this->__get("rgUs"));
		$stmt->bindValue(':dataNasc', $this->__get("dataNasc"));
		$stmt->bindValue(':idUsuario', $this->__get("idUsuario"));
		$stmt->execute();
		return $this;
	}
	public function salvarConfigSistema(){
		$query="
		INSERT INTO configSistema(
			descConf, idUsuarioFkConfS)
			VALUES(:descConf,:idUsuarioFkConfS);
				INSERT INTO historico (nomeTablHist,codLinhaInfoHist,descHist,idUsuarioFkHist) values ('Configuração do sistema',:idUsuario,'Inserção de parâmetros',:idUsuario)
				";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':cpfUs', $this->__get("cpfUs"));
		$stmt->bindValue(':rgUs', $this->__get("rgUs"));
		$stmt->bindValue(':dataNasc', $this->__get("dataNasc"));
		$stmt->bindValue(':idUsuario', $this->__get("idUsuario"));
		$stmt->execute();
		return $this;
	}
}
?>