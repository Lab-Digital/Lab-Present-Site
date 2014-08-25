<?php
class Mail
{
   private $isLocalhost = true;

   const FROM_EMAIL    = 'labdigital@site.ru';
   const COMPANY_NAME  = 'Lab Digital';
   const COMPANY_SITE  = 'labdigital.local';
   const COMPANY_EMAIL = '2lab.digital@gmail.com';

   // const COMPANY_LOGO  = '<a href="http://camerapeople.com/"><img src="http://camerapeople.com/images/logo.png"></a><br><br>';

   public function compareUniqueSignature($hash, $email, $pass)
   {
      return $hash == $this->getUniqueSignature($email, $pass);
   }

   private function saveToFile($to, $subject, $text, $from, $fromName)
   {
      $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/mails/';
      if (!file_exists($uploaddir)) {
         mkdir($uploaddir);
      }
      $file = fopen($uploaddir . $to . 'txt', "w");
      $letter = sprintf("To:\t%s\n\nFrom:\t%s\n\nFrom Name:\t%s\n\nSubject:\t%s\n\nText:\t%s\n\n", $to, $from, $fromName, $subject, $text);
      fwrite($file, $letter);
      fclose($file);
   }

   public function SendNewProposalMail($name, $email, $phone, $task)
   {
      $subject = 'Новая заявка на ' . static::COMPANY_NAME;
      $message = sprintf("Имя: %s<br>E-mail: %s<br>Телефон: %s<br>Задача: %s<br>", $name, $email, $phone, $task);
      if ($this->isLocalhost) {
         $this->saveToFile(static::COMPANY_EMAIL, $subject, $message, static::FROM_EMAIL, static::COMPANY_NAME);
      } else {
         sendEmail(static::COMPANY_EMAIL, $subject, $message, static::FROM_EMAIL, static::COMPANY_NAME);
      }
   }
}

function SendEmail($to, $subject, $text, $from, $fromName)
{
   $mail = new Mailer();
   $mail->from = $from;
   $mail->fromName = $fromName;
   $mail->addAddress($to, '');
   $mail->isHTML(true);
   $mail->subject = $subject;
   $mail->body = $text;
   $mail->send();
}

class Mailer
{
   var $priority = 3;
   var $charSet = "utf-8";
   var $contentType = "text/plain";
   var $encoding = "8bit";
   var $errorInfo = "";
   var $from = "noreply@sintezf.com";
   var $fromName = "SintezF";
   var $sender = "";
   var $subject = "";
   var $body = "";
   var $altBody = "";
   var $wordWrap = 0;
   var $mailer = "mail";
   var $sendmail = "/usr/sbin/sendmail";
   var $pluginDir = "";
   var $version = "1.73";
   var $confirmReadingTo = "";
   var $hostname = "";
   var $host = "sintezf.com";
   var $port = 25;
   var $helo = "";
   var $SMTPAuth = false;
   var $username = "";
   var $password = "";
   var $timeout = 10;
   var $SMTPDebug = false;
   var $SMTPKeepAlive = false;
   var $smtp = NULL;
   var $to = array();
   var $cc = array();
   var $bcc = array();
   var $replyTo = array();
   var $attachment = array();
   var $customHeader = array();
   var $message_type = "";
   var $boundary = array();
   var $language = array();
   var $error_count = 0;
   var $LE = "\n";

   function addAddress($address, $name = "")
   {
      $cur = count($this->to);
      $this->to[$cur][0] = trim($address);
      $this->to[$cur][1] = $name;
   }

   function isHTML($bool)
   {
      if ($bool == true)
         $this->contentType = "text/html";
      else
         $this->contentType = "text/plain";
   }

   function isSMTP()
   {
      $this->mailer = "smtp";
   }

   function isMail()
   {
      $this->mailer = "mail";
   }

   function isSendmail()
   {
      $this->mailer = "sendmail";
   }

   function isQmail()
   {
      $this->sendmail = "/var/qmail/bin/sendmail";
      $this->mailer = "sendmail";
   }

