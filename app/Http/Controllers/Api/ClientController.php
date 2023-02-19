<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddBalanceRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ResendCodeRequest;
use App\Http\Requests\Api\UpdatePasswordRequest;
use App\Http\Requests\Api\UpdateProfileImageRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\Api\VerifyCodeRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Reservation;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use App\Models\BankTransfer;
use App\Models\BankAccount;
use Monolog\Handler\RedisPubSubHandler;

class ClientController extends Controller
{
    /**
     * Client IMAGE_PATH
     *
     * @var string
     */
    public const IMAGE_PATH = 'clients';

    /**
     * IMAGE_BANK_TRANSFER_PATH
     *
     * @var string
     */
    public const IMAGE_BANK_TRANSFER_PATH = 'bank_transfers';

    /**
     * uploaderService
     *
     * @var \App\Services\UploaderService $uploaderService
     */
    private $uploaderService;

    /**
     * __construct
     *
     * @param \App\Services\UploaderService $uploaderService
     */
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    /**
     * Client login
     *
     * @param \App\Http\Requests\Api\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $client = Client::where('phone', $request->phone)->first();

        if (Hash::check($request->password, $client->password)) {
            if ($client->status == 0) {
                $this->setClientActivationCode($client);
            }

            $this->updateDeviceToken($client, $request->device_token);

            $client->token = $client->createToken('API')->accessToken;

            return response()->json(['status' => true, 'message' => trans('api.logged_in_successfully'), 'data' => new ClientResource($client)], 200);
        } else {
            return response()->json(['status' => false, "message" => trans('api.password')], 403);
        }
    }

    /**
     * updateDeviceToken
     *
     * @param \App\Models\Client $client
     * @param string $device_token
     * @return bool
     */
    private function updateDeviceToken($client, $device_token)
    {
        $client->device_token = $device_token;
        $client->save();

        return true;
    }

    /**
     * Register new client
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $client = Client::create(array_merge($request->only('username', 'phone', 'email', 'city_id', 'password', 'device_token'), ['type' => 0, 'status' => 0]));

        $this->setClientActivationCode($client);

        $client->token = $client->createToken('API')->accessToken;

        return response()->json(['status' => true, 'message' => trans('api.new_user_added_successfully'), 'data' => new ClientResource($client)], 200);
    }

    /**
     * ForgetPassword
     *
     * @param \App\Http\Requests\Api\ForgetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $client = Client::where('phone', $request->phone)->first();
        if ($client == null) {
            return response()->json(['status' => false, "message" => trans('api.user_does_not_exist')], 403);
        }

        if ($client->status == 0) {
            return response()->json(['status' => false, "message" => trans('api.your_account_is_not_activated')], 403);
        }

        $activation_code = $this->setClientActivationCode($client);

        return response()->json(['status' => true, "message" => trans('api.activation_code_send_successfully'), 'data' => ['code' => $activation_code]], 200);
    }

    /**
     * ResendCode
     *
     * @param \App\Http\Requests\Api\ResendCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendCode(ResendCodeRequest $request)
    {
        $client = Client::where('phone', $request->phone)->first();
        if ($client == null) {
            return response()->json(['status' => false, "message" => trans('api.user_does_not_exist')], 403);
        }

        sendSms($client->phone, generate_activation_code_message($client->activation_code));

        return response()->json(['status' => true, "message" => trans('api.activation_code_resend_successfully'), "data" => ['code' => $client->activation_code]], 200);
    }

    /**
     * VerifyCode
     *
     * @param \App\Http\Requests\Api\VerifyCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCode(VerifyCodeRequest $request)
    {
        $client = Client::where('id', $request->user()->id)->where('activation_code', $request->code)->first();
        if (isset($client) && $client != null) {
            //activate account
            $client->status = 1;
            $client->save();

            $client->token = $request->bearerToken();

            return response()->json(['status' => true, 'message' => trans('api.verify_code'), 'data' => new ClientResource($client)], 200);
        } else {
            return response()->json(['status' => false, 'message' => trans('api.wrong_activation_code')], 403);
        }
    }

    /**
     * ChangePassword
     *
     * @param \App\Http\Requests\Api\ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $client = $request->user();
        if ($client) {
            $request->user()->token()->revoke();

            $update_client = Client::where('id', $client->id)->first();
            $update_client->password = $request->new_password;
            $update_client->save();

            return response()->json(['status' => true, "message" => trans('api.password_changed_successfully')], 200);
        } else {
            return response()->json(['status' => false, "message" => trans('api.user_does_not_exist')], 403);
        }
    }

    /**
     * Get profile data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $request->user()->token = $request->bearerToken();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new ClientResource($request->user())], 200);
    }

    /**
     * UpdateProfile data
     *
     * @param \App\Http\Requests\Api\UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $updated_client = Client::where('id', $request->user()->id)->first();
        $updated_client->fill($request->only('username', 'phone', 'city_id'));
        $updated_client->update();
        $updated_client->token = $request->bearerToken();

        return response()->json(['status' => true, 'message' => trans('api.update_profile'), 'data' => new ClientResource($updated_client)], 200);
    }

    /**
     * UpdateProfileImage
     *
     * @param \App\Http\Requests\Api\UpdateProfileImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfileImage(UpdateProfileImageRequest $request)
    {
        $updated_client = Client::where('id', $request->user()->id)->first();
        if ($request->image) {
            $updated_client->image = $this->handleFile($request['image']);
        }
        $updated_client->update();
        $updated_client->token = $request->bearerToken();

        return response()->json(['status' => true, 'message' => trans('api.update_profile'), 'data' => new ClientResource($updated_client)], 200);
    }

    /**
     * UpdatePassword
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $client = $request->user();
        if ($client) {
            if (Hash::check($request->old_password, $client->password)) {
                $request->user()->token()->revoke();

                $update_client = Client::where('id', $client->id)->first();
                $update_client->password = $request->new_password;
                $update_client->save();

                return response()->json(['status' => true, "message" => trans('api.password_changed_successfully')], 200);
            } else {
                return response()->json(['status' => false, "message" => trans('api.wrong_password')], 403);
            }
        } else {
            return response()->json(['status' => false, "message" => trans('api.user_does_not_exist')], 403);
        }
    }

    /**
     * setClientActivationCode
     *
     * @param \App\Models\Client $client
     * @return bool
     */
    private function setClientActivationCode($client)
    {
        $client->activation_code = random_int(1000, 9999);
        $client->save();

        sendSms($client->phone, generate_activation_code_message($client->activation_code));

        return $client->activation_code;
    }

