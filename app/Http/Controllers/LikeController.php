<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private $likeModel;

    public function __construct(Like $like)
    {
        $this->likeModel = $like;
    }


    /**
     * @api {post} /api/like 좋아요 하기
     * @apiName create
     * @apiGroup Like
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Comment 쓰기
     *
     * @apiParam {Number} answer_id answer id
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     * @apiError {String} message 메세지
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Unauthorized
     *     {
     *       "message": "Unauthenticated."
     *     }
     *
     * @apiSampleRequest https://daily.devapi.comento.kr/api/like
     */
    public function create(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:answer,id'
        ]);

        $like_id = $this->likeModel->createItem($request->get('answer_id'),$request->user()->id);

        return response()->json(['like_id'=>$like_id],200);
    }

    /**
     * @api {delete} /api/like 좋아요 삭제
     * @apiName delete
     * @apiGroup Like
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Comment 쓰기
     *
     * @apiParam {Number} like_id like id
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 OK
     *
     * @apiError {String} message 메세지
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Unauthorized
     *     {
     *       "message": "Unauthenticated."
     *     }
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "message": "니꺼아님!"
     *     }
     *
     * @apiSampleRequest https://daily.devapi.comento.kr/api/like
     */
    public function delete(Request $request)
    {
        $request->validate([
            'like_id' => 'required|exists:like,id'
        ]);

        $like_id = $request->get('like_id');

        $like = $this->likeModel::find($like_id);

        if ($like->user_id === (int)$request->user()->id) {
            $this->likeModel::destroy($like_id);
            return response()->json([],204);
        }

        return response()->json(['message'=>'니꺼아님!'],403);
    }
}
