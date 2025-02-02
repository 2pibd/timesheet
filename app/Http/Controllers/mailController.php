<?php

namespace App\Http\Controllers;

use App\Models\mail_attachment;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
#use Webklex\IMAP\ClientManager;
#use Webklex\IMAP\MessageNewEvent;
#use Webklex\IMAP\Support\MessageCollection;
use App\Models\mailsetup;
use App\Models\mailbox;
use File;
use Auth;

use imap;
class mailController extends Controller
{
    private $imapStream;
    private $plaintextMessage;
    private $htmlMessage;
    private $emails;
    private $errors = array();
    private $attachments = array();
    private $attachments_dir = 'attachments';


    public function testConnection(Request $request)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $smtpServer = $request->settings['mail_host'];
        $username = $request->settings['mail_username'];
        $password = $request->settings['mail_password'];
        $port = $request->settings['mail_port'];
        $mail_encryption = $request->settings['mail_encryption'];

        $email = new Imap();
        $host = '{'.$smtpServer.':'.$port.'/'.$mail_encryption.'}INBOX';

        $connect = $email->connect(
            $host,
            $username, //username
            $password //password
        );

        if($connect){
            return $status=[
                'status'=>'Success',
                'message'=>'Successfully connected'
            ];
        }else return  $status=[
                'status'=>'Failed',
                'message'=>'Faild to Connected'
            ];
    }








    private function loadMessage($uid, $type) {
        $overview = $this->getOverview($uid);

        $array = array();
        $array['uid'] = $overview->uid;
        $array['to'] = $overview->to;
        $array['subject'] = isset($overview->subject) ? $this->decode($overview->subject) : '';
        $array['date'] = date('Y-m-d h:i:sa', strtotime($overview->date));
        $headers = $this->getHeaders($uid);
        $array['from'] = isset($headers->from) ? $this->processAddressObject($headers->from) : array('');
        $structure = $this->getStructure($uid);
        if (!isset($structure->parts)) { // not multipart
            $this->processStructure($uid, $structure);
        } else { // multipart
            foreach ($structure->parts as $id => $part) {
                $this->processStructure($uid, $part, $id + 1);
            }
        }
        $array['message'] = $type == 'text' ? $this->plaintextMessage : $this->htmlMessage;
        $array['attachments'] = $this->attachments;
        return $array;
    }




    public function postInbox($mailConfig, $item, $key)
    {
        $site_user_id = Auth::id();

            $mailbox = mailbox::create([
                'site_ref_id' => (isset($mailConfig->sites)) ? $mailConfig->sites->id : '',
                'to_mail' =>  $item['to']  ,
                'from_name' => (isset($item['from'])) ? $item['from']['name'] : '',
                'from_mail' => (isset($item['from'])) ? $item['from']['address'] : '',
                'subject' => (isset($item['subject'])) ? $item['subject'] : '',
                'message' => $item['message'],
                'user_id' => $site_user_id,
                'date' =>$item['date'] ,
                'token' => sha1(time() . $mailConfig->uid . $key),
            ]);

        if($mailbox) {
            //////add message


            $attachments_dir = public_path('files' . '/' . $mailbox->id);

            //  dd($item['uid']);
            if (isset($item['attachments']) && sizeof($item['attachments']) > 0) {
                // return $messages['attachments'];

                $filePointer = $attachments_dir;
                if (!is_dir($attachments_dir)) @mkdir($attachments_dir, 0777, true);
                if (is_dir($attachments_dir))
                    foreach ($item['attachments'] as $file) {
                        $file['uid'] = $item['uid'];
                        $inbox = $this->getFiles($file, $attachments_dir);
                        mail_attachment::create([
                            'mailbox_id' => $mailbox->id,
                            'file_name' => $file['file'],
                            'file' => 'files/' . $mailbox->id . '/' . $file['file'],
                            'token' => sha1(time() . $file['file'] . $mailbox->id),
                        ]);
                    }
            }
        }

    }



    public function readmail()
    {

        $mailConfig =  mailsetup::where('status','Active')->where('user_id', Auth::id())->first();

        if($mailConfig) {

                $host = '{' . $mailConfig->host . ':' . $mailConfig->port . '/' . $mailConfig->encryption . '}INBOX';
                $mbox = imap_open($host, $mailConfig->username, $mailConfig->password);

              //  print("Connection established...." . "<br>");

                $MC = imap_check($mbox);

          // return  @imap_search($mbox, 'UNSEEN SINCE 10-June-2020');
           // $emails = imap_search($mbox,'SUBJECT "Undelivered Mail Returned to Sender" SINCE "'.$dateMonth.'" BEFORE "'.$date.'"');
                $emails = @imap_search($mbox, "NEW", SE_UID);
                $this->imapStream = $mbox;
                // $result = imap_fetch_overview($mbox, "1:{$MC->Nmsgs}", 0);
                $inbox = array();
                if ($emails) {
                    //$this->emails = $emails;
                    $type='text';

                    foreach ($emails as $key=>$email_number) {
                        $this->attachments = array();
                        $uid = imap_uid($mbox, $email_number);
                        //$this->attachments =  public_path('files/' .$uid . '/' . $request->uid);
                             $messages = $inbox[] = $this->loadMessage($uid, $type);

                        $this->postInbox($mailConfig, $messages, $key);
//////////////////////////////////////////////////////////////////////////



                    }
                    imap_close($mbox);
                }

                //Closing the connection
            }

         $data['inbox'] =  mailbox::with('attachment')->orderBy('created_at','DESC')->where('user_id', Auth::id())->get()->paginate(25);

        return view('admin.mail_box.inbox', $data);

    }


    public function getFiles($r, $attachments_dir) { //save attachments to directory
        $pullPath = $attachments_dir . '/' . $r['file'];
        if(!is_dir($attachments_dir)) @mkdir($attachments_dir,0777, true);

        $res = true;
        if (file_exists($pullPath)) {
            $res = false;
        } elseif (!is_dir($attachments_dir)) {
            $this->errors[] = 'Cant find directory for email attachments! Message ID:' . $r['uid'];
            return false;
        } elseif (!is_writable($attachments_dir)) {
            $this->errors[] = 'Attachments directory is not writable! Message ID:' . $r['uid'];
            return false;
        }
        if($res && !preg_match('/\.php/i', $r['file']) && !preg_match('/\.cgi/i', $r['file']) && !preg_match('/\.exe/i', $r['file']) && !preg_match('/\.dll/i', $r['file']) && !preg_match('/\.mobileconfig/i', $r['file'])){
            if (($filePointer = fopen($pullPath, 'w')) == false) {
                $this->errors[] = 'Cant open file at imap class to save attachment file! Message ID:' . $r['uid'];
                return false;
            }
            switch ($r['encoding']) {
                case 3: //base64
                    $streamFilter = stream_filter_append($filePointer, 'convert.base64-decode', STREAM_FILTER_WRITE);
                    break;
                case 4: //quoted-printable
                    $streamFilter = stream_filter_append($filePointer, 'convert.quoted-printable-decode', STREAM_FILTER_WRITE);
                    break;
                default:
                    $streamFilter = null;
            }

            imap_savebody($this->imapStream, $filePointer, $r['uid'], $r['part'], FT_UID);
            if ($streamFilter) {
                stream_filter_remove($streamFilter);
            }
            fclose($filePointer);
            return array("status" => "success", "path" => $pullPath);
        }else{
            return array("status" => "success", "path" => $pullPath);
        }
    }



    private function setFileName($text) {
        $this->filename = $this->decode($text);
    }

    private function saveToDirectory($uid, $partIdentifier) { //save attachments to directory
        $array = array();
        $array['part'] = $partIdentifier;
        $array['file'] = $this->filename;
        $array['encoding'] = $this->encoding;
        return $array;
    }


    private function decodeMessage($data, $encoding) {
        if (!is_numeric($encoding)) {
            $encoding = strtolower($encoding);
        }
        switch (true) {
            case $encoding === 'quoted-printable':
            case $encoding === 4:
                return quoted_printable_decode($data);
            case $encoding === 'base64':
            case $encoding === 3:
                return base64_decode($data);
            default:
                return $data;
        }
    }

    private function getParametersFromStructure($structure) {
        $parameters = array();
        if (isset($structure->parameters))
            foreach ($structure->parameters as $parameter)
                $parameters[strtolower($parameter->attribute)] = $parameter->value;
        if (isset($structure->dparameters))
            foreach ($structure->dparameters as $parameter)
                $parameters[strtolower($parameter->attribute)] = $parameter->value;
        return $parameters;
    }


    private function processStructure($uid, $structure, $partIdentifier = null) {
        $parameters = $this->getParametersFromStructure($structure);
        if ((isset($parameters['name']) || isset($parameters['filename'])) || (isset($structure->subtype) && strtolower($structure->subtype) == 'rfc822')
        ) {
            if (isset($parameters['filename'])) {
                $this->setFileName($parameters['filename']);
            } elseif (isset($parameters['name'])) {
                $this->setFileName($parameters['name']);
            }
            $this->encoding = $structure->encoding;
            $result_save = $this->saveToDirectory($uid, $partIdentifier);

            $this->attachments[] = $result_save;

        } elseif ($structure->type == 0 || $structure->type == 1) {
            $messageBody = isset($partIdentifier) ?
                imap_fetchbody($this->imapStream, $uid, $partIdentifier, FT_UID | FT_PEEK) : imap_body($this->imapStream, $uid, FT_UID | FT_PEEK);
            $messageBody = $this->decodeMessage($messageBody, $structure->encoding);


            if (!empty($parameters['charset']) && $parameters['charset'] !== 'UTF-8') {
                if (function_exists('mb_convert_encoding')) {
                    if (!in_array($parameters['charset'], mb_list_encodings())) {
                        if ($structure->encoding === 0) {
                            $parameters['charset'] = 'US-ASCII';
                        } else {
                            $parameters['charset'] = 'UTF-8';
                        }
                    }
                    $messageBody = mb_convert_encoding($messageBody, 'UTF-8', $parameters['charset']);
                } else {
                    $messageBody = iconv($parameters['charset'], 'UTF-8//TRANSLIT', $messageBody);
                }
            }


            if (strtolower($structure->subtype) === 'plain' || ($structure->type == 1 && strtolower($structure->subtype) !== 'alternative')) {
                $this->plaintextMessage = '';
                $this->plaintextMessage .= trim(htmlentities($messageBody));
                $this->plaintextMessage = nl2br($this->plaintextMessage);
            } elseif (strtolower($structure->subtype) === 'html') {
                $this->htmlMessage = '';
                $this->htmlMessage .= $messageBody;
            }
        }
        if (isset($structure->parts)) {
            foreach ($structure->parts as $partIndex => $part) {
                $partId = $partIndex + 1;
                if (isset($partIdentifier))
                    $partId = $partIdentifier . '.' . $partId;
                $this->processStructure($uid, $part, $partId);
            }
        }
    }
    private function getOverview($uid) {
        $results = imap_fetch_overview($this->imapStream, $uid, FT_UID);
        $messageOverview = array_shift($results);
        if (!isset($messageOverview->date)) {
            $messageOverview->date = null;
        }
        return $messageOverview;
    }
    private function decode($text) {
        if (null === $text) {
            return null;
        }
        $result = '';
        foreach (imap_mime_header_decode($text) as $word) {
            $ch = 'default' === $word->charset ? 'ascii' : $word->charset;
            $result .= iconv($ch, 'utf-8', $word->text);
        }
        return $result;
    }
    private function processAddressObject($addresses) {
        $outputAddresses = array();
        if (is_array($addresses))
            foreach ($addresses as $address) {
                if (property_exists($address, 'mailbox') && $address->mailbox != 'undisclosed-recipients') {
                    $currentAddress = array();
                    $currentAddress['address'] = $address->mailbox . '@' . $address->host;
                    if (isset($address->personal)) {
                        $currentAddress['name'] = $this->decode($address->personal);
                    }
                    $outputAddresses = $currentAddress;
                }
            }
        return $outputAddresses;
    }
    private function getHeaders($uid) {
        $rawHeaders = $this->getRawHeaders($uid);
        $headerObject = imap_rfc822_parse_headers($rawHeaders);
        if (isset($headerObject->date)) {
            $headerObject->udate = strtotime($headerObject->date);
        } else {
            $headerObject->date = null;
            $headerObject->udate = null;
        }
        $this->headers = $headerObject;
        return $this->headers;
    }
    private function getRawHeaders($uid) {
        $rawHeaders = imap_fetchheader($this->imapStream, $uid, FT_UID);
        return $rawHeaders;
    }
    private function getStructure($uid) {
        $structure = imap_fetchstructure($this->imapStream, $uid, FT_UID);
        return $structure;
    }
    public function __destruct() {
        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                //SAVE YOUR LOG OF ERRORS
            }
        }
    }


    public function view_mailbox(Request $request)
    {
       $data['result'] =  mailbox::where('token', $request->token)->first();
        return view('admin.mail_box.view', $data);
    }



    public function readmailX()
    {


        @ini_set('memory_limit', '1024M');
        @ini_set('upload_max_filesize', '512M');
        @ini_set('post_max_size', '512M');
        @ini_set('max_input_time', 120);
        @ini_set('max_execution_time', 180);
            $setups =  mailsetup::where('status','Active')->get();


        if($setups)
    foreach($setups as $key=>$config){
         $oClient = new Client([
            'host' => $config->host , //'quickbd.net',
            'port' => $config->port , //993,
            'encryption' => $config->encryption , //'ssl', pop3 or nntp
            'validate_cert' => true,
            'username' => $config->username , //'info@quickbd.net',
            'password' => $config->password , //'Qbd226162#',
            'protocol' => $config->protocol  //imap
        ]);



        /* Alternative by using the Facade
        $oClient = Webklex\IMAP\Facades\Client::account('default');
        */
//Connect to the IMAP Server
        if($oClient->connect()) {
            $oFolder = $oClient->getFolder('INBOX.read');
            # return  $aMessage = $oFolder->query()->get();
//Get all Mailboxes
            /** @var \Webklex\IMAP\Support\FolderCollection $aFolder */


            //  $data['inbox'] = $oClient->getMessages($oClient->getFolder('INBOX') );
            //  $aMessage = $oClient->getUnseenMessages($oClient->getFolder('INBOX'));

             $aMessage = $oFolder->query()->get();
            //   $aMessage = $oFolder->messages()->unseen()->setFetchFlags(false)->setFetchAttachment(true)->new()->since(now()->subDays(0))->get();

            foreach ($aMessage as $oMessage) {

               // echo '<pre>';
                // print_r($oMessage);

               // echo 'Attachments: '.$oMessage->getAttachments()->count().'<br />';
                $aAttachment = $oMessage->getAttachments();

               if ($oMessage->getAttachments()->count()> 0  ) {

                //    if ($aAttachment ) {

                //    echo 'Attachments: ' . $aAttachment->count() . '<br />';
                    $aAttachment->each(function ($oAttachment) use($config, $oMessage) {

                        $result =  mailbox::Create(
                        [
                            'user_id' => $config->user_id,
                            'from_mail' => $oMessage->getFrom()[0]->mail,
                            'to_mail' => $oMessage->getTo()[0]->mail,
                            'subject' =>$oMessage->getSubject(),
                            'message' => $oMessage->getTextBody()
                        ]
                      );
                        //  echo $oMessage->getHTMLBody(true);
                       // echo '--------------======---------------<br>';
                        $path = public_path('mailbox/'.$result->id);
                        if(!File::isDirectory($path)){
                            File::makeDirectory($path, 0777, true, true);
                            $oAttachment->save($path, $oAttachment->name);
                        }else   $oAttachment->save($path, $oAttachment->name);
                        // print_r($oAttachment);

                    });

                    //Move the current Message to 'INBOX.read'
                    /*if($oMessage->moveToFolder('INBOX.read') == true){
                        echo 'Message has been moved';
                    }else{
                        echo 'Message could not be moved';
                    }*/

                }
            }
        } $oClient->disconnect();

    }

    }

public function  cv_mail_inbox(Request $request){
    $perPage = 20;
   $data['inbox'] = mailbox::where('user_id', Auth::id())->get()->paginate($perPage);

    return view('/admin/.mail_box.inbox', $data);
}

}
