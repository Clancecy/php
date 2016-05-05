<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;

class UserController extends Controller
{
    public function index()
    {
        $this->display();
    }

    public function FindCID()
    {
        $user = D('user');
        $map = $user->create();
        $data = $user->field("ClientID")->where($map)->find();
        var_dump($data['ClientID']);
    }

    public function Add()
    {
        $user = D('user');
        $data['ClientID'] = $_POST["ClientID"];
        if (!($user->where($data)->find())) {
            $user->add($user->create());
            echo '1';
        } else {
            echo '2';
        }
    }

    public function SaveUs()
    {
        $user = D('user');
        $data = $user->create();
        $map['ClientID'] = $data['ClientID'];
        $data['No'] = (int)$user->field('No')->where($map)->find();
        var_dump($data);
        var_dump($user->save($data));
    }


    public function Push()
    {
        import('Vendor/GeTui/IGeTui');
        import('Vendor/GeTui/igetui/IGt.AppMessage.php');
        import('Vendor/GeTui/igetui/IGt.APNPayload.php');
        import('Vendor/GeTui/igetui/template/IGt.BaseTemplate.php');
        import('Vendor/GeTui/IGtBatch');

        $user = D('user');
        $CID = $user->field("ClientID")->where("No=1")->find();
        // var_dump($CID['ClientID']);
        if (!$CID) {
            echo 'error';
            return;
        } else {
            $GeTuiPush = A('index');
            $template = $GeTuiPush->IGtTransmissionTemplateDemo();
            $GeTuiPush->pushMessageToSingle($template, $CID['ClientID']);
            echo '成功！';
        }
    }

    public function CheckName()
    {
        $user = D('user');
        $map['Name'] = $_POST['Name'];
        if ($user->where($map)->find()) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function Checkuser()
    {
        $user = D('user');
        $data = $user->create();
        if ($result = $user->field("No,Email")->where($data)->find()) {
            $_SESSION['user_id'] = $result['No'];
            $_SESSION['email'] = $result['Email'];
            $_SESSION['Name'] = $data['Name'];
            echo "1";
        }

    }

    public function Logout()
    {
        if (!empty($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            $_SESSION = array();
            session_destroy();
            $this->assign('jumpUrl', 'index');
            $this->success('登出成功');
        } else {
            $this->error('已经登出了');
        }
    }

    public function getsession()
    {
        echo $_SESSION['user_id'];
    }

    public function Map()
    {
        $this->display(Map);
    }

}