<?php

/**
 * 返回应用的首页 url
 *
 * @return string
 */
function app_index_url(){
    return \Illuminate\Support\Facades\URL::route('app',['else' => '']);
}

/**
 * 返回应用是否已安装
 *
 * @return bool
 */
function is_app_installed(){
    return \Illuminate\Support\Facades\Storage::exists(app_installation_lock_path());
}

/**
 * 返回应用的安装记录的文件路径
 *
 * @return string
 */
function app_installation_lock_path(){
    return 'installed.lock';
}

/**
 * @param string|array $message
 * @param array $data
 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
 */
function success($message = '请求成功', $data = []){
    if(is_array($message) or $message instanceof \Illuminate\Contracts\Support\Arrayable){
        $data    = $message;
        $message = '请求成功';
    }
    return response([
        'code'    => \App\Http\ResponseCodes::SUCCESS,
        'message' => $message,
        'data'    => $data,
    ]);
}

/**
 * 返回字符串是否为手机号
 * @param string $mobile
 *
 * @return int
 */
function is_mobile(string $mobile)
{
    return preg_match('/^1[34578]\d{9}$/' , $mobile);
}

/**
 * 将 tree 结构的多维数组扁平化为 一维数组的高性能方式
 *
 * @param array $list   待扁平化的 tree 数组
 * @param string $pk    数组中每个节点的主键名 ， 父节点的 $pk 对应到子节点的 $pid
 * @param string $pid   子节点中保存父节点主键值的字段名
 * @param string $child 父节点中保存子节点的字段名
 * @param int $root     根节点的主键值
 *
 * @return array        扁平化后的数组
 */
function list_to_tree( array $list = [], string $pk = 'id', string $pid = 'pid', string $child = 'children', int $root = 0)
{
    $tree = [];
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = [];
        foreach ($list as $key => $value) {
            $refer[ $value[ $pk ] ] =& $list[ $key ];
        }
        foreach ($list as $key => $value) {
            // 判断是否存在 parent
            $parentId = $value[ $pid ];
            if ($root == $parentId) {
                $tree[] =& $list[ $key ];
            } else {
                if (isset($refer[ $parentId ])) {
                    $parent =& $refer[ $parentId ];
                    if (!isset($parent[ $child ])) {
                        $parent[ $child ] = [];
                    }
                    $parent[ $child ][] =& $list[ $key ];
                }
            }
        }
    }

    return $tree;
}






