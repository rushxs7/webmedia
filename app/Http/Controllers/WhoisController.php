<?php

namespace App\Http\Controllers;

use App\Models\Whois;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\ShellExec;
use Symfony\Component\Process\Process;

class WhoisController extends Controller
{
    public function index(Request $request)
    {
        $whois = Whois::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('whois.index', ['resulthash' => $whois]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'host' => 'required|string'
        ]);

        $whois = new Whois();
        $whois->user_id = Auth::id();
        $whois->host = $request->host;

        // Execute whois
        $process = Process::fromShellCommandline('whois ' . $request->host);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            $exception = new Exception('whois ' . $request->host . " - " . $processOutput);
            report($exception);

            throw $exception;
        }

        $whois = new Whois();
        $whois->user_id = Auth::id();
        $whois->host = $request->host;
        $whois->result = $processOutput;
        $whois->save();

        return Redirect::route('whois.index');
    }

    public function show(Whois $resulthash)
    {
        $whois = $resulthash;
        return view('whois.show', ['whois' => $whois]);
    }
}
