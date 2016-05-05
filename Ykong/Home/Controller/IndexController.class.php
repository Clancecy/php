<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;

define('APPID', 'h6ldLeFlpTADwU5NHvDif2');
define('APPKEY', 'z3tpQNHVGe7iu6exjI4fB3');
define('MASTERSECRET', 'mqcAxRvojc8cQ2y1fAj2rA');
define('HOST', 'http://sdk.open.api.igexin.com/apiex.htm');
define('DEVICETOKEN', '');

class IndexController extends Controller
{
    public function index()
    {
        $this->display("user/index");
    }

    public function model()
    {
        $user = D('user');
        $map = $user->create();
        $data = $user->field("clientid")->where($map)->select();
        var_dump($data);
    }

    public function GetXY()
    {
        $Point = D('Phone');
        $data = $Point->field("x,y,position")->where("No=1")->find();
        echo(json_encode($data));

    }

    public function SetXY()
    {
        $phone = D('Phone');
        $data = $phone->create();
        $phone->save($data);
        echo '1';
    }

    public function pushMessageToSingle($template, $client)
    {
        import('Vendor/GeTui/IGeTui');
        import('Vendor/GeTui/igetui/IGt.AppMessage.php');
        import('Vendor/GeTui/igetui/IGt.APNPayload.php');
        import('Vendor/GeTui/igetui/template/IGt.BaseTemplate.php');
        import('Vendor/GeTui/IGtBatch');
        $igt = new \IGeTui(HOST, APPKEY, MASTERSECRET);
        // $template = $this->IGtNotificationTemplateDemo();

        //个推信息体
        $message = new \IGtSingleMessage();
        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
        $message->set_data($template);//设置推送消息类型
        //	$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
        //接收方
        $target = new \IGtTarget();
        $target->set_appId(APPID);
        $target->set_clientId($client);
        $rep = $igt->pushMessageToSingle($message, $target);
        return $rep;

    }


    function IGtTransmissionTemplateDemo()
    {
        import('Vendor/GeTui/IGeTui');
        import('Vendor/GeTui/igetui/IGt.AppMessage.php');
        import('Vendor/GeTui/igetui/IGt.APNPayload.php');
        import('Vendor/GeTui/igetui/template/IGt.BaseTemplate.php');
        import('Vendor/GeTui/IGtBatch');
        $template = new \IGtTransmissionTemplate();
        //应用appid
        $template->set_appId(APPID);
        //应用appkey
        $template->set_appkey(APPKEY);
        //透传消息类型
        $template->set_transmissionType(0);
        //透传内容
        $template->set_transmissionContent("测试离线");
        return $template;
    }


    public function often()
    {
        $often = D("often");
        $phone = D("phone");
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $mark['mark'] = "often";
            $path = $often->field("path")->where("id='$id'")->find();
            $mark['path'] = $path['path'];
            if ($id == 1)
                $mark['type'] = "picture";
            if ($id == 2)
                $mark['type'] = "document";
            if ($id == 3)
                $mark['type'] = "video";
            if (!$often->where("tid='$id'")->find())
                $this->pushtree($mark);
            if (!$often->where("tid='$id'")->find()) {
                $read = $phone->field("often")->where("No=1")->find();
                while (!$read["often"]) {
                    $read = $phone->field("often")->where("No=1")->find();
                }
            }
            $data['No'] = 1;
            $data['often'] = 0;
            $phone->save($data);
        }

