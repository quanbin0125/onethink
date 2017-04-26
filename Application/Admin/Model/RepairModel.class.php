<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/26
 * Time: 14:17
 */

namespace Admin\Model;


use Think\Model;

class RepairModel extends Model
{

    protected $_validate = array(
        array('name', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('intro', 'require', '简介不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('address', 'require', '简介不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('telephone', 'require', '简介不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),

    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('status', '0', self::MODEL_BOTH),
    );
}