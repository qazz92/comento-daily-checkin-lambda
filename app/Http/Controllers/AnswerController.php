<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Emotion;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    private $answerModel;

    public function __construct(Answer $answer)
    {
        $this->answerModel = $answer;
    }

    /**
     * @api {get} /api/answer Answer 리스트
     * @apiName list
     * @apiGroup Answer
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Answer 리스트
     *
     * @apiParam {Number} page 페이지
     * @apiParam {Number} limit 페이지당 갯수
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *      {
     *          "id": 18,
     *          "emotion_id": 3,
     *          "user_id": 5,
     *          "content": "축구선수의 2년차 징크스처럼 아웃바운드 세일즈도 ...",
     *          "updated_at": "2020-06-23 16:19:33",
     *          "like_count": 0,
     *          "comment_count": 0.
     *          "is_like": false,
     *          "emotion": {
     *              "id": 3,
     *              "emoji": "😎",
     *              "value": 1,
     *              "name": "뿌듯해요",
     *              "answer": "뿌듯해서 어깨가 하늘로 솟았어요",
     *              "comment": "어깨춤을 춰 주세요"
     *          },
     *          "user": {
     *              "id": 5,
     *              "email": "yubin.kim@comento.kr",
     *              "photoURL": "https://lh4.googleusercontent.com/-aLKv4NrPysY/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rdw-af-WSt8fo30wj9WW7j9yjnXRA/photo.jpg",
     *              "display_name": "김유빈"
     *          }
     *      },
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/answer
     */
    public function list(Request $request)
    {
        $request->validate([
            'page' => 'required',
            'limit' => 'required'
        ]);

        return $this->answerModel::withCount(['like', 'comment'])
            ->with(['emotion' => function ($query) {
                /** @var Emotion $query */
                $query->select(['id', 'emoji', 'value', 'name', 'answer', 'comment']);
            }, 'user' => function ($query) {
                $query->select(['id','email','photoURL','display_name']);
            }, 'like' => function ($query) {
                /** @var Like $query */
                $query->select(['id','answer_id','user_id','created_at'])
                    ->with(['user'=>function ($query) {
                        /** @var User $query */
                        $query->select(['id','display_name','email','photoURL']);
                    }])->orderBy('created_at','asc');
            }])->orderByDesc('created_at')
            ->paginate($request->get('limit'));
    }


    /**
     * @api {get} /api/answer/{id} Answer 디테일
     * @apiName show
     * @apiGroup Answer
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Answer 디테일
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "emotion_id": 8,
     *          "user_id": 9,
     *          "content": "일이 많고 바쁘고 싶은 나, 비정상인가요?\n\n장..",
     *          "created_at": "2020-02-25 09:14:31",
     *          "updated_at": "2020-06-23 16:19:32",
     *          "is_like": false,
     *          "like": [
     *              {
     *                  "id": 1954,
     *                  "answer_id": 1,
     *                  "user_id": 14,
     *                  "created_at": "2020-02-25 10:52:08",
     *                  "user": {
     *                      "id": 14,
     *                      "display_name": "이민규",
     *                      "email": "mingyu.lee@comento.kr",
     *                      "photoURL": "https://lh3.googleusercontent.com/a-/AAuE7mBpm1LBaxuCv5GhhwYC5GBOnx8y9Rvd9b8QuVUu"
     *                  }
     *              },
     *              {
     *                  "id": 3645,
     *                  "answer_id": 1,
     *                  "user_id": 1,
     *                  "created_at": "2020-02-25 10:54:19",
     *                  "user": {
     *                      "id": 1,
     *                      "display_name": "최현주",
     *                      "email": "hyunju.choi@comento.kr",
     *                      "photoURL": "https://lh3.googleusercontent.com/--pbZCw7lKLI/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rdG2sleGFs9IhiLUVy-IYnV3MNbZA/photo.jpg"
     *                  }
     *              },
     *              {
     *                  "id": 848,
     *                  "answer_id": 1,
     *                  "user_id": 4,
     *                  "created_at": "2020-02-25 12:02:33",
     *                  "user": {
     *                      "id": 4,
     *                      "display_name": "유성실",
     *                      "email": "yooo1201@gmail.com",
     *                      "photoURL": "https://lh3.googleusercontent.com/-99TGkxJQRss/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rdFMQ5pcFJWK1MCPqNjv93va15OLQ/photo.jpg"
     *                  }
     *              },
     *              {
     *                  "id": 4069,
     *                  "answer_id": 1,
     *                  "user_id": 25,
     *                  "created_at": "2020-02-25 14:17:14",
     *                  "user": {
     *                      "id": 25,
     *                      "display_name": "김민섭",
     *                      "email": "minseop.kim@comento.kr",
     *                      "photoURL": "https://lh4.googleusercontent.com/-hktnQmYgifQ/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rdi6JcyB3B5s23qcQzH6O2KqcnUkw/photo.jpg"
     *                  }
     *              }
     *          ],
     *          "comment": [
     *              {
     *                  "id": 1337,
     *                  "answer_id": 1,
     *                  "user_id": 4,
     *                  "content": "🚨삐빅, 정상입니다",
     *                  "created_at": "2020-02-25 12:02:49",
     *                  "updated_at": "2020-02-25 12:02:49",
     *                  "user": {
     *                      "id": 4,
     *                      "display_name": "유성실",
     *                      "email": "yooo1201@gmail.com",
     *                      "photoURL": "https://lh3.googleusercontent.com/-99TGkxJQRss/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rdFMQ5pcFJWK1MCPqNjv93va15OLQ/photo.jpg"
     *                  }
     *              },
     *              {
     *                  "id": 169,
     *                  "answer_id": 1,
     *                  "user_id": 3,
     *                  "content": "이니시스 환불해드린거 접니다 아시죠 확인부탁드립니다 고객님 ㅎㅎㅎ",
     *                  "created_at": "2020-02-25 16:21:48",
     *                  "updated_at": "2020-02-25 16:21:48",
     *                  "user": {
     *                      "id": 3,
     *                      "display_name": "황유진",
     *                      "email": "yujin.hwang@comento.kr",
     *                      "photoURL": "https://lh6.googleusercontent.com/-UQ7cpAs5YCs/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rcB1fzQ5RQ9J7FzwxW-epMsMGfK-g/photo.jpg"
     *                  }
     *              }
     *          ],
     *          "emotion": {
     *              "id": 8,
     *              "emoji": "😐",
     *              "value": 0,
     *              "name": "그냥그래요",
     *              "answer": "걍 그래요(왜그럴깡?)",
     *              "comment": "왜그럴깡?"
     *          }
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/answer/1
     */
    public function show($id)
    {
        $model = $this->answerModel::with(['like' => function ($query) {
            /** @var Like $query */
            $query->select(['id','answer_id','user_id','created_at'])
                ->with(['user'=>function ($query) {
                    /** @var User $query */
                    $query->select(['id','display_name','email','photoURL']);
            }])->orderBy('created_at','asc');
        }, 'comment' => function ($query) {
            $query->select(['id','answer_id','user_id','content','created_at','updated_at'])->with(['user'=>function ($query) {
                /** @var User $query */
                $query->select(['id','display_name','email','photoURL']);
            }])->orderBy('created_at','asc');
        }, 'emotion' => function ($query) {
            $query->select(['id', 'emoji', 'value', 'name', 'answer', 'comment']);
        }, 'user'])->withCount(['like', 'comment'])
            ->find($id);

        return $model->append('is_like');
    }

    /**
     * @api {post} /api/answer Answer 쓰기
     * @apiName create
     * @apiGroup Answer
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Answer 쓰기
     *
     * @apiParam {Number} emotion_id emotion id
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/answer
     */
    public function create(Request $request)
    {
        $request->validate([
            'emotion_id' => 'required|exists:emotion,id',
            'content' => 'required'
        ]);

        $this->answerModel->emotion_id = $request->get('emotion_id');
        $this->answerModel->content = $request->get('content');
        $this->answerModel->user_id = $request->user()->id;
        $this->answerModel->save();

        return response()->json([], 204);
    }

    /**
     * @api {patch} /api/answer Answer 수정
     * @apiName update
     * @apiGroup Answer
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Answer 수정
     *
     * @apiParam {Number} answer_id answer id
     * @apiParam {Number} emotion_id 페이지
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/answer
     */
    public function update(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:answer,id',
            'emotion_id' => 'required|exists:emotion,id',
            'content' => 'required'
        ]);

        $model = $this->answerModel::find($request->get('answer_id'));

        $model->update(
            [
                'emotion_id' => $request->get('emotion_id'),
                'content' => $request->get('content')
            ]);
        return response()->json([], 204);
    }

    /**
     * @api {delete} /api/answer Answer 삭제
     * @apiName delete
     * @apiGroup Answer
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Answer 삭제
     *
     * @apiParam {Number} answer_id answer id
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
     * @apiSampleRequest https://daily.devapi.comento.kr/api/answer
     */
    public function delete(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:answer,id'
        ]);

        $answer_id = $request->get('answer_id');

        $answer = $this->answerModel::find($answer_id);

        if ($answer->user_id === (int)$request->user()->id) {
            $this->answerModel::destroy($answer_id);
            return response()->json([],204);
        }

        return response()->json(['message'=>'니꺼아님!'],403);
    }
}
