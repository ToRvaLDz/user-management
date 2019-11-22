<?php
namespace webvimark\modules\UserManagement\models\forms;

use webvimark\helpers\LittleBigHelper;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\UserTokens;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\base\Model;
use Yii;

class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe = false;

	private $_user = false;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'password'], 'required'],
			['rememberMe', 'validateRememberMe'],
			['password', 'validatePassword'],

			['username', 'validateIP'],
		];
	}

    public function validateRememberMe()
    {
        switch ($this->rememberMe){
            case true:
            case 'on':
            case 'true':
                return true;
                break;
            default:
                return false;
        }
    }

	public function attributeLabels()
	{
		return [
			'username'   => UserManagementModule::t('front', 'Username'),
			'password'   => UserManagementModule::t('front', 'Password'),
			'rememberMe' => UserManagementModule::t('front', 'Remember me'),
		];
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 */
	public function validatePassword()
	{
		if ( !Yii::$app->getModule('user-management')->checkAttempts() )
		{
			$this->addError('password', UserManagementModule::t('front', 'Too many attempts'));

			return false;
		}

		if ( !$this->hasErrors() )
		{

			$user = $this->getUser();
			if(array_key_exists('ldap',yii::$app->components) && array_key_exists('options',yii::$app->components['ldap']) && count(yii::$app->components['ldap']['options'])>0) {
                if ($this->username === 'superadmin') {
                    $nonvalido = !$user || !$user->validatePassword($this->password);
                } else {
                    $nonvalido = !$user || !\Yii::$app->ldap->authenticate($this->username, $this->password);
                }
            }else{
                $nonvalido = !$user || !$user->validatePassword($this->password);
            }

			if ($nonvalido)
			{
				$this->addError('password', UserManagementModule::t('front', 'Incorrect username or password.'));
			}
		}
	}

	/**
	 * Check if user is binded to IP and compare it with his actual IP
	 */
	public function validateIP()
	{
		$user = $this->getUser();

		if ( $user AND $user->bind_to_ip )
		{
			$ips = explode(',', $user->bind_to_ip);

			$ips = array_map('trim', $ips);

			if ( !in_array(LittleBigHelper::getRealIp(), $ips) )
			{
				$this->addError('password', UserManagementModule::t('front', "You could not login from this IP"));
			}
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
        if(array_key_exists('jwt',yii::$app->components)) {
            if (!array_key_exists('jwt_expire', yii::$app->params) || !array_key_exists('jwt_issuer', yii::$app->params) || !array_key_exists('jwt_audience', yii::$app->params) || !array_key_exists('jwt_id', yii::$app->params)) {
                throw new \yii\web\HttpException(500,UserManagementModule::t('front', 'jwt_issuer/jwt_audience/jwt_id params not found in yii::$app->params'));
            }
        }
		if ( $this->validate() )
		{
			if(Yii::$app->user->login($this->getUser(), $this->rememberMe ? Yii::$app->user->cookieLifetime : 0)){
                if($this->rememberMe && array_key_exists('jwt',yii::$app->components)){
                    /** @var Jwt $jwt */
                    $jwt = Yii::$app->jwt;
                    $signer = $jwt->getSigner('HS256');
                    $key = $jwt->getKey();
                    $time = time();

                    $token = $jwt->getBuilder()
                        ->issuedBy(yii::$app->params['jwt_issuer'])// Configures the issuer (iss claim)
                        ->permittedFor(yii::$app->params['jwt_audience'])// Configures the audience (aud claim)
                        ->identifiedBy(yii::$app->params['jwt_id'], true)// Configures the id (jti claim), replicating as a header item
                        ->issuedAt($time)// Configures the time that the token was issue (iat claim)
                        ->expiresAt($time + yii::$app->params['jwt_expire'])// Configures the expiration time of the token (exp claim)
                        ->withClaim('uid', $this->id)// Configures a new claim, called "uid"
                        ->getToken($signer, $key); // Retrieves the generated token

                    $tokens= new UserTokens;
                    $tokens->user_id=$this->id;
                    $tokens->token=(string) $token;
                    $tokens->save();
                    return $tokens->token;
                }
            }else{
			    return true;
            }
		}
		else
		{
			return false;
		}
	}

	/**
	 * Finds user by [[username]]
	 * @return User|null
	 */
	public function getUser()
	{
		if ( $this->_user === false )
		{
			$u = new \Yii::$app->user->identityClass;
			$this->_user = ($u instanceof User ? $u->findByUsername($this->username) : User::findByUsername($this->username));
		}

		return $this->_user;
	}
}
