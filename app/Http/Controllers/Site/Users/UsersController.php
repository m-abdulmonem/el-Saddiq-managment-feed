<?php

namespace App\Http\Controllers\Site\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Mail\InviteUser;
use App\Models\Category;
use App\Models\Chick\ChickOrder;
use App\Models\Job;
use App\Models\Sms\SmsBody;
use App\Models\User;
use App\Services\User\UserServices;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{


    protected $folder = "site.users";

    protected $trans = "users/users";

    protected $perm = "user";
    /**
     * @var UserServices
     */
    private $user;

    /**
     * UsersController constructor.
     * @param UserServices $user
     */
    public function __construct(UserServices $user)
    {
        $this->user = $user;
        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws Exception
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans,
            'perm' => $this->perm
        ];

        return view("$this->folder.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'title' => trans("$this->trans.create"),
            'trans' => $this->trans
        ];
        return view("$this->folder.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        return $this->user->createWithCode($request);
    }

    /**
     * Display the specified resource.
     *
     * @param UserServices $user
     * @return Response
     */
    public function show(UserServices $user)
    {
        $data = [
            'title' => trans("$this->trans.view",['name' => $user->name]),
            'trans' => $this->trans,
            'user'  => $user,
        ];
        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UserServices $user
     * @return Response
     */
    public function edit(UserServices $user)
    {
        $data = [
            'title' => trans("$this->trans.edit",['name' => $user->name]),
            'trans' => $this->trans,
            'user'=> $user,
        ];
        return view("$this->folder.update",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return JsonResponse|RedirectResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
         $user->update($request->all());

         return back()->with("success",trans(".home.alert_success_update"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        return $user->removeRecorder();
    }

}