        $data = $often->where("tid='$id'")->select();
        echo json_encode($data);

    }

    public function tree()
    {
        $tree = D("tree");
        $phone = D("phone");
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $path = $tree->field("path")->where("id='$id'")->find();
            $mark['mark'] = "tree";
            $mark['path'] = $path['path'];
            if (!$tree->where("tid='$id'")->find())
                $this->pushtree($mark);
            if (!$tree->where("tid='$id'")->find()) {
                $read = $phone->field("read")->where("No=1")->find();
                while (!$read["read"]) {
                    $read = $phone->field("read")->where("No=1")->find();
                }
            }
            $data['No'] = 1;
            $data['read'] = 0;
            $phone->save($data);
        }

        $data = $tree->where("tid='$id'")->select();
        echo json_encode($data);
    }

    public function before()
    {
        $phone = D("phone");
        $tree = D("tree");
        $data['text'] = "手机存储";
        $data['tid'] = 0;
        $data['state'] = "closed";
        $data['path'] = "/storage/sdcard0";
        if (!$tree->where($data)->find())
            $tree->add($data);
        $data['text'] = "SD卡";
        $data['path'] = "/storage/sdcard1";
        if (!$tree->where($data)->find())
            $tree->add($data);

        $data['No'] = 1;
        $data['read'] = 0;
        $phone->save($data);
    }

    public function pushtree($data)
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
            return;
        } else {
            $GeTuiPush = A('index');
            $template = $GeTuiPush->IGtTransmissionTemplateDemo();
            $template->set_transmissionContent(json_encode($data));
            $GeTuiPush->pushMessageToSingle($template, $CID['ClientID']);
        }
    }

    public function addtree()
    {
        $tree = D('tree');
        $data = $tree->create();
        $parent['path'] = $_POST['parent'];
        if (!$tree->where($data)->find()) {
            if ($data['tid'] == 0) {
                $tree->add($data);
            } else if ($data['tid'] == 1) {
                $tid = $tree->field('id')->where($parent)->find();
                if ($tid) {
                    $data['tid'] = $tid['id'];
                    $tree->add($data);
                }
            }
        }
    }

    public function addoften()
    {
        $often = D('often');
        $data = $often->create();
        if (!$often->where($data)->find()) {
            $often->add($data);
        }

    }

    public function setread()
    {
        $phone = D("phone");
        $data['No'] = 1;
        $data['read'] = $_POST['read'];
        if ($phone->save($data)) {
            echo '1';
        }

    }

    public function setoften()
    {
        $phone = D("phone");
        $data['No'] = 1;
        $data['often'] = $_POST['often'];
        if ($phone->save($data)) {
            echo '1';
        }

    }


    public function send()
    {
        $str = $this->get_random_code(4, 7);
        $email = "1260413122@qq.com";  //PS:这不两会嘛，反映民情给胡主席的邮件~~
        $title = 'CUG_ACE--密码重置';  //标题
        $content = "你的密码是：" . $str . ",不要告诉别人哦！
         如果不是你的操作，请忽略！";  //邮件内容
        $user = D("user");
        if ($data = $user->where("Email='$email'")->find()) {

            if ($re = SendMail($email, $title, $content)) //直接调用发送即可
            {
                $data['Passwd'] = $str;
                if ($user->save($data)) {
                    echo "1";
                }
            } else {
                echo "邮件发送失败，请重试！";
            }
        } else {
            echo $email . "你输入的邮箱错误!请确认你的邮箱";
        }

    }



//      @desc  im:取得随机字符串
//      @param (int)$length = 4 #随机字符长度，默认为4
//      @param (int)$mode = 0 #随机字符类型，0为大小写英文和数字，1为数字，2为小写字母，3为大写字母，4为大小写字母，5为大写字母和数字，6为小写字母和数字
//      return 返回：取得的字符串

    function get_random_code($length = 4, $mode = 0)
    {
        switch ($mode) {
            case "1":
                $str = "1234567890";
                break;
            case "2":
                $str = "abcdefghijklmnopqrstuvwxyz";
                break;
            case "3":
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
            case "4":
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                break;
            case "5":
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
                break;
            case "6":
                $str = "abcdefghijklmnopqrstuvwxyz1234567890";
                break;
            default:
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
                break;
        }
        $result = "";
        $l = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            $num = rand(0, $l - 1); //如果$i不减1,将不一定生成4位数, 因为$num = rand(0,10).会随机产生10,$str[10] 为空
            $result .= $str[$num];
        }
        return $result;
    }


    public function Del()
    {
        $often=D("often");
        $tree=D("tree");
        $map['text']=$_POST['text'];
        $id1=$often->where($map)->find();
        $del1['tid']=$id1['No'];
        $mark['mark'] = "del";
        $mark['delPath'] = $id1['path'];
        if(!empty($mark['delPath']))
        {
            $this->pushtree($mark);
        }
        if($often->where($del1)->delete())
        {
            if($often->where($map)->delete())
            {
                echo "文件夹";
            }
            else{
                echo "error";
            }
        }else
        {
            if($often->where($map)->delete())
            {
                echo "单个文件";
            }
            else{
                echo "error2";
            }
        }

    }
}