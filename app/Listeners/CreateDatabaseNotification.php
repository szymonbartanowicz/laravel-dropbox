<?php

namespace App\Listeners;

use App\Customer;
use App\Events\DropboxApplicationModified;
use App\File;
use http\Client\Request;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class CreateDatabaseNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param DropboxApplicationModified $event
     * @return void
     */
    public function handle(DropboxApplicationModified $event)
    {
        foreach ($event->ids as $id) {
            $customer = Customer::where('dbx_id', $id)->first();
            $client = new Client($customer->access_token);

            if ($customer->cursor) {
                $data = $client->listFolderContinue($customer->cursor);
            } else {
                $data = $client->listFolder('/', 'true');
            }

            $customer->cursor = $data['cursor'];
            $customer->save();

            $entries = $data['entries'];

            foreach ($entries as $entry) {
                $parts = explode('/', $entry['path_display']);
                array_pop($parts);
                $root = implode('/', $parts) . '/';

                if ($entry['.tag'] === 'deleted') {
                    File::where('path', $entry['path_display'])
                        ->where('status', '<>', 'deleted')
                        ->update(['status' => 'deleted']);
                } else {
                    if (File::where('dbx_id', $entry['id'])->exists()) {
                        File::where('dbx_id', $entry['id'])->update([
                            'name' => $entry['name'],
                            'path' => $entry['path_display'],
                            'size' => array_key_exists('size', $entry) ? $entry['size'] : null,
                            'last_modified' => array_key_exists('client_modified', $entry) ? date('Y-m-d H:i:s', strtotime($entry['server_modified'])) : null,
                            'status' => 'edited'
                        ]);
                    } else {
                        File::create([
                            'customer_id' => $customer->id,
                            'dbx_id' => $entry['id'],
                            'name' => $entry['name'],
                            'root' => $root,
                            'path' => $entry['path_display'],
                            'size' => array_key_exists('size', $entry) ? $entry['size'] : null,
                            'last_modified' => array_key_exists('client_modified', $entry) ? date('Y-m-d H:i:s', strtotime($entry['client_modified'])) : null,
                            'type' => $entry['.tag'],
                            'status' => 'created'
                        ]);
                    }
                }
            }

            return $data;
        }
    }
}
