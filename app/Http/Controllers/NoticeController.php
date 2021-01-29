<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    private $noticeModel;

    public function __construct(Notice $notice)
    {
        $this->noticeModel = $notice;
    }

    /**
     * @api {get} /api/notice Notice 리스트
     * @apiName list
     * @apiGroup Notice
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Notice 리스트
     *
     * @apiParam {Number} page 페이지
     * @apiParam {Number} limit 페이지당 갯수
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *      "current_page": 1,
     *      "data": [
     *              {
     *                  "id": 1,
     *                  "title": "1.2.0",
     *                  "version": "1.2.0",
     *                  "content": " 📌 <b>신규 기능</b><br> - 질문지가 3번째 버전(회고)으로 변경되었어요.",
     *                  "created_at": "2019-12-18 01:44:00",
     *                  "updated_at": "2020-06-23 16:19:23"
     *              },
     *          ...
     *      ],
     *      "first_page_url": "http://localhost:8000/api/notice?page=1",
     *      "from": 1,
     *      "last_page": 1,
     *      "last_page_url": "http://localhost:8000/api/notice?page=1",
     *      "next_page_url": null,
     *      "path": "http://localhost:8000/api/notice",
     *      "per_page": "10",
     *      "prev_page_url": null,
     *      "to": 7,
     *      "total": 7
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/notice
     */
    public function list(Request $request) {
        $request->validate([
            'page' => 'required',
            'limit' => 'required'
        ]);

        return $this->noticeModel::orderByDesc('created_at')
            ->paginate($request->get('limit'));
    }

    /**
     * @api {get} /api/notice/{id} Notice 디테일
     * @apiName show
     * @apiGroup Notice
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Notice 디테일
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "title": "1.2.0",
     *          "version": "1.2.0",
     *          "content": " 📌 <b>신규 기능</b><br> - 질문지가 3번째 버전(회고)으로 변경되었어요.",
     *          "created_at": "2019-12-18 01:44:00",
     *          "updated_at": "2020-06-23 16:19:23"
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/notice/1
     */
    public function show($id) {

        return $this->noticeModel::find($id);
    }

    /**
     * @api {post} /api/notice Notice 쓰기
     * @apiName create
     * @apiGroup Notice
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Notice 쓰기
     *
     * @apiParam {String} title 제목
     * @apiParam {String} content 본문
     * @apiParam {String} version 버전
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/notice
     */
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'version' => 'required'
        ]);

        $this->noticeModel->title = $request->get('title');
        $this->noticeModel->content = $request->get('content');
        $this->noticeModel->version = $request->get('version');
        $this->noticeModel->save();

        return response()->json([],204);
    }

    /**
     * @api {patch} /api/notice Notice 수정
     * @apiName update
     * @apiGroup Notice
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Notice 수정
     *
     * @apiParam {Number} notice_id notice id
     * @apiParam {String} title 제목
     * @apiParam {String} content 본문
     * @apiParam {String} version 버전
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/notice
     */
    public function update(Request $request)
    {
        $request->validate([
            'notice_id' => 'required|exists:notice,id',
            'title' => 'required',
            'content' => 'required',
            'version' => 'required'
        ]);

        $model = $this->noticeModel::find($request->get('notice_id'));

        $model->update(
            [
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'version' => $request->get('version')
            ]);
        return response()->json([],204);
    }

    /**
     * @api {delete} /api/notice Notice 삭제
     * @apiName delete
     * @apiGroup Notice
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Notice 삭제
     *
     * @apiParam {Number} notice_id notice id
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/notice
     */
    public function delete(Request $request)
    {
        $request->validate([
            'notice_id' => 'required|exists:notice,id',
        ]);

        $this->noticeModel::destroy($request->get('notice_id'));

        return response()->json([],204);
    }
}
