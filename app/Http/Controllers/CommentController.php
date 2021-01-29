<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $commentModel;

    public function __construct(Comment $comment)
    {
        $this->commentModel = $comment;
    }

    /**
     * @api {post} /api/comment Comment 쓰기
     * @apiName create
     * @apiGroup Comment
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Comment 쓰기
     *
     * @apiParam {Number} answer_id answer id
     * @apiParam {String} content 본문
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
     *
     * @apiSampleRequest https://daily.devapi.comento.kr/api/comment
     */
    public function create(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:answer,id',
            'content' => 'required'
        ]);

        $this->commentModel->content = $request->get('content');
        $this->commentModel->answer_id = $request->get('answer_id');
        $this->commentModel->user_id = $request->user()->id;
        $this->commentModel->save();

        return response()->json([],204);
    }

    /**
     * @api {patch} /api/comment Comment 수정
     * @apiName update
     * @apiGroup Comment
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Comment 수정
     *
     * @apiParam {Number} comment_id comment id
     * @apiParam {String} content 본문
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
     *
     * @apiSampleRequest https://daily.devapi.comento.kr/api/comment
     */
    public function update(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comment,id',
            'content' => 'required'
        ]);

        $model = $this->commentModel::find($request->get('comment_id'));

        $model->update(
            [
                'content' => $request->get('content')
            ]);
        return response()->json([],204);
    }

    /**
     * @api {delete} /api/comment Comment 삭제
     * @apiName delete
     * @apiGroup Comment
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Comment 삭제
     *
     * @apiParam {Number} comment_id comment id
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/comment
     */
    public function delete(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comment,id',
        ]);

        $comment_id = $request->get('comment_id');

        $comment = $this->commentModel::find($comment_id);

        if ($comment->user_id === (int)$request->user()->id) {
            $this->commentModel::destroy($comment_id);
            return response()->json([],204);
        }

        return response()->json(['message'=>'니꺼아님!'],403);
    }
}
