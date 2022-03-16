function change_os(type) {
    if(type === 'linux') {
        document.getElementById('file_perms_box1').style.display = 'block';
//console.info(type);
        document.getElementById('file_perms_box2').style.display = 'block';
        document.getElementById('file_perms_box3').style.display = 'block';
    } else if(type === 'windows') {
        document.getElementById('file_perms_box1').style.display = 'none';
//console.info(type);
        document.getElementById('file_perms_box2').style.display = 'none';
        document.getElementById('file_perms_box3').style.display = 'none';
    }
}

function change_wbmailer(type) {
//console.info(type);

    if(type === "smtp") {
        document.getElementById('row_wbmailer_smtp_debug').style.display = '';
        document.getElementById('row_wbmailer_smtp_debug').style.display = '';
        document.getElementById('row_wbmailer_smtp_host').style.display = '';
        document.getElementById('row_wbmailer_smtp_port').style.display = '';
        document.getElementById('row_wbmailer_smtp_secure').style.display = '';
        document.getElementById('row_wbmailer_smtp_auth_mode').style.display = 'none';
        document.getElementById('row_wbmailer_smtp_username').style.display = '';
        document.getElementById('row_wbmailer_smtp_password').style.display = '';
    } else if((type === "phpmail") || (type === "sendmail")) {
        document.getElementById('row_wbmailer_smtp_settings').style.display = '';
        document.getElementById('row_wbmailer_smtp_debug').style.display = 'none';
        document.getElementById('row_wbmailer_smtp_host').style.display = 'none';
        document.getElementById('row_wbmailer_smtp_port').style.display = 'none';
        document.getElementById('row_wbmailer_smtp_secure').style.display = 'none';
        document.getElementById('row_wbmailer_smtp_auth_mode').style.display = 'none';
        document.getElementById('row_wbmailer_smtp_username').style.display = 'none';
        document.getElementById('row_wbmailer_smtp_password').style.display = 'none';
    }
}
/*  */
function toggle_wbmailer_auth( elm ) {
        if ( elm.checked == true ) {
            elm.checked = false;
            document.getElementById('row_wbmailer_smtp_username').style.display = 'none';
            document.getElementById('row_wbmailer_smtp_password').style.display = 'none';
        }
        else  {
            elm.checked = true;
            document.getElementById('row_wbmailer_smtp_username').style.display = 'block';
            document.getElementById('row_wbmailer_smtp_password').style.display = 'block';
        }
//console.info(elm);
}

function toggle_wbmailer_secure( elm ) {
        if ( elm.value === '465' ) {
            document.getElementById('wbmailer_smtp_secure').value = 'SSL';
//console.info(elm);
        }
        else  {
//            document.getElementById('wbmailer_smtp_secure').value = 'block';
        }
}

domReady(function() {

    var system_linux = document.getElementById("operating_system_linux");
    if ( system_linux ){
        system_linux.addEventListener("click", function() {
            change_os( 'linux' );
        }, false);
    }

    var system_windows = document.getElementById("operating_system_windows");
    if ( system_windows ){
        system_windows.addEventListener("click", function() {
            change_os( 'windows' );
        }, false);
    }

    var phpmail = document.getElementById("wbmailer_routine_phpmail");
    if ( phpmail ){
        phpmail.addEventListener("click", function() {
            change_wbmailer( 'phpmail' );
        }, false);
    }

    var smtp = document.getElementById("wbmailer_routine_smtp");
    if ( smtp ){
        smtp.addEventListener("click", function() {
            change_wbmailer('smtp');
        }, false);
    }
/*
    var sendm = document.getElementById("wbmailer_routine_sendmail");
    if ( sendm ){
        sendm.addEventListener("click", function() {
            change_wbmailer('sendmail');
        }, false);
    }
*/
    var smtpAuth = document.getElementById("wbmailer_smtp_auth");
    if ( smtpAuth ){
        smtpAuth.addEventListener("click", function() {
            toggle_wbmailer_auth(smtpAuth);
        }, false);
    }

    var smtpPort = document.getElementById("wbmailer_smtp_port");
    if ( smtpPort ){
        smtpPort.addEventListener("change", function() {
            toggle_wbmailer_secure(smtpPort);
        }, false);
    }

/*
    function toggle_dsgvo( elm ) {
//console.info(elm);
            if ( elm.checked == true ) {
                document.getElementById('dsgvo_status').style.display = 'block';
            }
            else  {
                document.getElementById('dsgvo_status').style.display = 'none';
            }
    }
    var dsgvo = document.getElementById("data_protection");
    if (dsgvo){
        dsgvo.addEventListener("change", function() {
            toggle_dsgvo(dsgvo);
        }, false);
    }
*/
/*
                elm.checked = false;
    myLabels = document.querySelectorAll('.lbl-toggle');
    Array.from(myLabels).forEach(label => {
        label.addEventListener('keydown', e => {
          // 32 === spacebar
          // 13 === enter
          if (e.which === 32 || e.which === 13) {
            e.preventDefault();
            label.click();
          };
        });
    });
*/
});
