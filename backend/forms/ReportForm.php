<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2019/3/13
 * Time: 11:23
 */

namespace backend\forms;



use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class ReportForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $reportFile;

    public $fileName;

    public $report;

    public $name;

    public $physicalPath;

    public $webPath;

    private $errorMsg;

    public function rules()
    {
        return [
            //@todo
//            maxsize;
            //提示错误信息
            [['reportFile'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'gif', 'txt', 'pdf']],
            [['name'], 'required']
        ];
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }

    /*
     * 上传文件
     */
    public function upload()
    {
        $dir = $this->createFolder();
        if ($dir === false) {
            $this->errorMsg = '文件夹创建失败';
            return false;
        }

        //文件名
        //替换原来的文件名称$this->reportFile->baseName
        //@todo 数据库保存文件名 大小 类型等字段

        $this->physicalPath = $dir .'/' . $this->fileName . '.' . $this->reportFile->extension;

//@todo        $this->fileName

        if (!$this->reportFile->saveAs($this->physicalPath)) {
            $this->errorMsg = '文件上传失败';
            return false;
        }

        return true;

    }

    /*
     * 创建日期命名的文件夹
     */
    public function createFolder() {
        $date =  date('Ymd');

        $this->webPath = '/uploads/' . $date . '/' . $this->fileName . '.' . $this->reportFile->extension;

        $date_dir = Yii::getAlias('@backend') . '/web/uploads/' . $date;

        if (!is_dir($date_dir)) {
            @mkdir($date_dir, '0777');
        }

        if (is_dir($date_dir)) {
            return $date_dir;
        }

        return false;
    }
}