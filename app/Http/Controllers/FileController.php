<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    /**
     * @api {post} /api/getSignedUrl 파일업로드 url
     * @apiName getSignedUrl
     * @apiGroup File
     * @apiVersion 0.0.1
     * @apiHeader {String} Authorization=Bearer firebase id token
     * @apiHeader {String} Accept=applicant/json applicant/json
     * @apiHeader {String} Content-Type=applicant/json applicant/json
     *
     * @apiDescription Aws pre-signedUrl 업로드 전용 url 을 발급받아 s3에 직접적으로 업로드하는 형식. put 으로 보내면 된다. form-data
     *
     * @apiParam {String} filepath 파일 path( ex. 4123/index.jpg )
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *      "url" : "https://..."
     *   }
     *
     * @apiError {String} message 메세지
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Unauthorized
     *     {
     *       "message": "Unauthenticated."
     *     }
     *
     * @apiSampleRequest http://daily.devapi.comento.kr/api/getSignedUrl
     */
    public function getSignedUrl(Request $request) {

        $request->validate([
            'filepath' => 'required',
        ]);

        //private
        $acl = $request->get('acl','public-read');
        $key = $request->get('filepath');

        $adapter = Storage::disk('s3')->getDriver()->getAdapter();
        $client = $adapter->getClient(); // Get the aws client
        $bucket = $adapter->getBucket(); // Get the current bucket// Make a PutObject command
        $cmd = $client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $key,
            'ACL' => 'public-read' // Explained later
        ]);// Get the presigned request
        $requestUrl = $client->createPresignedRequest($cmd, '+30 minutes');// Get the actual URL to make the request to
        $presignedUrl = (string)$requestUrl->getUri();

        return response()->json(['url'=>$presignedUrl]);
    }


    public function upload(Request $request)
    {
        $url = "https://comento-etc.s3.ap-northeast-2.amazonaws.com/index.jpg?x-amz-acl=public-read&X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA22WUXUNF2OBPXLJO%2F20210208%2Fap-northeast-2%2Fs3%2Faws4_request&X-Amz-Date=20210208T101026Z&X-Amz-SignedHeaders=host%3Bx-amz-acl&X-Amz-Expires=1800&X-Amz-Signature=47ce541a6fae7a7c9d27444c3ba3a0e0ab948f1b45a02b42351618ad41f8dd95";
        \Http::attach(
            'attachment', file_get_contents(storage_path('index.jpg')), 'index.jpg'
        )->put($url);

    }
}