    /**
     * Return Client balance
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance(Request $request)
    {
        $client = $request->user();
        $balance = $client->balance;

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => ['balance' => $balance]], 200);
    }

    /**
     * AddBalance
     *
     * @param \App\Http\Requests\Api\AddBalanceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addBalance(AddBalanceRequest $request)
    {
        if (isset($request->amount) && $request->amount != null) {
            $user = $request->user();
            $user->balance += $request->amount;
            $user->save();

            return response()->json(['status' => true, 'message' => trans('api.balance_has_been_added_to_your_wallet_successfully')], 200);
        } else {
            $bank = BankAccount::where('id', $request->bank_id)->first();
            $bank_transfer = new BankTransfer();
            $bank_transfer->client_id = $request->user()->id;
            $bank_transfer->bank_name = $bank->getTranslation('bank_name', app()->getLocale());
            $bank_transfer->bank_account_name = $bank->account_name;
            $bank_transfer->bank_account_number = $bank->account_number;
            $bank_transfer->IBAN = $bank->IBAN;
            $bank_transfer->image = $this->handleBankTransferFile($request['image']);
            $bank_transfer->save();

            return response()->json(['status' => true, 'message' => trans('api.your_bank_transfer_will_reviewed')], 200);
        }
    }

    /**
     * Client transactions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactions()
    {
        $transactions_dates = Reservation::where('client_id', auth()->user()->id)
        ->select(DB::raw('DATE(created_at) as created_at'))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->pluck('created_at');

        $transactions = [];
        foreach ($transactions_dates as $date) {
            $date_array = ['date' => $date->format('Y-m-d'), 'reservations' => []];
            $reservations = Reservation::where('client_id', auth()->user()->id)->whereDate('created_at', $date->format('Y-m-d'))->get();
            foreach ($reservations as $reservation) {
                array_push($date_array['reservations'], ['id' => $reservation->id, 'total_price' => sprintf("%1.2f", $reservation->total_price)]);
            }
            array_push($transactions, $date_array);
        }

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => $transactions], 200);
    }

    /**
     * logout Client
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['status' => true, 'message' => trans('api.logout')], 200);
    }

    /**
     * Delete profile
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $client = $request->user();

        $client->phone = $client->id . '-' . $client->phone;
        if ($client->save()) {
            $client->delete();
            $request->user()->token()->revoke();
        }
        return response()->json(['status' => true, 'message' => trans('api.account_deleted_successfully')], 200);
    }

    /**
     * handle image file that return file path
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }


    /**
     * handle image file that return file path
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function handleBankTransferFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_BANK_TRANSFER_PATH);
    }
}