   function addCC($address, $name = "")
   {
      $cur = count($this->cc);
      $this->cc[$cur][0] = trim($address);
      $this->cc[$cur][1] = $name;
   }

   function addBCC($address, $name = "")
   {
      $cur = count($this->bcc);
      $this->bcc[$cur][0] = trim($address);
      $this->bcc[$cur][1] = $name;
   }

   function addReplyTo($address, $name = "")
   {
      $cur = count($this->replyTo);
      $this->replyTo[$cur][0] = trim($address);
      $this->replyTo[$cur][1] = $name;
   }

   function send()
   {
      $header = "";
      $body = "";
      $result = true;
      if ((count($this->to) + count($this->cc) + count($this->bcc)) < 1) {
         return false;
      }
      if (!empty($this->altBody))
         $this->contentType = "multipart/alternative";
      $this->error_count = 0;
      $this->setMessageType();
      $header .= $this->createHeader();
      $body = $this->createBody();
      if ($body == "")
         return false;

      switch ($this->mailer) {
         case "sendmail":
            $result = $this->sendmailSend($header, $body);
            break;
         case "mail":
            $result = $this->mailSend($header, $body);
            break;
         case "smtp":
            $result = $this->smtpSend($header, $body);
            break;
         default:
            $result = false;
            break;
      }
      return $result;
   }

   function sendmailSend($header, $body)
   {
      if ($this->sender != "")
         $sendmail = sprintf("%s -oi -f %s -t", $this->sendmail, $this->sender);
      else
         $sendmail = sprintf("%s -oi -t", $this->sendmail);
      if (!@$mail = popen($sendmail, "w")) {
         return false;
      }
      fputs($mail, $header);
      fputs($mail, $body);
      $result = pclose($mail) >> 8 & 0xFF;
      if ($result != 0) {
         return false;
      }
      return true;
   }

   function mailSend($header, $body)
   {
      $to = "";
      for ($i = 0; $i < count($this->to); $i++) {
         if ($i != 0)
            $to .= ", ";
         $to .= $this->to[$i][0];
      }
      if ($this->sender != "" && strlen(ini_get("safe_mode")) < 1) {
         $old_from = ini_get("sendmail_from");
         ini_set("sendmail_from", $this->sender);
         $params = sprintf("-oi -f %s", $this->sender);
         $rt = @mail($to, $this->encodeHeader($this->subject), $body, $header, $params);
      } else
         $rt = @mail($to, $this->encodeHeader($this->subject), $body, $header);
      if (isset($old_from))
         ini_set("sendmail_from", $old_from);
      if (!$rt) {
         return false;
      }
      return true;
   }

   function smtpSend($header, $body)
   {
      $error = "";
      $bad_rcpt = array();
      if (!$this->smtpConnect()) {
         return false;
      }
      $smtp_from = ($this->sender == "") ? $this->from : $this->sender;
      if (!$this->smtp->mail($smtp_from)) {
         $this->smtp->reset();
         return false;
      }

      for ($i = 0; $i < count($this->to); $i++)
         if (!$this->smtp->recipient($this->to[$i][0]))
            $bad_rcpt[] = $this->to[$i][0];
      for ($i = 0; $i < count($this->cc); $i++)
         if (!$this->smtp->recipient($this->cc[$i][0]))
            $bad_rcpt[] = $this->cc[$i][0];
      for ($i = 0; $i < count($this->bcc); $i++)
         if (!$this->smtp->recipient($this->bcc[$i][0]))
            $bad_rcpt[] = $this->bcc[$i][0];

      if (count($bad_rcpt) > 0) {
         for ($i = 0; $i < count($bad_rcpt); $i++) {
            if ($i != 0)
               $error .= ", ";
            $error .= $bad_rcpt[$i];
         }
         $this->smtp->reset();
         return false;
      }

      if (!$this->smtp->data($header . $body)) {
         $this->smtp->reset();
         return false;
      }
      if ($this->SMTPKeepAlive == true)
         $this->smtp->reset();
      else
         $this->smtpClose();
      return true;
   }

