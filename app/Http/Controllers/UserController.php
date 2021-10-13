<?php
namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Membership; 
use App\Models\UserTransaction; 
use App\Models\Address; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;
class UserController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {try {
        $user = User::where('status', '!=', 'deleted')
            ->orWhereNull('status')->get()
            ->each(function ($item, $key) {
                $item->address;
                $item->membership;
                $item->remember_token = "";
            });
        return response()
            ->json(
                HelperClass::responeObject(
                    $user,
                    true,
                    Response::HTTP_OK,
                    'Successfully fetched.',
                    "Users are fetched sucessfully.",
                    ""
                ),
                Response::HTTP_OK
            );
    } catch (ModelNotFoundException $ex) { // User not found
        return response()
            ->json(
                HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
    } catch (Exception $ex) { // Anything that went wrong
        return response()
            ->json(
                HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal server error.', "", $ex->getMessage()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
    }
    }
    public function login(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [ 
                'email' => ['required'],
                'password' => ['required']
            ]);
            if ($validatedData->fails()) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_BAD_REQUEST, "Validation failed check JSON request", "", $validatedData->errors()),
                        Response::HTTP_BAD_REQUEST
                    );
            }
        $user = User::where('email', $request->email)->where('status','!=','blocked')->first();
        if ($user) {
            
            if (Hash::check($request->password, $user->password)) {
                if($user->status === "blocked"){
                    return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'Account blocked.',"This account is blocked.",""),
                        Response::HTTP_OK
                    );
                }
                $token = $user->createToken('Laravel Password Grant', [$user->type])->accessToken;
                $user['remember_token'] = $token;
                if ($user->save()) {
                    $user->address;
                    $user->membership;
                    return response()
                ->json(
                    HelperClass::responeObject($user, true, Response::HTTP_OK,'User found',"User is succesfully loged in.",""),
                    Response::HTTP_OK
                );
                }else{
                    return response()
                    ->json(
                        HelperClass::responeObject($user, true, Response::HTTP_INTERNAL_SERVER_ERROR,'Internal Error',"","An error occured while trying to log in."),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
                
            } else {
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'Password issue.',"The password doesnt match the email.",""),
                    Response::HTTP_CONFLICT
                );
            }
        } else {
            return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_NOT_FOUND,'User doesnt exist.',"The is no registered user by this email.",""),
                    Response::HTTP_NOT_FOUND
                );
        }
    
} catch (ModelNotFoundException $ex) { // User not found
    return response()
        ->json(
            HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
} catch (Exception $ex) { // Anything that went wrong
    return response()
        ->json(
            HelperClass::responeObject(null, false, RESPONSE::HTTP_INTERNAL_SERVER_ERROR, 'Internal server error.', "", $ex->getMessage()),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
}}

public function logout(Request $request)
{
    try{
    $token = $request->user()->token(); 
    $token->revoke();
    $user = User::where('id', $token->user_id)->first();
    $user['remember_token'] = '';
    if($user->save()){ 
    return response()
    ->json(
        HelperClass::responeObject(null, true, RESPONSE::HTTP_OK, 'Successfully logged out', "You have been successfully logged out!", ""),
        Response::HTTP_OK
    );
}else{
    return response()
    ->json(
        HelperClass::responeObject(null, true, RESPONSE::HTTP_INTERNAL_SERVER_ERROR, 'logout failure.', "We could not successfully log out your account please try again!", ""),
        Response::HTTP_INTERNAL_SERVER_ERROR
    );
}
} catch (ModelNotFoundException $ex) { // User not found
return response()
    ->json(
        HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
        Response::HTTP_UNPROCESSABLE_ENTITY
    );
} catch (Exception $ex) { // Anything that went wrong
return response()
    ->json(
        HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal server error.', "", $ex->getMessage()),
        Response::HTTP_UNPROCESSABLE_ENTITY
    );
}}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'first_name' => ['required','max:20'],
                'last_name' => ['required','max:20'],
                'email' => ['required','max:255'],
                'password' => ['required','max:12'],
                'phone_number' => ['required','max:30'], 
                'birthdate' => ['required','max:15'],
                'type' => ['required',Rule::in(['user','organization','hr','operations'])], 
                'membership_id' => ['required','numeric'],
                'address.latitude' => ['required'],
                'address.longitude' => ['required'],
                'address.country' => ['required', 'max:50'],
                'address.city' => ['required', 'max:50'],
                'address.type' => ['required', 'max:10', Rule::in(['user'])]

            ]);
            if ($validatedData->fails()) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_BAD_REQUEST, "Validation failed check JSON request", "", $validatedData->errors()),
                        Response::HTTP_BAD_REQUEST
                    );
            }
        $input = $request->all();
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::where('phone_number', $request->phone_number)->first();
            if($user){
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'User already exist.', "",  "A user already exist by this phonenumber "),
                    Response::HTTP_CONFLICT
                );
            }
            $membership = Membership::where('id', $request->membership_id)->where('status','=','active')->first();
            if(!$membership){
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'Membership doesnt exist.', "",  "Membership doesnt exist."),
                    Response::HTTP_CONFLICT
                );
            }
            $user = new User($input);
            $user->password = Hash::make($request->password);
            $user->remember_token  = $user->createToken('Laravel Password Grant')->accessToken;
            $address = $request->address;
            $address = Address::create($address);
            if ($user->type === "organization") {
                $user->status = "pending";
            }
            $user->status = "active";
                $user->address_id = $address->id;
                if($user->save()){
                    $user_transactions = new UserTransaction();
                    $user_transactions->refreshed_on=$user->created_at;
                    $user_transactions->user_id=$user->id;
                    $user_transactions->left_limit_of_hotel_booking=$membership->limit_of_hotel_booking;
                    $user_transactions->left_transaction_limit=$membership->transaction_limit;
                    if(!$user_transactions->save()){
                        return response()
                        ->json(
                            HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR,'Internal error', "",  "User registered but user's transaction couldnt be saved."),
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                    $user->address;
                    $user->membership;
                    return response()
                ->json(
                    HelperClass::responeObject($user, true, Response::HTTP_CREATED,'User created.',"A user is created by the details given.",""),
                    Response::HTTP_CREATED
                );
                }else{
                    return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR,'Internal error', "",  "This user couldnt be saved."),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                } 
        } else {
            return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'User already exist.', "",  "A user already exist by this email "),
                    Response::HTTP_CONFLICT
                );
        }
    } catch (ModelNotFoundException $ex) { // User not found
        return response()
            ->json(
                HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
    } catch (Exception $ex) { // Anything that went wrong
        return response()
            ->json(
                HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal server error.', "", $ex->getMessage()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $user= User::where('remember_token',$id)->first();
        if($user){
            return response($user,200);
        }else{
            return response($user,404);
        }
        
    
    }

    public function update(Request $request,  $id)
    {
        $user = User::find($id);
        if($user){
            $input = $request->all();
            $result= $user->fill($input)->save(); 
            if($result){
                return response($user,201);
            }else{
                return response($user,500);
            }
        }else{
            return response($user,404);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\uuid  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_NOT_FOUND, "Resource Not Found", '', "User by this id doesnt exist."),
                        Response::HTTP_NOT_FOUND
                    );
            }
            $user->status = 'deleted';
            $user->save();
            return response()
                ->json(
                    HelperClass::responeObject(null, true, Response::HTTP_OK, 'Successfully deleted.', "User is deleted sucessfully.", ""),
                    Response::HTTP_OK
                );
        } catch (ModelNotFoundException $ex) {
            return response()
                ->json(
                    HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
        } catch (Exception $ex) { // Anything that went wrong
            return response()
                ->json(
                    HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal error occured.', "", $ex->getMessage()),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }
}
