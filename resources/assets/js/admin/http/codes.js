/**
 * 服务器接口返回的 json 数据中的状态码
 * Created by cools on 2017/9/3 0003.
 */
const JSON_RESPONSE_CODES = {
    "SUCCESS"           :   200 ,
    "UNKNOWN_ERROR"     :   500 ,
    "API_NOT_FOUND"     :   1000,
    "NOT_AUTHENTICATED" :   1001,
    "ACCESS_DENIED"     :   1002,
    "RESOURCE_OUTDATED" :   1005
};
export default JSON_RESPONSE_CODES;