   function smtpConnect()
   {
      if ($this->smtp == NULL)
         $this->smtp = new SMTP();
      $this->smtp->do_debug = $this->SMTPDebug;
      $hosts = explode(";", $this->host);
      $index = 0;
      $connection = ($this->smtp->connected());
      while ($index < count($hosts) && $connection == false) {
         if (strstr($hosts[$index], ":"))
            list($host, $port) = explode(":", $hosts[$index]);
         else {
            $host = $hosts[$index];
            $port = $this->port;
         }

         if ($this->smtp->connect($host, $port, $this->timeout)) {
            $connection = true;
            if ($this->helo != '')
               $this->smtp->hello($this->helo);
            else
               $this->smtp->hello($this->serverHostname());

            if ($this->SMTPAuth) {
               if (!$this->smtp->authenticate($this->username, $this->password)) {
                  $this->smtp->reset();
                  $connection = false;
               }
            }
         }
         $index++;
      }
      return $connection;
   }

   function smtpClose()
   {
      if ($this->smtp != NULL) {
         if ($this->smtp->connected()) {
            $this->smtp->quit();
            $this->smtp->close();
         }
      }
   }

   function addrAppend($type, $addr)
   {
      $addr_str = $type . ": ";
      $addr_str .= $this->addrFormat($addr[0]);
      if (count($addr) > 1)
         for ($i = 1; $i < count($addr); $i++)
            $addr_str .= ", " . $this->addrFormat($addr[$i]);
      $addr_str .= $this->LE;
      return $addr_str;
   }

   function addrFormat($addr)
   {
      if (empty($addr[1]))
         $formatted = $addr[0];
      else
         $formatted = $this->encodeHeader($addr[1], 'phrase') . " <" . $addr[0] . ">";
      return $formatted;
   }

   function wrapText($message, $length, $qp_mode = false)
   {
      $soft_break = ($qp_mode) ? sprintf(" =%s", $this->LE) : $this->LE;

      $message = $this->fixEOL($message);
      if (substr($message, -1) == $this->LE)
         $message = substr($message, 0, -1);

      $line = explode($this->LE, $message);
      $message = "";
      for ($i = 0; $i < count($line); $i++) {
         $line_part = explode(" ", $line[$i]);
         $buf = "";
         for ($e = 0; $e < count($line_part); $e++) {
            $word = $line_part[$e];
            if ($qp_mode and (strlen($word) > $length)) {
               $space_left = $length - strlen($buf) - 1;
               if ($e != 0) {
                  if ($space_left > 20) {
                     $len = $space_left;
                     if (substr($word, $len - 1, 1) == "=")
                        $len--;
                     elseif (substr($word, $len - 2, 1) == "=")
                        $len -= 2;
                     $part = substr($word, 0, $len);
                     $word = substr($word, $len);
                     $buf .= " " . $part;
                     $message .= $buf . sprintf("=%s", $this->LE);
                  } else {
                     $message .= $buf . $soft_break;
                  }
                  $buf = "";
               }
               while (strlen($word) > 0) {
                  $len = $length;
                  if (substr($word, $len - 1, 1) == "=")
                     $len--;
                  elseif (substr($word, $len - 2, 1) == "=")
                     $len -= 2;
                  $part = substr($word, 0, $len);
                  $word = substr($word, $len);

                  if (strlen($word) > 0)
                     $message .= $part . sprintf("=%s", $this->LE);
                  else
                     $buf = $part;
               }
            } else {
               $buf_o = $buf;
               $buf .= ($e == 0) ? $word : (" " . $word);

               if (strlen($buf) > $length and $buf_o != "") {
                  $message .= $buf_o . $soft_break;
                  $buf = $word;
               }
            }
         }
         $message .= $buf . $this->LE;
      }
      return $message;
   }

