<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @api {get} /api/user/me User 정보
     * @apiName me
     * @apiGroup User
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription 유저 정보
     *
     * @apiSuccess {Number} id id
     * @apiSuccess {String} uid firebase
     * @apiSuccess {String} email 이메일
     * @apiSuccess {String} photoURL 프로필 주소
     * @apiSuccess {String} display_name 이름
     * @apiSuccess {Date} created_at 생성시간
     * @apiSuccess {Date} updated_at 마지막 업뎃 시간
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id" : 12,
     *          "uid" : "3rBTkPY91TOl8fRnBI6K9QfeG852",
     *          "email" : "email@test.com",
     *          "photoURL" : "https://..",
     *          "display_name" : "코대리",
     *          "created_at" : "2020-06-23 15:46:23",
     *          "updated_at" : "2020-06-23 15:46:23"
     *     }
     *
     * @apiError {String} message 메세지
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Unauthorized
     *     {
     *       "message": "Unauthenticated."
     *     }
     *
     * @apiSampleRequest https://daily.devapi.comento.kr/api/user/me
     */
    public function me(Request $request) {
        return response($request->user());
    }
}
