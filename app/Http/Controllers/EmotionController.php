<?php

namespace App\Http\Controllers;

use App\Models\Emotion;
use Illuminate\Http\Request;

class EmotionController extends Controller
{
    /**
     * @api {get} /api/emotion Emotion 리스트
     * @apiName list
     * @apiGroup Emotion
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Emotion 리스트
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *      {
     *          "id": 1,
     *          "emoji": "🤮",
     *          "value": -1,
     *          "name": "바빴어요",
     *          "answer": "토할만큼 바빴어요(웩)",
     *          "comment": "도와줄 게 없는지 물어보세요!",
     *          "uid": "H12ZXGOhhNUc3xszOFO2",
     *          "created_at": "2020-06-23 16:19:27",
     *          "updated_at": "2020-06-23 16:19:27"
     *      },
     *      ...
     *     ]
     *
     * @apiError {String} message 메세지
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Unauthorized
     *     {
     *       "message": "Unauthenticated."
     *     }
     *
     * @apiSampleRequest https://daily.devapi.comento.kr/api/emotion
     */
    public function list() {
        return response()->json(Emotion::all());
    }
}
