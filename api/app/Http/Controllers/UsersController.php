<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\Haggis\Transformers\UserTransformer;

class UsersController extends ApiController
{
    /**
     * @var Haggis\Transformers\UserTransformer
     */
    protected $userTransformer;

    /**
     * class constructor
     * @param UserTransformer $userTransformer [description]
     */
    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->respond([
            'data' => $this->userTransformer->transformCollection($users->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'title' => 'required|unique|max:255',
            'body' => 'required',
        ]);

        if ($v->fails()) {
            return $this->respondWithError("User does not exist");
        }
        else {
            
        }

        $user = new User();
        $user->first_name="Derek";
        $user->last_name="Myska";
        $user->middle_initial="J";
        $user->email="derek.myska@gmail.com";
        $user->website='http://www.derekmyska.com';
        $user->user_type=1;
        $user->password = \Illuminate\Support\Facades\Hash::make("password");
        $user->save();
        return ('created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->respondNotFound("User does not exist");
        }
        else {
            return $this->respond([
                'data' => $this->userTransformer->transform($user)
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
