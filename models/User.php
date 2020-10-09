<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Security;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var $password_repeat
     * Defining password_repeat field
     *
     * @var $rememberMe
     * Defining rememberMe field
     */
    public $password_repeat;
    public $rememberMe = true;

    public static function tableName()
    {
        return '{{%tbl_user}}';
    }

    /**
     * @var $password_repeat
     * password_repeat is not defined in the database, yet it act like a defined field
     *
     * @rule Defining rules
     * Since tbl_user has notNull fields, we need to defined them as required.
     * Email field must meet mail validation criteria
     * Password and password_repeat field value must be exactly similar else pop the error msg. We can change the error msg
     *
     * @return 'true' if all rules are satisfied
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['full_name', 'username', 'email', 'password', 'password_repeat'], 'required'],
            // rememberMe must be a boolean value
            ['email', 'email'],
            // password is validated by validatePassword()
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Password doesn't match"],
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string|$password received parameter
     * @return bool validate current user password with the received parameter
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    /**
     * @param string|$username received username
     * @return User|null search for the received username in the user db
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    /**
     * @param string $authKey
     * @return bool validate current user authKey
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->isNewRecord)
            {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->token_id = Yii::$app->security->generateRandomString();
            }
            if (isset($this->password))
            {
                $this->password = md5($this->password);
                return parent::beforeSave($insert);
            }
        }
        return true;
    }

}



