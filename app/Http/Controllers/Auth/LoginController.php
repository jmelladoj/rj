<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use SEO;
use SEOMeta;
use OpenGraph;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        SEO::setTitle('Las mejores escort de Concepción - PlacerConce.cl');
        SEO::setDescription('Las mejores escort, escorts, prostitutas, putas y damas de compañia de concepcion te esperan');
        SEO::opengraph()->setUrl('https://www.placerconce.cl/');
        SEO::setCanonical('https://www.placerconce.cl/');
        SEOMeta::addKeyword(['escort', 'escorts', 'prostitutas' , 'damas de compañia', 'concepcion', 'escort concepcion', 'escorts en concepcion', 'postitutas en concepcion', 'damas de compañia en concepcion', 'conce']);

        OpenGraph::setDescription('Las mejores escort, escorts, prostitutas, putas y damas de compañia de concepcion te esperan');
        OpenGraph::setTitle('Las mejores escort de Concepción - PlacerConce.cl');
        OpenGraph::setUrl('https://www.placerconce.cl/');
    }

    public function username(){
        return 'usuario';
    }
}
