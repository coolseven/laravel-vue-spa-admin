<?php

namespace App\Http;

class ResponseCodes
{
    /**
     *  请求成功
     */
    const SUCCESS                           = 200;

    /**
     *  未知的接口错误
     */
    const UNKNOWN_API_ERROR                 = 500;

    /**
     *  用户请求的接口不存在
     */
    const API_NOT_FOUND                     = 1000;

    /**
     *  未登录或会话已过期
     */
    const NOT_AUTHENTICATED                 = 1001;

    /**
     *  用户无该接口的访问权限
     */
    const ACCESS_DENIED                     = 1002;

    /**
     *  验证码检验失败
     */
    const CAPTCHA_MISMATCH                  = 1003;

    /**
     *  账号或密码校验失败
     */
    const USERNAME_OR_PASSWORD_MISMATCH     = 1004;

    /**
     *  前端资源已过期
     */
    const RESOURCE_OUTDATED                 = 1005;

    /**
     *  未找到相关数据
     */
    const DATA_NOT_FOUND                    = 1006;

    /**
     *  该接口已废弃
     */
    const API_DEPRECATED                    = 1007;

    /**
     *  SQL 语句不合法
     */
    const SQL_EXCEPTION                     = 1008;

    /**
     *  不允许使用该用户名进行注册
     */
    const FORBIDDEN_USERNAME_FOR_REGISTER   = 1009;

    /**
     *  系统正在安装中,只有安装者才能访问
     */
    const APP_NOT_INSTALLED                 = 1010;
}