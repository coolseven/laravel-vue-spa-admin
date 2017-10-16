import axios from 'axios'
import { Message } from 'element-ui'
import store from '../store'
import json_response_codes from './codes'

// 创建axios实例
const Axios = axios.create({
    baseURL     : 'http://laravel-spa-admin.local',        // api的base_url
    timeout     : 5000,                                           // 请求超时时间
    maxRedirects: 0
});

// override axios's default accept
Axios.defaults.headers.common['Accept'] = 'application/json';

/**
 * http 的功能如下：
 *
 * 在发起 api 请求时，拦截每个 api 请求：
 * 1. 检查该 api 的地址是否在 permissions 列表内 TODO
 * 2. 可以设置其他参数来支持跨域访问
 * 3. 后期可以做 api 自动防重放
 * 4. 后期可以做 api 参数自动加密
 * 5. 后期可以做 api 参数自动压缩
 * 6. 可以设置 proxy 来访问其他同事电脑上的接口或本地的 json 文件
 * 7. 可配合其他服务来做 api 接口缓存
 * 8. 可配合其他插件来做 api 请求的 debounce ，race ，cancel 等
 * 9. 当前端资源已过期时 ,弹出 message 框来提醒用户刷新页面
 *
 * 在接收 api 响应时，拦截每个 api 的响应：
 * 1. 当 api 响应类型是用户的 session 已过期时，清空 vuex 中的用户信息， 并引导至登陆页面
 * 2. 当 api 响应类型是接口请求频率过高时，弹出 message 框来提示错误信息
 * 3. 当 api 响应类型是普通的 错误信息时，自动弹出 message 框来提示错误信息
 *
 */


// 拦截所有的 api 请求，未来可做缓存/代理等
Axios.interceptors.request.use(
    config => {
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

// 拦截所有的 api 响应，此处会检查会话是否已过期
Axios.interceptors.response.use(
    net_response => {
        const json_response = net_response.data;

        if (json_response.code === json_response_codes.SUCCESS) {
            return Promise.resolve(json_response.data);
        }

        Message({
            message : json_response.message ,
            type    : 'error',
            duration: 3 * 1000
        });

        if (json_response.code === json_response_codes.NOT_AUTHENTICATED) {
            store.dispatch('flush_local_user_info');
            return Promise.reject(json_response);
        }

        return Promise.reject(json_response);
    },

    error => {
        if (error.response.status === 429) {
            Message({
                message : '您的请求频率太快啦!',
                type    : 'info',
                duration: 3 * 1000
            });
            return Promise.reject(error);
        }

        Message({
            message : '网络异常，请稍后再试!',
            type    : 'error',
            duration: 3 * 1000
        });
        return Promise.reject(error);
    }
);

export default Axios;


