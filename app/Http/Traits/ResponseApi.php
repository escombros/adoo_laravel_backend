<?php

namespace App\Http\Traits;

trait ResponseApi
{

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function sendResponse($data, $messages = [], $code = 200)
    {
        if (!empty($messages)) {
            $messages = is_array($messages) ? $messages : [$messages];
        }
        $response = [

            'success' => true,

            'data' => $data,

            'messages' => $messages,

            'code' => $code
        ];

        return response()->json($response, 200);
    }

    /**

     * return error response.

     *

     * @return \Illuminate\Http\Response

     */

    public function sendError($error, $messages = [], $code = 400)
    {
        if (!empty($messages)) {
            $messages = is_array($messages) ? $messages : [$messages];
        }


        if (empty($code) || $code == 0 || $code > 599) {

            $error .= ' [Code:' . $code . ']';
            $code  = 400;
        }

        $response = [

            'success' => false,

            'error' => $error,

            'messages' => $messages,
            
            'code'=>$code

        ];

        return response()->json($response, 200);
    }
}