   function SetWordWrap()
   {
      if ($this->wordWrap < 1)
         return;

      switch ($this->message_type) {
         case "alt":
            // fall through
         case "alt_attachments":
            $this->altBody = $this->wrapText($this->altBody, $this->wordWrap);
            break;
         default:
            $this->body = $this->wrapText($this->body, $this->wordWrap);
            break;
      }
   }

   function createHeader()
   {
      $result = "";

      $uniq_id = md5(uniqid(time()));
      $this->boundary[1] = "b1_" . $uniq_id;
      $this->boundary[2] = "b2_" . $uniq_id;

      $result .= $this->headerLine("Date", $this->RFCDate());
      if ($this->sender == "")
         $result .= $this->headerLine("Return-Path", trim($this->from));
      else
         $result .= $this->headerLine("Return-Path", trim($this->sender));

      if ($this->mailer != "mail") {
         if (count($this->to) > 0)
            $result .= $this->addrAppend("To", $this->to);
         else if (count($this->cc) == 0)
            $result .= $this->headerLine("To", "undisclosed-recipients:;");
         if (count($this->cc) > 0)
            $result .= $this->addrAppend("Cc", $this->cc);
      }

      $from = array();
      $from[0][0] = trim($this->from);
      $from[0][1] = $this->fromName;
      $result .= $this->addrAppend("from", $from);

      if ((($this->mailer == "sendmail") || ($this->mailer == "mail")) && (count($this->bcc) > 0))
         $result .= $this->addrAppend("Bcc", $this->bcc);

      if (count($this->replyTo) > 0)
         $result .= $this->addrAppend("Reply-to", $this->replyTo);

      if ($this->mailer != "mail")
         $result .= $this->headerLine("subject", $this->encodeHeader(trim($this->subject)));

      $result .= sprintf("Message-ID: <%s@%s>%s", $uniq_id, $this->serverHostname(), $this->LE);
      $result .= $this->headerLine("X-Priority", $this->priority);

      if ($this->confirmReadingTo != "") {
         $result .= $this->headerLine("Disposition-Notification-To", "<" . trim($this->confirmReadingTo) . ">");
      }

      for ($index = 0; $index < count($this->customHeader); $index++)
         $result .= $this->headerLine(trim($this->customHeader[$index][0]), $this->encodeHeader(trim($this->customHeader[$index][1])));
      $result .= $this->headerLine("MIME-Version", "1.0");

      switch ($this->message_type) {
         case "plain":
            $result .= $this->headerLine("Content-Transfer-Encoding", $this->encoding);
            $result .= sprintf("Content-Type: %s; charset=\"%s\"", $this->contentType, $this->charSet);
            break;
         case "attachments":
            // fall through
         case "alt_attachments":
            if ($this->inlineImageExists()) {
               $result .= sprintf("Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s", "multipart/related", $this->LE, $this->LE, $this->boundary[1], $this->LE);
            } else {
               $result .= $this->headerLine("Content-Type", "multipart/mixed;");
               $result .= $this->textLine("\tboundary=\"" . $this->boundary[1] . '"');
            }
            break;
         case "alt":
            $result .= $this->headerLine("Content-Type", "multipart/alternative;");
            $result .= $this->textLine("\tboundary=\"" . $this->boundary[1] . '"');
            break;
      }

      if ($this->mailer != "mail")
         $result .= $this->LE . $this->LE;

      return $result;
   }

