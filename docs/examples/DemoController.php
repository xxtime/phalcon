<?php

/**
 * @name    \App\Http\Controllers\DemoController.php
 * @package /ROOT/app/http/controller/DemoController.php
 */
namespace App\Http\Controllers;


use Phalcon\Mvc\Dispatcher;
use Phalcon\Filter;
use App\Http\Models\DemoModel;
use App\Providers\Components\Services;
use App\Providers\Components\Queue;
use Endroid\QrCode\QrCode;
use PHPGangsta_GoogleAuthenticator;

/**
 * @property \App\System\Language $lang
 */
class DemoController extends Controller
{

    private $demoModel;
    private $filterModel;


    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        // 在每一个找到的动作前执行
    }


    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        // 在每一个找到的动作后执行
    }


    // 防注入 @see https://docs.phalcon.io/4.0/zh-cn/escaper
    // 过滤器 @see https://docs.phalcon.io/4.0/zh-cn/filter
    // 收请求 @see https://docs.phalcon.io/4.0/zh-cn/request
    public function initialize()
    {
        // parent::initialize();
        $this->demoModel = new DemoModel();


        // 过滤器
        $this->filterModel = new Filter();
        $this->filterModel->add('dataFilter', function ($value) {
            return preg_replace('/[^0-9a-zA-Z_\-,.#@*:]/', '', $value);
        });
    }


    public function indexAction()
    {
        dump('Demo Page');
    }


    // @see https://docs.phalcon.io/4.0/zh-cn/db-models
    public function findAction()
    {
        $robots = $this->demoModel->find(
            array(
                "conditions" => "id >= :id:",
                "columns"    => "id, username,password",
                "order"      => "username DESC",
                "offset"     => 0,
                "limit"      => 10,
                "group"      => "id, username",
                "bind"       => array("id" => 1),
                //"cache" => array("lifetime" => 3600, "key" => "my-find-key") // 缓存结果集
            )
        );
        dump($robots->toArray());
        exit;


        // 也可以这样
        $robots = Robots::query()
            ->where("type = :type:")
            ->andWhere("year < 2000")
            ->bind(array("type" => "mechanical"))
            ->order("name")
            ->execute();


        // 单条记录
        $data = $this->demoModel->findFirst();

    }


    // 创建记录 更多形式参考save方法
    public function createAction()
    {
        // 方法一
        $this->demoModel->name = "Joe";
        $this->demoModel->age = "28";
        $this->demoModel->create();
        return $this->demoModel->id;
    }


    // 创建与更新记录
    public function saveAction()
    {
        // 方法一
        $this->demoModel->name = "Joe";
        $this->demoModel->age = "28";
        $this->demoModel->save();
        return $this->demoModel->id;


        // 方法二
        $this->demoModel->save(
            array(
                "type" => "people",
                "name" => "JoeChu",
                "year" => 1987
            )
        );


        // 方法三
        $this->demoModel->save($_POST);


        // 方法四
        $this->demoModel->save(
            $_POST,
            array(
                'name',
                'type'
            )
        );
    }


    public function demoAction()
    {
        $this->demoModel->demo();
    }


    // 过滤器
    public function filterAction()
    {
        $data = $this->request->get('id');
        $data = $this->filterModel->sanitize($data, "dataFilter");
    }


    public function serviceAction()
    {
        $response = Services::pay('paypal')->notice();
        dump($response);
    }


    public function quequeAction()
    {
        $queue = new Queue();
        $queue->publish('queue.name', 'this is queue message');
    }


    // @see https://docs.phalcon.io/4.0/zh-cn/cookies
    public function cookiesAction()
    {
        $this->cookies->set('foo', 'some cookies', time() + 86400);
        $this->cookies->send();

        if ($this->cookies->has('foo')) {
            $value = $this->cookies->get('foo')->getValue();
        }
        dd($value);
    }


    // @see https://docs.phalcon.io/4.0/zh-cn/volt
    public function templateAction()
    {
        $this->view->data = time();
        $this->view->pick("demo/template");
    }


    public function qrAction()
    {
        // 生成二维码
        $username = urlencode('账号：') . 'joe@xxtime.com';
        $secretKey = 'DPI45HCE';
        $url = "otpauth://totp/{$username}?secret={$secretKey}&issuer=" . urlencode('XXTIME.COM');
        $qrCode = new QrCode();
        $qrCode
            ->setText($url)
            ->setSize(200)
            ->setPadding(10)
            ->setErrorCorrection('low')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            //->setLabel('xxtime.com')
            //->setLabelFontSize(8)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        header('Content-Type: ' . $qrCode->getContentType());
        $qrCode->render();
        exit;


        // 验证
        $totp = new PHPGangsta_GoogleAuthenticator();
        $secretKey = $totp->createSecret(32);
        $oneCode = $totp->getCode($secretKey);
        $checkResult = $totp->verifyCode($secretKey, $oneCode, 2);    // 2 = 2*30sec clock tolerance
        if ($checkResult) {
            echo 'OK';
            dd($secret, $oneCode);
        }
        else {
            echo 'FAILED';
        }
        exit;
    }


    // @see https://docs.phalcon.io/4.0/zh-cn/translate
    // @see /ROOT/app/System/Language.php
    public function translatorAction()
    {
        // method one
        $this->lang->t('hi', ['name' => 'Joe Chu']);
        // method two
        $this->lang->_('hi', ['name' => 'Joe Chu']);

        // also can write like this
        // $this->view->text = $this->locale;           // in the controller
        // {{text._('hi', ['name' => 'Joe Chu'])}}      // in the view file
        // {{text->_('hi', ['name' => 'Joe Chu'])}}     // in the view file
    }


    // PHP gettext
    // @see http://php.net/manual/en/book.gettext.php
    //
    // $lang = 'zh_CN';
    // setlocale(LC_ALL, $lang);
    // $domain = $lang;
    // bind_textdomain_codeset($domain, 'UTF-8');
    // bindtextdomain($domain, APP_DIR . '/locale');
    // textdomain($domain);

}
