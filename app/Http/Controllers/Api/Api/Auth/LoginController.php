<?php

namespace App\Http\Controllers\Api\Api\Auth;

use App\Models\User;
use App\Models\Dailies\Daily;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Auth\LoginRequest;

class LoginController extends Controller
{

    public function __construct(protected LoginRequest $request)
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        return $this->attemptLogin();
    }

    private function data(): array
    {
        return [
            $this->crendential() => $this->request->auth,
            'password' => $this->request->password
        ];
    }

    public function crendential(): string
    {
        return is_email($this->request->auth) ? "email" : "username";
    }

    private function user()
    {
        return User::where($this->crendential(), $this->request->auth)->first();
    }

    private function attemptLogin()
    {

        if ($user = $this->user()) {
            if (Hash::check($this->request->password, $user->password)) {

                if (auth()->attempt($this->data(), false)) {

                    $this->registerToday();

                    $token = $user->createToken('posUserToken')->plainTextToken;

                    return (new UserResource($user))->additional(['code' => 1, 'token' => $token]);
                }

                return jsonError('اسم المستخد او كلمة المرور غير صحيحة');
            }

            return jsonError('كلمة المرور غير صحيحة');
        }

        return jsonError("المستخد غير موجود");
    }
    private function registerToday(): void
    {
        $daily = new Daily;

        if (!$daily->today())
            $daily->create([
                'number' => $daily->code(),
                'time_in' => now(),
                'user_id' => \auth()->id()
            ]);
    }
}
