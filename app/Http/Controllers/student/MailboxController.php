<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailboxController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        $student = \DB::table('students')->where('email', $user->email)->first();
        return view('user.mailbox.form', compact('student'));
    }

    public function connect(Request $request)
    {
        // If the password is already stored in the session, skip the password prompt
        if (session()->has('mail_password')) {
            // Use the password from the session directly
            $password = session('mail_password');
            $user = Auth::user();
            $student = \DB::table('students')->where('email', $user->email)->first();
            if (!$student) {
                return back()->with('error', 'Student not found.');
            }

            // Use the stored password to connect and fetch emails
            return $this->fetchEmails($password, $user->email, $request);
        }

        // Validate password input
        $request->validate([
            'password' => 'required'
        ]);

        // Get the user and student details
        $user = Auth::user();
        $student = \DB::table('students')->where('email', $user->email)->first();

        if (!$student) {
            return back()->with('error', 'Student not found.');
        }

        // Get password from the form
        $password = $request->password;

        // Store password in session for future use
        session(['mail_password' => $password]);

        return $this->fetchEmails($password, $user->email, $request);
    }

    private function fetchEmails($password, $email, Request $request)
    {
        $hostname = '{mail.ljku.edu.in:993/imap/ssl}INBOX';
    
        try {
            // Open IMAP connection
            $inbox = imap_open($hostname, $email, $password);
    
            if (!$inbox) {
                throw new \Exception(imap_last_error());
            }
    
            // Pagination setup
            $emails_per_page = 10;
            $page = $request->input('page', 1);
    
            // Get total number of emails in the inbox
            $MC = imap_check($inbox);
            $total_emails = $MC->Nmsgs;
            $total_pages = ceil($total_emails / $emails_per_page);
    
            // Calculate message sequence numbers
            $start = $total_emails - (($page - 1) * $emails_per_page);
            $end = max($start - $emails_per_page + 1, 1);
    
            $messages = [];
    
            for ($i = $start; $i >= $end; $i--) {
                // Fetch overview
                $overview = imap_fetch_overview($inbox, $i, 0)[0];
    
                // Try to fetch HTML body (prefer 1.2, fallback to 1)
                // Try multiple parts to get HTML or plain text content
                $structure = imap_fetchstructure($inbox, $i);
                $body = $this->getBodyRecursive($inbox, $i, $structure);

                // Fallback to plain text if no HTML
                if (empty($body)) {
                    $plain = imap_fetchbody($inbox, $i, "1");
                    $body = quoted_printable_decode($plain);
                }


    
                $body = quoted_printable_decode($body);
    
                // Replace external CSS with inline style
                preg_match_all('/<link[^>]+href=["\']([^"\']+)["\'][^>]*>/i', $body, $matches);
                foreach ($matches[1] as $index => $css_url) {
                    $css = @file_get_contents($css_url);
                    if ($css) {
                        $style_tag = "<style>\n" . $css . "\n</style>";
                        $body = str_replace($matches[0][$index], $style_tag, $body);
                    }
                }
    
                $messages[] = [
                    'subject' => $overview->subject ?? '(No subject)',
                    'from' => $overview->from ?? '(Unknown sender)',
                    'date' => $overview->date ?? '(Unknown date)',
                    'body' => $body,
                ];
            }
    
            imap_close($inbox);
            // Check if there are no messages
            if (empty($messages)) {
                return back()->with('error', 'No messages found.');
            }
            // dd($messages);
    
            // Return with pagination info
            return view('user.mailbox.inbox', compact('messages', 'email', 'page', 'total_pages'));
    
        } catch (\Exception $e) {
            return back()->with('error', 'Connection failed: ' . $e->getMessage());
        }
    }
    private function getBodyRecursive($imap, $msg_number, $structure, $partNumber = '')
{
    $body = '';

    if ($structure->type == 1 && isset($structure->parts)) {
        foreach ($structure->parts as $index => $subPart) {
            $partNum = $partNumber ? $partNumber . '.' . ($index + 1) : ($index + 1);
            $result = $this->getBodyRecursive($imap, $msg_number, $subPart, $partNum);
            if (!empty($result)) {
                return $result;
            }
        }
    } else {
        if (isset($structure->subtype) && strtolower($structure->subtype) == 'html') {
            $body = imap_fetchbody($imap, $msg_number, $partNumber ?: 1);

            switch ($structure->encoding) {
                case 3:
                    $body = base64_decode($body);
                    break;
                case 4:
                    $body = quoted_printable_decode($body);
                    break;
            }
        }
    }

    return $body;
}

    
}

// is there any other way to connect to the mailbox using only php without laravel 