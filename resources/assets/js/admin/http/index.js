import axios from 'axios'
import jsCookie from 'js-cookie'
import url from 'url'
import { Message } from 'element-ui'
import store from '../store'
import json_response_codes from './codes'

// 创建axios实例
const Axios = axios.create({
    baseURL     : 'http://laravel-spa-admin.local/',        // api的base_url TODO 应该从配置中获取
    timeout     : 2500,                                     // 请求超时时间
    maxRedirects: 0
});

// override axios's default accept
Axios.defaults.headers.common['Accept'] = 'application/json';

// 无需做权限拦截的 uri 列表
const except_api_uris = ['api/user/login','api/user/logout','api/session/sync'];

// TODO
// let XSRFToken = jsCookie.get('XSRF-TOKEN');
// if (XSRFToken) {
//     Axios.defaults.headers.common['X-XSRF-TOKEN'] = XSRFToken.content;
// } else {
//     console.error('XSRF token not found!');
// }

/**
 * http 的功能如下：
 *
 * 在发起 api 请求时，拦截每个 api 请求：
 * 1. 检查当前用户是否具备该 api 的请求权限,如果否,则无需向后端发起请求
 * 2. 可以设置其他参数来支持跨域访问
 * 3. 后期可以做 api 自动防重放
 * 4. 后期可以做 api 参数自动加密
 * 5. 后期可以做 api 参数自动压缩
 * 6. 可以设置 proxy/adapter 来访问其他同事电脑上的接口或本地的 json 文件
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
        let target_url = config.url
        let target = url.parse(target_url)

        // TODO 发向站外的 ajax 请求暂时无法做权限拦截
        if (target.hostname !== location.hostname) {
            return config;
        }

        let target_api_uri = target.pathname.substring('/'.length , target.pathname.length);
        if (except_api_uris.includes(target_api_uri)) {
            return config;
        }

        let user_has_api = store.state.user.apis.some( user_api => user_api.uri === target_api_uri);
        if (!user_has_api) {
            Message({
                message : '抱歉,您没有权限请求该接口. ('+ target_api_uri + ')' , type    : 'error', duration: 3 * 1000
            });
            return Promise.reject('cancelled locally');
        }

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
            message : json_response.message , type    : 'error', duration: 3 * 1000
        });

        if (json_response.code === json_response_codes.NOT_AUTHENTICATED) {
            store.dispatch('flush_local_user_info');
            return Promise.reject(json_response);
        }

        return Promise.reject(json_response);
    },

    error => {
        if (error === 'cancelled locally') {
            return Promise.reject(error);
        }

        if (error.response.status === 429) {
            Message({
                message : '您的请求频率太快啦!', type    : 'info', duration: 3 * 1000
            });
            return Promise.reject(error);
        }

        Message({
            message : '网络异常，请稍后再试!', type    : 'error', duration: 3 * 1000
        });
        return Promise.reject(error);
    }
);

export default Axios;


