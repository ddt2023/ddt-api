<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GeneralController extends Controller
{
    public function currentLanguage($name)
    {
        App::setLocale($name);
        $language = DB::table('langs')->where([['short_name',$name],['status','1']])->first();
        return $language ?  $language->id : 1 ;
    }

    public function portfolios(Request $request)
    {
        $language_id = $this->currentLanguage($request->header('language'));

        $portfolio = DB::table('portfolio')->where([['lang_id',$language_id],['status','1']])->get();

        return response()->json($portfolio, Response::HTTP_OK);
    }

    public function services(Request $request)
    {
        $language_id = $this->currentLanguage($request->header('language'));

        $service = DB::table('services')->where([['lang_id',$language_id],['status','1']])->get();

        return response()->json($service, Response::HTTP_OK);
    }

    public function aboutUs(Request $request)
    {
        $language_id = $this->currentLanguage($request->header('language'));

        $about = DB::table('about')->where('lang_id',$language_id)->get();

        return response()->json($about, Response::HTTP_OK);
    }

    public function seo(Request $request)
    {
        $language_id = $this->currentLanguage($request->header('language'));

        $seo = DB::table('seo')->where('lang_id',$language_id)->get();

        return response()->json($seo, Response::HTTP_OK);
    }

    public function partners(Request $request)
    {
        $language_id = $this->currentLanguage($request->header('language'));

        $partners = DB::table('partners')->where('lang_id',$language_id)->get();

        return response()->json($partners, Response::HTTP_OK);
    }

    public function generalData()
    {
        $generalData = DB::table('settings')->first();
        return response()->json(array($generalData),Response::HTTP_OK);
    }

    public function portfolioDetail(Request $request,$key)
    {
        $language_id = $this->currentLanguage($request->header('language'));
        $portfolio = DB::table('portfolio')->where([['lang_id',$language_id],['general_key',$key]])->first();

        if(!$portfolio){
            return response()->json(array(
                'status' => 'error',
                'content' => 'something went wrong',
            ),Response::HTTP_BAD_REQUEST);
        }

        return response()->json(array(
            'status' => 'success',
            'content' => $portfolio
        ),Response::HTTP_OK);

    }

    public function serviceDetail(Request $request,$key)
    {
        $language_id = $this->currentLanguage($request->header('language'));
        $service = DB::table('services')->where([['lang_id',$language_id],['general_key',$key]])->first();

        if(!$service){
            return response()->json(array(
                'status' => 'error',
                'content' => 'something went wrong',
            ),Response::HTTP_BAD_REQUEST);
        }
        return response()->json(array(
            'status' => 'success',
            'content' => $service,
        ),Response::HTTP_OK);

    }

    public function contactPost(ContactRequest $request)
    {
        try {
            $contact = DB::table('contact')->insert([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json(array(
                'status' => 'success',
                'message' => 'completed successfully',
            ),Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json(array(
                'status' => 'error',
                'message' => 'something went wrong',
            ),Response::HTTP_BAD_REQUEST);
        }
    }

}