   function createBody()
   {
      $result = "";

      $this->setWordWrap();

      switch ($this->message_type) {
         case "alt":
            $result .= $this->getBoundary($this->boundary[1], "", "text/plain", "");
            $result .= $this->encodeString($this->altBody, $this->encoding);
            $result .= $this->LE . $this->LE;
            $result .= $this->getBoundary($this->boundary[1], "",
               "text/html", "");

            $result .= $this->encodeString($this->body, $this->encoding);
            $result .= $this->LE . $this->LE;
            $result .= $this->endBoundary($this->boundary[1]);
            break;
         case "plain":
            $result .= $this->encodeString($this->body, $this->encoding);
            break;
         case "attachments":
            $result .= $this->getBoundary($this->boundary[1], "", "", "");
            $result .= $this->encodeString($this->body, $this->encoding);
            $result .= $this->LE;

            $result .= $this->attachAll();
            break;
         case "alt_attachments":
            $result .= sprintf("--%s%s", $this->boundary[1], $this->LE);
            $result .= sprintf("Content-Type: %s;%s" . "\tboundary=\"%s\"%s", "multipart/alternative", $this->LE, $this->boundary[2], $this->LE . $this->LE);
            // Create text body
            $result .= $this->getBoundary($this->boundary[2], "", "text/plain", "") . $this->LE;

            $result .= $this->encodeString($this->altBody, $this->encoding);
            $result .= $this->LE . $this->LE;

            // Create the HTML body
            $result .= $this->getBoundary($this->boundary[2], "", "text/html", "") . $this->LE;

            $result .= $this->encodeString($this->body, $this->encoding);
            $result .= $this->LE . $this->LE;

            $result .= $this->endBoundary($this->boundary[2]);

            $result .= $this->attachAll();
            break;
      }
      if ($this->isError())
         $result = "";

      return $result;
   }

   function getBoundary($boundary, $charSet, $contentType, $encoding)
   {
      $result = "";
      if ($charSet == "") {
         $charSet = $this->charSet;
      }
      if ($contentType == "") {
         $contentType = $this->contentType;
      }
      if ($encoding == "") {
         $encoding = $this->encoding;
      }

      $result .= $this->textLine("--" . $boundary);
      $result .= sprintf("Content-Type: %s; charset = \"%s\"", $contentType, $charSet);
      $result .= $this->LE;
      $result .= $this->headerLine("Content-Transfer-Encoding", $encoding);
      $result .= $this->LE;

      return $result;
   }

   function EndBoundary($boundary)
   {
      return $this->LE . "--" . $boundary . "--" . $this->LE;
   }

   function setMessageType()
   {
      if (count($this->attachment) < 1 && strlen($this->altBody) < 1)
         $this->message_type = "plain";
      else {
         if (count($this->attachment) > 0)
            $this->message_type = "attachments";
         if (strlen($this->altBody) > 0 && count($this->attachment) < 1)
            $this->message_type = "alt";
         if (strlen($this->altBody) > 0 && count($this->attachment) > 0)
            $this->message_type = "alt_attachments";
      }
   }

   function headerLine($name, $value)
   {
      return $name . ": " . $value . $this->LE;
   }

   function textLine($value)
   {
      return $value . $this->LE;
   }

   function addAttachment($path, $name = "", $encoding = "base64", $type = "application/octet-stream")
   {
      if (!@is_file($path)) {
         return false;
      }

      $filename = basename($path);
      if ($name == "")
         $name = $filename;

      $cur = count($this->attachment);
      $this->attachment[$cur][0] = $path;
      $this->attachment[$cur][1] = $filename;
      $this->attachment[$cur][2] = $name;
      $this->attachment[$cur][3] = $encoding;
      $this->attachment[$cur][4] = $type;
      $this->attachment[$cur][5] = false;
      $this->attachment[$cur][6] = "attachment";
      $this->attachment[$cur][7] = 0;

      return true;
   }

   function attachAll()
   {
      $mime = array();

      for ($i = 0; $i < count($this->attachment); $i++) {
         $bString = $this->attachment[$i][5];
         if ($bString)
            $string = $this->attachment[$i][0];
         else
            $path = $this->attachment[$i][0];

         $filename = $this->attachment[$i][1];
         $name = $this->attachment[$i][2];
         $encoding = $this->attachment[$i][3];
         $type = $this->attachment[$i][4];
         $disposition = $this->attachment[$i][6];
         $cid = $this->attachment[$i][7];

         $mime[] = sprintf("--%s%s", $this->boundary[1], $this->LE);
         $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $name, $this->LE);
         $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);

