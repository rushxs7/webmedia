<?php

namespace App\Http\Controllers;

use App\Models\Ping;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Process\Process;

class PingController extends Controller
{
    public function index(Request $request)
    {
        $pings = Ping::orderBy('updated_at', 'desc')->get();
        return view('ping.index', ['pings' => $pings]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'host' => 'required|string'
        ]);

        $process = Process::fromShellCommandline('ping ' . $request->host . ' -c 4');

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            $exception = new Exception('ping ' . $request->host . " - " . $processOutput);
            report($exception);

            throw $exception;
        }

        $ping = new Ping();
        $ping->user_id = Auth::id();
        $ping->host = $request->host;
        $ping->result = $processOutput;
        $ping->save();

        return Redirect::route('ping.index');
    }

    public function show(Ping $resulthash)
    {
        $ping = $resulthash;
        return view('ping.show', ['ping' => $ping]);
    }
}
