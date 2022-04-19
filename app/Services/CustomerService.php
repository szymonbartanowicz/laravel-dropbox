<?php


namespace App\Services;


use App\Dropbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CustomerService
{
    public function connect()
    {
        $app_key = Dropbox::APP_KEY;
        $redirect_uri = Dropbox::REDIRECT_URI;

        return redirect('https://www.dropbox.com/oauth2/authorize?client_id=' . $app_key . '&response_type=code&redirect_uri=' . $redirect_uri);
    }

    public function setDbxCredentials()
    {
        if (request('code')) {
            $response = Http::asForm()->withBasicAuth(Dropbox::APP_KEY, Dropbox::APP_SECRET)->post('https://api.dropboxapi.com/oauth2/token', [
                'code' => request('code'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => Dropbox::REDIRECT_URI
            ]);

            $data = json_decode($response->body());

            if (property_exists($data, 'error')) {
                return redirect('/setDbxCredentials');
            }

            Auth::user()->customer->update([
                'dbx_id' => $data->account_id,
                'access_token' => $data->access_token
            ]);

            return redirect()->home();
        }
    }
}
