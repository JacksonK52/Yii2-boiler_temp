<?php

namespace app\controllers;

use Yii;
use yii\db\Exception;
use yii\web\Controller;
use app\models\User;

class UserController extends Controller
{
    /**
     *
     * @if User already login
     * Redirect to homepage
     *
     * @if user didn't login
     * Link user model and pass model to register view
     *
     * @if username already exist return to registration with info msg
     * @if email already exist return to registration with info msg
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index.php?r=site');
        }

        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                // Check if user already exist or not
                $temp_username = User::findOne(['username' => $model->username]);
                if(!empty($temp_username)) {
                    Yii::$app->getSession()->setFlash('info', 'Username already exists. Please enter a different username');
                    return $this->redirect('index.php?r=user/register');
                }

                // Checking if email already exists
                $temp_email = User::findOne(['email' => $model->email]);
                if (!empty($temp_email))
                {
                    Yii::$app->getSession()->setFlash('info', 'Email already exists. Please enter a different email');
                    return $this->redirect('index.php?r=user/register');
                }

                $model->save();

                // Updating token_id
                $token = Yii::$app->security->generateRandomString();
                User::updateAll(['token_id' => $token], 'id  = ' .$model->id);

                // Email information
                $sent_to = 'info@mailtrap.io';
                $email_subject = 'no-reply: Email verification link';
                $email_body = '
                    Hello '.$model->full_name.'
                    <br><br>
                    Please click the below link to verify your account.
                    <br><br>
                    <a href="http://localhost/basic/web/index.php?r=site&token_id='.$model->token_id.'&auth_key='.$model->auth_key.'">http:://localhost.loc/varifylink</a>
                    <br><br>
                    Regards,
                    <br>
                    Team';

                if($this->sendEmail($sent_to, $email_subject, $email_body) === false) {
                    Yii::$app->session->setFlash('danger', 'Unable to sent email at the moment. Please try again later');
                    return $this->redirect('index.php?r=site/login');
                }

                Yii::$app->session->setFlash('success', 'Email verification link sent');
                return $this->redirect('index.php?r=site/login');
            }
        }

        return $this->render('register', [
            'model' => $model
        ]);
    }

    public function sendEmail($sent_to, $email_subject, $email_body) {
        try {
            Yii::$app->mailer->compose()
                ->setTo($sent_to)
                ->setFrom('recipient1@mailtrap.io')
                ->setSubject($email_subject)
                ->setHtmlBody($email_body)
                ->send();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

}
