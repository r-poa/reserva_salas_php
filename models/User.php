<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\web\IdentityInterface;

class User extends \yii\base\BaseObject implements IdentityInterface
{
    public $id;
    public $login;	
    public $username;
    public $nome;	
    public $e_mail;
    public $setor;	
 
    public $authKey;
    public $accessToken;
    public $isGestor = false;


    private static function getUserData($username)
    {
        return (new Query())
            ->select(['login', 'nome', 'e_mail', 'setor'])
            ->from('logins_usuarios')
            ->where(['login' => $username])
            ->one();
    }

		public static function findIdentity($id)
		{
			$userData = self::getUserData($id);
			if ($userData) {
				$user = new static($userData);
				$user->id = $user->login; // Aqui o ID será o login
				return $user;
			}
			return null;
		}

		public function getId()
		{
			return $this->id; // Retorna a string login
		}




    public function autentica_usuario($password)
    {
		
		            Yii::warning('Autenticação LDAP pulada em ambiente de desenvolvimento.');
            return true;
		
		/*
        // Se o usuário não existir na tabela, não prossiga
        if (empty($this->username)) {
            return false;
        }

        // Simulação do ldap_bind para fins de desenvolvimento
        // Em um ambiente de produção, substitua isso pela chamada real ao LDAP
        $ldap_conn = @ldap_connect("LDAP.EMPRESA");
        if ($ldap_conn) {
            // O bind com '@' suprime warnings em caso de falha,
            // que é o comportamento esperado para senhas incorretas.
            if (@ldap_bind($ldap_conn, $this->username, $password)) {
                ldap_close($ldap_conn);
                return true;
            }
            ldap_close($ldap_conn);
        }
*/
        // Fallback para desenvolvimento sem LDAP: aceita a senha se for igual ao login
        if (YII_ENV_DEV && $this->username === $password) {
            Yii::warning('Autenticação LDAP pulada em ambiente de desenvolvimento.');
            return true;
        }
        
        return false;
    }


/*
 
    public static function findIdentity($id)
    {
        $userData = self::getUserData($id);
        return $userData ? new static($userData) : null;
    }
 */

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // Não implementado
    }

    public static function findByUsername($username)
    {
        $userData = self::getUserData($username);
        if ($userData) {
            require_once(Yii::getAlias('@app/_configuracoes.php'));
            $user = new static($userData);
            $user->id = $userData['login'];
            $user->username = $userData['login'];
            
            global $lista_gestores;
	 

			
            if (in_array($user->username, $lista_gestores)) {
                $user->isGestor = true;
            }
            
            return $user;
        }
        return null;
    }

 

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}