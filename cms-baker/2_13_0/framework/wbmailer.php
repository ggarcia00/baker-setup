<?php
/**
 *
 * @category        framework
 * @package         frontend
 * @subpackage      wbmailer
 * @author          Ryan Djurovich, WebsiteBaker Project
 * @copyright       WebsiteBaker Org. e.V.
 * @link            http://websitebaker.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.10.1
 * @requirements    PHP 5.3.6 and higher
 * @version         $Id: class.wbmailer.php 234 2019-03-17 06:05:56Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb/2.12.x/branches/main/framework/class.wbmailer.php $
 * @lastmodified    $Date: 2019-03-17 07:05:56 +0100 (So, 17. Mrz 2019) $
 * @examples        http://phpmailer.worxware.com/index.php?pg=examples
 *
 */



use bin\requester\HttpRequester;
use bin\{WbAdaptor,SecureTokens,Sanitize};
use PHPMailer\PHPMailer\{PHPMailer,SMTP,Exception};


/* -------------------------------------------------------- */
// Must include code to prevent this file from being accessed directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/* -------------------------------------------------------- */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
\date_default_timezone_set('Etc/UTC');

// Include PHPMailer autoloader in initialize

class wbmailer extends PHPMailer
{
    // new websitebaker mailer class (subset of PHPMailer class)
    // setting default values

    public $aConfig = [];

    public function __construct($exceptions = false) {//
//      Passing true to the constructor enables the use of exceptions for error handling
        parent::__construct($exceptions);//
        $this->mailerInit($exceptions);
    }


    /**
     * CopyAddons::__isset()
     *
     * @param mixed $name
     * @return
     */
    public function __isset($name)
    {
        $sRetval = ($this->aConfig[$name] ?? null);
        $sRetval = ($this->$name ?? $sRetval);
        return (bool) $sRetval;
    }
    /**
     * handle unknown properties
     * @param string name of the property
     * @param mixed value to set
     * @throws InvalidArgumentException
     */
    public function __set($name, $value)
    {
        if (\array_key_exists($name, $this->aConfig)) {
            throw new \InvalidArgumentException('tried to set readonly or nonexisting property [ '.$name.' }!! ');
        } else {
            $this->aConfig[$name] = $value;
        }
    }

    /**
     * Get value of a variable
     * @param string name of the variable
     * @return mixed
     */
    public function __get($name)
    {
        $sRetval = ($this->aConfig[$name] ?? null);
        $sRetval = ($this->$name ?? $sRetval);
        if ($sRetval) {
            return $sRetval;
        }
        throw new \InvalidArgumentException('Tried to get none existing property ['.__CLASS__.'::'.$name.']');
    }

    protected function fromArray(array $data = []) {
        foreach (get_object_vars($obj = new self) as $property => $default) {
            if (!array_key_exists($property, $data)){ continue;}
            $obj->{$property} = $data[$property]; // assign value to object
        }
        return $obj;
    }

/********************************************************************************************/
//
/********************************************************************************************/

    public function setData($name, $value = '')
    {
        $this->aConfig[$name] = $value;
    }

    public function getData($name)
    {
        $sRetval = ($this->aConfig[$name] ?? null);
        $sRetval = ($this->$name ?? $sRetval);
        return $sRetval;
    }

/********************************************************************************************/
//
/********************************************************************************************/

    public function mailerInit($exceptions = false)
    {
        $this->aConfig['Reg'] = WbAdaptor::getInstance();
        $this->aConfig['Db'] = WbAdaptor::getInstance()->getDatabase();
        $this->aConfig['Trans'] = WbAdaptor::getInstance()->getTranslate();
        $this->aConfig['Req'] = WbAdaptor::getInstance()->getRequester();
        $this->aConfig['App'] = WbAdaptor::getInstance()->getApplication();
        $this->aConfig['error'] = [];
        $this->aConfig['wbmailer_settings'] = WbAdaptor::getInstance()->getApplication()->getSettings('wbmailer_%,server_email');//
        $this->mailerSettings($exceptions);
    }

