<?php

namespace App\Http\Controllers\Token;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Email;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email as SymfonyEmail;


class EmailController extends Controller {
    
    public function index(Request $request) {
        
        $query = Email::query();

        if ($request->has('title')) {
           $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('email')) {
              $query->where('from_email', 'like', '%' . $request->input('email') . '%');
        }

        if ($request->has('smtp_host')) {
              $query->where('smtp_host', $request->input('smtp_host'));
        }

        $emails = $query->paginate(10);

        return view('app.Email.index', [
            'emails' => $emails,
        ]);
    }

    public function store(Request $request) {

        try {
            
            $encryption = strtolower($request->smtp_encryption ?? 'tls');
            $scheme     = $encryption === 'ssl' ? 'smtps' : 'smtp';
            $dsn        = sprintf('%s://%s:%s@%s:%s', $scheme, $request->smtp_username, $request->smtp_password, $request->smtp_host, $request->smtp_port);

            $transport  = Transport::fromDsn($dsn);
            $mailer     = new Mailer($transport);
            $testMail   = (new SymfonyEmail())->from($request->from_email)->to($request->from_email)->subject('Teste de conexão SMTP - eBlog')->text('Parabéns! Seu SMTP está funcionando corretamente.');

            $mailer->send($testMail);

            $email = new Email();
            $email->uuid             = Str::uuid();
            $email->user_id          = Auth::user()->id;
            $email->company_id       = Auth::user()->company_id ?? Auth::user()->id;
            $email->title            = $request->title;
            $email->from_name        = $request->from_name;
            $email->from_email       = $request->from_email;
            $email->smtp_host        = $request->smtp_host;
            $email->smtp_port        = $request->smtp_port;
            $email->smtp_username    = $request->smtp_username;
            $email->smtp_password    = $request->smtp_password;
            $email->smtp_encryption  = $request->smtp_encryption;
            $email->is_default       = $request->has('is_default') ? true : false;
            $email->is_verified      = true;
            if ($email->save()) {
                if ($email->is_default) {
                    Email::where('id', '!=', $email->id)->update(['is_default' => false]);
                }

                return redirect()->back()->with('success', 'Configuração salva e testada com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao salvar a configuração. Detalhes: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $uuid) {

        $email = Email::where('uuid', $uuid)->first();
        if (!$email) {
            return redirect()->back()->with('error', 'Email não encontrado! Verifique e tente novamente.');
        }

        $email->title            = $request->title;
        $email->from_name        = $request->from_name;
        $email->from_email       = $request->from_email;
        $email->smtp_host        = $request->smtp_host;
        $email->smtp_port        = $request->smtp_port;
        $email->smtp_username    = $request->smtp_username;
        if ($request->smtp_password) {
            $email->smtp_password    = $request->smtp_password;
        }
        $email->smtp_encryption  = $request->smtp_encryption;
        $email->is_default       = $request->has('is_default') ? true : false;

        try {
            $encryption = strtolower($request->smtp_encryption ?? 'tls');
            $scheme     = $encryption === 'ssl' ? 'smtps' : 'smtp';
            $dsn        = sprintf('%s://%s:%s@%s:%s', $scheme, $request->smtp_username, $request->smtp_password ?? $email->smtp_password, $request->smtp_host, $request->smtp_port);

            $transport  = Transport::fromDsn($dsn);
            $mailer     = new Mailer($transport);
            $testMail   = (new SymfonyEmail())->from($request->from_email)->to($request->from_email)->subject('Teste de conexão SMTP - eBlog')->text('Parabéns! Seu SMTP está funcionando corretamente.');

            $mailer->send($testMail);
            if ($email->save()) {
                $email->is_verified = true;
                if ($email->is_default) {
                    Email::where('id', '!=', $email->id)->update(['is_default' => false]);
                }

                return redirect()->back()->with('success', 'Configuração atualizada com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar a configuração. Detalhes: ' . $e->getMessage());
        }
    }

    public function destroy($uuid) {

        $email = Email::where('uuid', $uuid)->first();
        if ($email && $email->delete()) {
            return redirect()->back()->with('success', 'Configuração de email deletada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao deletar a configuração de email, verifique os dados e tente novamente!');
    }
}
