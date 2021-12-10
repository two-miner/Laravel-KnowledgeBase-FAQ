<?php

namespace App\Http\Controllers\Auth;

use App\Helper\SessionUnlock;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    use RedirectsUsers;

    const REDIRECT_TO = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('unlock-guest');
    }

    /**
     * Where to redirect users after unlock.
     *
     * @var string
     */
    protected $redirectTo = self::REDIRECT_TO;

    /**
     * Show the application's unlock form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.password');
    }

    /**
     * Handle a unlock request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function unlock(Request $request)
    {
        $this->validateUnlock($request);

        if ($this->attemptUnlock($request)) {
            return $this->sendUnlockResponse($request);
        }

        return $this->sendFailedUnlockResponse($request);
    }

    /**
     * Validate the unlock request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateUnlock(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to unlock into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptUnlock(Request $request)
    {
        $session = new SessionUnlock($request->session());

        $password = Setting::getSetting('password')->val ?? null;
        if ($password && $password == $request->input('password')) {
            $session->addUnlockFlag();
        }

        return $session->isUnlocked();
    }

    /**
     * Send the response after the unlock.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendUnlockResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the failed unlock response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedUnlockResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'password' => [trans('auth.failed')],
        ]);
    }
}