    public function mailerSettings($exceptions = false)
    {
        $db_server_email = $this->wbmailer_settings['server_email']; // required
        // set mailer defaults (PHP mail function)
        $db_wbmailer_routine = $this->wbmailer_settings['wbmailer_routine'];
        $db_wbmailer_smtp_debug = ($this->wbmailer_settings['wbmailer_smtp_debug'] ?? 0);
        $db_wbmailer_default_sendername = $this->wbmailer_settings['wbmailer_default_sendername']; // required
/**
     * `echo` Output plain-text as-is, appropriate for CLI
     * `html` Output escaped, line breaks converted to `<br>`, appropriate for browser output
     * `error_log` Output to error log as configured in php.ini
     *
     * Alternatively, you can provide a callable expecting two params: a message string and the debug level:
     * <code>
     * $this->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
     * </code>
 */

        $this->set('Debugoutput', 'html');

        try {
//            set method to send out emails
                if ($db_wbmailer_routine == "smtp") {
//            required if smtp
                $db_wbmailer_smtp_host = $this->wbmailer_settings['wbmailer_smtp_host'];
                $db_wbmailer_smtp_secure = $this->wbmailer_settings['wbmailer_smtp_secure'];
                $db_wbmailer_smtp_port = $this->wbmailer_settings['wbmailer_smtp_port']; // required
                $db_wbmailer_smtp_auth = $this->wbmailer_settings['wbmailer_smtp_auth'];
                $db_wbmailer_smtp_username = $this->wbmailer_settings['wbmailer_smtp_username'];
                $db_wbmailer_smtp_password = $this->wbmailer_settings['wbmailer_smtp_password'];
//            Enable SMTP debugging
                if ($exceptions && $db_wbmailer_smtp_debug){
                    //SMTP::DEBUG_OFF = off (for production use)
                    //SMTP::DEBUG_CLIENT = client messages
                    //SMTP::DEBUG_SERVER = client and server messages
                    $this->SMTPDebug = (int)$db_wbmailer_smtp_debug;
                } else {
                  $this->SMTPDebug = SMTP::DEBUG_OFF;
                }
                //use SMTP for all outgoing mails send by Website Baker
                $this->isSMTP();                                                // telling the class to use SMTP
                $this->CharSet = PHPMailer::CHARSET_UTF8;                       //
                $this->set('SMTPAuth', false);                                  // enable SMTP authentication
                $this->set('Host', $db_wbmailer_smtp_host);                     // Set the hostname of the mail server
                $this->set('Port', \intval($db_wbmailer_smtp_port));            // Set the SMTP port number - likely to be 25, 465 or 587
                $this->set('SMTPSecure', \strtolower($db_wbmailer_smtp_secure));// Set the encryption system to use - ssl (deprecated) or tls
                $this->set('SMTPKeepAlive', false);                             // SMTP connection will be close after each email sent
                // check if SMTP authentification is required
                if ($db_wbmailer_smtp_auth  && (\mb_strlen($db_wbmailer_smtp_username) > 1) && (\mb_strlen($db_wbmailer_smtp_password) > 1) ) {
                    // use SMTP authentification
                    $this->set('SMTPAuth', $db_wbmailer_smtp_auth);             // enable SMTP authentication
                    $this->set('Username', $db_wbmailer_smtp_username);         // set SMTP username
                    $this->set('Password', $db_wbmailer_smtp_password);         // set SMTP password
                }
            } else if ($db_wbmailer_routine == "phpmail") {
                $this->set('SMTPDebug', (int)$db_wbmailer_smtp_debug);         // Enable verbose debug output
                //use PHP mail() function for outgoing mails send by Website Baker
                $this->IsMail();
            } else {
                $this->set('SMTPDebug', (int)$db_wbmailer_smtp_debug);    // Enable verbose debug output
                $this->isSendmail();   // telling the class to use SendMail transport
            }

        } catch (Exception $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (\Exception $e) { //The leading slash means the Global PHP Exception class will be caught
            echo $e->getMessage(); //Boring error messages from anything else!
        }

        // set default charset
        if (\defined('DEFAULT_CHARSET')) {
            $this->set('CharSet', DEFAULT_CHARSET);
        } else {
            $this->set('CharSet', 'utf-8');
        }

        // set default sender name
        if ($this->FromName == 'Root User') {
            if (isset($_SESSION['DISPLAY_NAME'])) {
                $this->set('FromName', $_SESSION['DISPLAY_NAME']);        // FROM NAME: display name of user logged in
            } else {
                $this->set('FromName', $db_wbmailer_default_sendername);  // FROM NAME: set default name
            }
        }

        /*
            some mail provider (lets say mail.com) reject mails send out by foreign mail
            relays but using the providers domain in the from mail address (e.g. myname@mail.com)
        $this->setFrom($db_server_email);                       // FROM MAIL: (server mail)
        */

    } // end mailerSettings

    public function setMailFormats($format='html'){
        if ($format=='html'){
        // set default mail formats
            parent::IsHTML(); // Sets message type to HTML.
        } else {
            parent::IsHTML(false); // Sets message type to plain.
            parent::set('WordWrap', 70);
        }
    }

    public function setLanguage($lang='en', $langPath = 'language'){
        // set language file for PHPMailer error messages
        parent::SetLanguage(\strtolower($lang),$langPath);    // english default (also used if file is missing)
    }

    public function removebreaks($value) {
        return (\preg_replace('#((<CR>|<LF>|0x0A/%0A|0x0D/%0D|\\n|\\r)\S).*#i', null, $value));
    }

    public function checkbreaks($value) {
        return $value === $this->removebreaks($value);
    }

    //Extend the send function
    public function send()
    {
        $r = parent::send();
        return $r;
    }

    /**
     * Send messages using $Sendmail.
     * @return void
     * @description  overrides isSendmail() in parent
     */
    public function isSendmail()
    {
        $ini_sendmail_path = \ini_get('sendmail_path');
        if (!\preg_match('/sendmail$/i', $ini_sendmail_path)) {
            if ($this->exceptions) {
                throw new Exception('no sendmail available');
            }
        } else {
            $this->Sendmail = $ini_sendmail_path;
            $this->Mailer = 'sendmail';
        }
    }

    public function checkSmpt(){
        //Create a new SMTP instance
        $smtp = new SMTP;
        //Enable connection-level debug output
        $smtp->do_debug = SMTP::DEBUG_CONNECTION;
        try {
            //Connect to an SMTP server
            if (!$smtp->connect($this->smtp_host, 25)) {
                throw new Exception('Connect failed');
            }
            //Say hello
            if (!$smtp->hello(gethostname())) {
                throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
            }
            //Get the list of ESMTP services the server offers
            $e = $smtp->getServerExtList();
            //If server can do TLS encryption, use it
            if (is_array($e) && array_key_exists('STARTTLS', $e)) {
                $tlsok = $smtp->startTLS();
                if (!$tlsok) {
                    throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
                }
                //Repeat EHLO after STARTTLS
                if (!$smtp->hello(gethostname())) {
                    throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
                }
                //Get new capabilities list, which will usually now include AUTH if it didn't before
                $e = $smtp->getServerExtList();
            }
            //If server supports authentication, do it (even if no encryption)
            if (is_array($e) && array_key_exists('AUTH', $e)) {
                if ($smtp->authenticate('username', 'password')) {
                    echo 'Connected ok!';
                } else {
                    throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                }
            }
        } catch (Exception $e) {
            echo 'SMTP error: ' . $e->getMessage(), "\n";
        }
        //Whatever happened, close the connection.
        $smtp->quit();
    }

} // end of class wbmailer
