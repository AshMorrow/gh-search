<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function GHSearch(Request $request)
    {
        $error = '';
        $rules = $request->get('rules');
        if (!$rules) $error = 'empty rules';
        $param = '';
        foreach ($rules as $rule) {
            $operator = $rule['operator'] == '=' ? '' : $rule['operator'];
            $param .= $rule['field'].':'.$operator.intval($rule['value']).'+';
        }

        if (!$error) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/search/repositories?q='.$param.'&sort=stars&order=desc');
            curl_setopt($ch, CURLOPT_USERAGENT, $request->userAgent());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = json_decode(curl_exec($ch));
            if (isset($result->errors)) {
                $error = $result->message;
            }
            curl_close($ch);
        }

        return view('result', ['items' => $result->items ?? [], 'error' => $error]);
    }
}
