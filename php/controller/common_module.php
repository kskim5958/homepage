<?php
function http_path() {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer_url = $_SERVER['HTTP_REFERER'];
        $url_parts = parse_url($referer_url);
        $path_with_query = isset($url_parts['path']) ? $url_parts['path'] : $_SERVER['HTTP_HOST'];
    } else {
        $path_with_query = $_SERVER['HTTP_HOST'];
    }
    return $path_with_query;
}

// if (isset($_SERVER['HTTP_REFERER'])) {
//     $referer_url = $_SERVER['HTTP_REFERER'];
//     $url_parts = parse_url($referer_url);

//     // 호스트(도메인) 제외한 경로와 쿼리 파라미터
//     $path_with_query = (isset($url_parts['path']) ? $url_parts['path'] : '') .
//                        (isset($url_parts['query']) ? '?' . $url_parts['query'] : '');

//     // 최종 결과
//     echo "이전 페이지 URL (경로+파라미터): " . $path_with_query;

//     // 특정 파라미터만 다루고 싶다면
//     // $query_string = $url_parts['query'] ?? '';
//     // parse_str($query_string, $params);
//     // print_r($params);
// } else {
//     echo "HTTP_REFERER 정보를 가져올 수 없습니다.";
// }