         if ($disposition == "inline")
            $mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);

         $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", $disposition, $name, $this->LE . $this->LE);

         if ($bString) {
            $mime[] = $this->encodeString($string, $encoding);
            if ($this->isError()) {
               return "";
            }
            $mime[] = $this->LE . $this->LE;
         } else {
            $mime[] = $this->encodeFile($path, $encoding);
            if ($this->isError()) {
               return "";
            }
            $mime[] = $this->LE . $this->LE;
         }
      }
      $mime[] = sprintf("--%s--%s", $this->boundary[1], $this->LE);

      return join("", $mime);
   }

   function encodeFile($path, $encoding = "base64")
   {
      if (!@$fd = fopen($path, "rb")) {
         return "";
      }
      $magic_quotes = get_magic_quotes_runtime();
      set_magic_quotes_runtime(0);
      $file_buffer = fread($fd, filesize($path));
      $file_buffer = $this->encodeString($file_buffer, $encoding);
      fclose($fd);
      set_magic_quotes_runtime($magic_quotes);

      return $file_buffer;
   }

   function encodeString($str, $encoding = "base64")
   {
      $encoded = "";
      switch (strtolower($encoding)) {
         case "base64":
            $encoded = chunk_split(base64_encode($str), 76, $this->LE);
            break;
         case "7bit":
         case "8bit":
            $encoded = $this->fixEOL($str);
            if (substr($encoded, -(strlen($this->LE))) != $this->LE)
               $encoded .= $this->LE;
            break;
         case "binary":
            $encoded = $str;
            break;
         case "quoted-printable":
            $encoded = $this->encodeQP($str);
            break;
         default:
            break;
      }
      return $encoded;
   }

   function encodeHeader($str, $position = 'text')
   {
      $x = 0;
      switch (strtolower($position)) {
         case 'phrase':
            if (!preg_match('/[\200-\377]/', $str)) {
               $encoded = addcslashes($str, "\0..\37\177\\\"");

               if (($str == $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str))
                  return ($encoded);
               else
                  return ("\"$encoded\"");
            }
            $x = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);
            break;
         case 'comment':
            $x = preg_match_all('/[()"]/', $str, $matches);
         // Fall-through
         case 'text':
         default:
            $x += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);
            break;
      }

      if ($x == 0)
         return ($str);

      $maxlen = 75 - 7 - strlen($this->charSet);
      if (strlen($str) / 3 < $x) {
         $encoding = 'B';
         $encoded = base64_encode($str);
         $maxlen -= $maxlen % 4;
         $encoded = trim(chunk_split($encoded, $maxlen, "\n"));
      } else {
         $encoding = 'Q';
         $encoded = $this->encodeQ($str, $position);
         $encoded = $this->wrapText($encoded, $maxlen, true);
         $encoded = str_replace("=" . $this->LE, "\n", trim($encoded));
      }

      $encoded = preg_replace('/^(.*)$/m', " =?" . $this->charSet . "?$encoding?\\1?=", $encoded);
      $encoded = trim(str_replace("\n", $this->LE, $encoded));

      return $encoded;
   }

   function encodeQP($str)
   {
      $encoded = $this->fixEOL($str);
      if (substr($encoded, -(strlen($this->LE))) != $this->LE)
         $encoded .= $this->LE;

      $encoded = preg_replace('/([\000-\010\013\014\016-\037\075\177-\377])/e', "'='.sprintf('%02X', ord('\\1'))", $encoded);
      $encoded = preg_replace("/([\011\040])" . $this->LE . "/e", "'='.sprintf('%02X', ord('\\1')).'" . $this->LE . "'", $encoded);

      $encoded = $this->wrapText($encoded, 74, true);

      return $encoded;
   }

   function encodeQ($str, $position = "text")
   {
      $encoded = preg_replace("[\r\n]", "", $str);

      switch (strtolower($position)) {
         case "phrase":
            $encoded = preg_replace("/([^A-Za-z0-9!*+\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
            break;
         case "comment":
            $encoded = preg_replace("/([\(\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
         case "text":
         default:
            $encoded = preg_replace('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/e', "'='.sprintf('%02X', ord('\\1'))", $encoded);
            break;
      }
      $encoded = str_replace(" ", "_", $encoded);

      return $encoded;
   }

   function addStringAttachment($string, $filename, $encoding = "base64", $type = "application/octet-stream")
   {
      $cur = count($this->attachment);
      $this->attachment[$cur][0] = $string;
      $this->attachment[$cur][1] = $filename;
      $this->attachment[$cur][2] = $filename;
      $this->attachment[$cur][3] = $encoding;
      $this->attachment[$cur][4] = $type;
      $this->attachment[$cur][5] = true; // isString
      $this->attachment[$cur][6] = "attachment";
      $this->attachment[$cur][7] = 0;
   }

   function addEmbeddedImage($path, $cid, $name = "", $encoding = "base64", $type = "application/octet-stream")
   {

      if (!@is_file($path)) {
         return false;
      }

      $filename = basename($path);
      if ($name == "")
         $name = $filename;

      $cur = count($this->attachment);
      $this->attachment[$cur][0] = $path;
      $this->attachment[$cur][1] = $filename;
      $this->attachment[$cur][2] = $name;
      $this->attachment[$cur][3] = $encoding;
      $this->attachment[$cur][4] = $type;
      $this->attachment[$cur][5] = false;
      $this->attachment[$cur][6] = "inline";
      $this->attachment[$cur][7] = $cid;

      return true;
   }

   function inlineImageExists()
   {
      $result = false;
      for ($i = 0; $i < count($this->attachment); $i++) {
         if ($this->attachment[$i][6] == "inline") {
            $result = true;
            break;
         }
      }

      return $result;
   }

   function clearAddresses()
   {
      $this->to = array();
   }

   function clearCCs()
   {
      $this->cc = array();
   }

   function clearBCCs()
   {
      $this->bcc = array();
   }

   function clearReplyTos()
   {
      $this->replyTo = array();
   }

   function clearAllRecipients()
   {
      $this->to = array();
      $this->cc = array();
      $this->bcc = array();
   }

   function clearAttachments()
   {
      $this->attachment = array();
   }

   function clearCustomHeaders()
   {
      $this->customHeader = array();
   }

   function setError($msg)
   {
      $this->error_count++;
      $this->errorInfo = $msg;
   }

   function RFCDate()
   {
      $tz = date("Z");
      $tzs = ($tz < 0) ? "-" : "+";
      $tz = abs($tz);
      $tz = ($tz / 3600) * 100 + ($tz % 3600) / 60;
      $result = sprintf("%s %s%04d", date("D, j M Y H:i:s"), $tzs, $tz);

      return $result;
   }

   function serverVar($varName)
   {
      global $HTTP_SERVER_VARS;
      global $HTTP_ENV_VARS;

      if (!isset($_SERVER)) {
         $_SERVER = $HTTP_SERVER_VARS;
         if (!isset($_SERVER["REMOTE_ADDR"]))
            $_SERVER = $HTTP_ENV_VARS;
      }

      if (isset($_SERVER[$varName]))
         return $_SERVER[$varName];
      else
         return "";
   }

   function serverHostname()
   {
      if ($this->hostname != "")
         $result = $this->hostname;
      elseif ($this->serverVar('SERVER_NAME') != "")
         $result = $this->serverVar('SERVER_NAME');
      else
         $result = "localhost.localdomain";

      return $result;
   }

   function isError()
   {
      return ($this->error_count > 0);
   }

   function fixEOL($str)
   {
      $str = str_replace("\r\n", "\n", $str);
      $str = str_replace("\r", "\n", $str);
      $str = str_replace("\n", $this->LE, $str);
      return $str;
   }

   function addCustomHeader($custom_header)
   {
      $this->customHeader[] = explode(":", $custom_header, 2);
   }
}
