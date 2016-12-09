<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $firstName
 * @property string $lastName
 * @property string $password
 * @property string $email
 * @property string $authKey
 * @property integer $role
 * @property string $verification_code
 */
class MisUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'firstName', 'lastName', 'password', 'email'], 'required'],
            [['role'], 'integer'],
            [['username', 'firstName', 'lastName', 'password', 'email'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 50],
            [['verification_code'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'password' => 'Password',
            'email' => 'Email',
            'authKey' => 'Auth Key',
            'role' => 'Role',
            'verification_code' => 'Verification Code',
        ];
    }

    public  static  function    findIdentity($id){
    return  static::findOne($id);
    }
    public  static  function    findIdentityByAccessToken($token, $type =   null){
        throw   new NotSupportedException();
        //I don't   implement   this    method  because I   don't   have    any access  token   column  in  my  database
    }
    public function getId(){
        return  $this->id;
    }
    public  function    getAuthKey(){
        return  $this->authKey;//Here   I   return  a   value   of  my  authKey column
    }
    public  function    validateAuthKey($authKey){
        return  $this->authKey  === $authKey;
    }
    public  static  function    findByUsername($username){
        return  self::findOne(['username'=>$username]);
    }
    public  function    validatePassword($password){
        return  Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    public function setPassword($password)
    {
        $this->password = static::hashPassword($password);
    }
    public static function hashPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    public static function isUserAdmin($id)
    {
        if(MisUser::findOne(['id'=>$id, 'role'=>20])){
            return true;
        } else {
            return false;
        }
    }

    public static function isUserSimple($id)
    {
        if(MisUser::findOne(['id'=>$id, 'role'=>10])){
            return true;
        }
        else{
            return false;
        }
    }
}
