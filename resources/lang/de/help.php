<?php
return [
  // Group
  'move_to_group' => 'Zur ausgewählten Gruppe wechseln',
  'group_name' => 'Name der Gruppe als Referenz',

  // Lists
  'list_group' => 'Liste wird unter der ausgewählten Gruppe hinzugefügt',
  'list_name' => 'Name der Liste als Referenz',
  'list_sending_server' => 'Wenn ein Kontakt zur Liste hinzugefügt wird, wird eine E-Mail (Begrüßung, Bestätigung, Abmeldung usw.) an diesen Kontakt gesendet',
  'list_custom_fileds' => 'Während Sie einen Kontakt hinzufügen, können Sie die zusätzlichen Informationen wie Vorname, Nachname, Land usw. zu diesem Kontakt hinzufügen',
  'list_double_optin' => 'Wenn diese Option auf "Ja" gesetzt ist, wird eine Bestätigungs-E-Mail an diesen Kontakt gesendet',
  'list_welcome_email' => 'Wenn Sie eine Willkommens-E-Mail an diesen Kontakt senden möchten',
  'list_unsub_email' => 'Wenn Sie die Abmelde-E-Mail an die Empfänger senden möchten oder nicht, wählen Sie "Ja" oder "Nein".',
  'list_notification' => 'Wenn diese Option auf "Aktiviert" gesetzt ist, wird eine E-Mail an die Adresse "Benachrichtigungs-E-Mail" gesendet',
  'list_notification_email' => 'E-Mail-Adresse, die benachrichtigt wird, wenn ein Kontakt hinzugefügt wird',
  'list_notification_criteria' => 'Benachrichtigungs-E-Mails werden empfangen, wenn die folgenden Kriterien erfüllt sind',
  'list_split' => 'Die Liste wird entsprechend der angegebenen Nummer in viele Listen aufgeteilt',

  // Custom Fields
  'custom_field_name' => 'Name des benutzerdefinierten Felds als Referenz',
  'custom_field_type' => 'Benutzerdefiniertes Feld sieht so aus, als wäre der Typ definiert., wie der Typ definiert ist. Der Typ kann Textfeld, Zahlenfeld, Textbereich, Datumsfeld, Optionsfelder, Kontrollkästchen und Dropdown sein',
  'custom_field_required' => 'Wenn diese Option auf "Erforderlich" gesetzt ist, muss diese Option beim Hinzufügen eines Kontakts ausgefüllt / ausgewählt werden',
  'custom_fields_lists' => 'Das benutzerdefinierte Feld kann Mehrfachlisten zugewiesen werden',

  // contacts
  'contact_list' => 'Der Kontakt wird zur ausgewählten Liste hinzugefügt',
  'contact_email' => 'Kontakt-E-Mailadresse',
  'contact_html' => 'Bei HTML erhält der Kontakt den "HTML" -Inhalt der Sendung. Ansonsten "Text" Inhalt',
  'contact_active' => 'Kontakt wird als "Aktiv" oder "Inaktiv" gewertet',
  'contact_confirmed' => 'Kontakt wird als "Bestätigt" oder "Nicht bestätigt" gewertet',
  'contact_verified' => 'Stellen Sie es gemäß dem Status Ihres Empfängers als "Verifiziert" oder "Nicht verifiziert" ein. "Verifizierter" Kontakt wird für "E-Mail-Verifizierer" übersprungen.',
  'contact_unsubscribed' => 'Kontakt wird als "Abonniert" oder "Abgemeldet" gewertet',
  'contact_import' => 'Datei muss importiert werden',
  'contact_list_import' => 'Kontakte werden in die ausgewählte Liste importiert',
  'contact_duplicate_import' => 'Wenn Sie auf "Überspringen" klicken, werden die vorhandenen Kontakte beim Import übersprungen. Andernfalls werden die vorhandenen Kontakte überschrieben',
  'contact_suppressed_import' => 'Wenn "Nicht erlaubt", werden beim Importieren die zur Unterdrückung gehörenden E-Mails übersprungen. Andernfalls werden die E-Mails importiert, die sogar zur Unterdrückung gehören.',
  'contact_html_import' => 'Bei HTML erhalten die Kontakte den "HTML" -Inhalt der Sendung. Ansonsten "Text" Inhalt',
  'contact_active_import' => 'Kontakte werden als "Aktiv" oder "Inaktiv" eingestuft.',
  'contact_confirmed_import' => 'Kontakte werden als "Bestätigt" oder "Nicht bestätigt" eingestuft.',
  'contact_unsubscribed_import' => 'Kontakte werden als "Abonniert" oder "Abgemeldet" eingestuft.',


  // Broadcast
  'broadcast_group' => 'Broadcast wird unter der ausgewählten Gruppe hinzugefügt',
  'broadcast_name' => 'Name der Sendung als Referenz',
  'broadcast_email_subject' => 'Es wird als E-Mail-Betreff angezeigt. Alle "Shortcodes" können im Betreff der E-Mail verwendet werden',

  // Schedule
  'schedule_name' => 'Name des Zeitplans als Referenz',
  'schedule_broadcast' => 'Broadcast muss gesendet werden',
  'schedule_lists' => 'Die Kampagne wird an die ausgewählten Kontakte in der Liste gesendet',
  'schedule_sending_servers' => 'Die Kampagne wird mit den ausgewählten sendenden Servern gesendet',
  'schedule_send' => 'Entweder wird die Kampagne jetzt (sofort) oder später gesendet',
  'schedule_speed' => 'Verwalten Sie die Sendegeschwindigkeit einer Kampagne',

  // Drip
  'drip_status' => 'Die Drip-Kampagne wird als "Aktiv" oder "Inaktiv" eingestuft.',
  'drip_group' => 'Alle Tropfkampagnen befinden sich in dieser Gruppe und werden beim Planen eines Tropfens verwendet',
  'drip_name' => 'Name der Tropfkampagne als Referenz',
  'drip_broadcast' => 'Broadcast, der an den Kontakt gesendet wird',
  'drip_send' => 'Wenn "Sofort", wird die E-Mail sofort an den Kontakt gesendet, andernfalls wird die E-Mail gemäß der festgelegten Dauer gesendet',

  // Drip Schedule
  'drip_schedule_name' => 'Name des Tropfplans als Referenz',
  'drip_schedule_group' => 'Gruppe eines Tropfens, der geplant werden muss',
  'drip_schedule_lists' => 'Der Tropfen wird auf die ausgewählten Listen angewendet',
  'drip_schedule_sending_server' => 'Es wird verwendet, um eine E-Mail zu senden, wenn die im Tropf definierten Kriterien erfüllt sind',
  'drip_schedule_send_to_existing' => 'Wenn diese Option auf "Ja" gesetzt ist, werden E-Mails an alle ausgewählten Listenkontakte gesendet, auch wenn sie vor dem Erstellen des Tropfens hinzugefügt wurden. Und im Falle von "Nein" werden die E-Mails an die Kontakte gesendet, die nach dem Erstellen des Tropfens hinzugefügt wurden',

  // Spintag
  'spintag_name' => 'Name des Spingtags als Referenz',
  'spintag_values' => 'Einem Spintag können verschiedene Werte zugewiesen werden, die beim Senden automatisch gedreht werden. Verwenden Sie die Eingabetaste für verschiedene Werte',

  // Segments
  'segment_name' => 'Name des Segments als Referenz',
  'segment_lists' => 'Segment wird auf die ausgewählten Listen angewendet',
  'segment_campaigns' => 'Segment wird auf die ausgewählten Kampagnen angewendet',
  'segment_action' => 'Aktion muss auf die ausgewählten Kampagnen angewendet werden',
  'segment_countries' => 'Die Aktion gilt für die ausgewählten Länder',

  // Sending Domain
  'sending_domain_name' => 'Die sendende Domain wird in der "Von E-Mail-Adresse" verwendet, während ein sendender Server hinzugefügt wird. Eine überprüfte Absenderdomäne erhöht das Posteingangsvolumen erheblich',
  'sending_domain_signing' => 'Die DKIM-Signatur wird in einer eindeutigen Textzeichenfolge generiert, dem „Hash-Wert“. Vor dem Senden der E-Mail wird der Hash-Wert mit einem privaten Schlüssel, der DKIM-Signatur, verschlüsselt',

  // Sending Server
  'sending_server_group' => 'Der sendende Server wird unter der ausgewählten Gruppe hinzugefügt',
  'sending_server_name' => 'Name des sendenden Servers als Referenz',
  'sending_server_type' => 'Typ des sendenden Servers',
  'sending_server_from_name' => "Es wird als Absendername für eine Sendung usw. verwendet.\nSpintags können in From Name verwendet werden",
  'sending_server_from_email' => 'Es wird als Absender-E-Mail für eine Sendung usw. verwendet. Es darf nur einen Namen wie "john" enthalten',
  'sending_server_reply_email' => 'Es wird als Antwort-E-Mail für eine Sendung usw. verwendet.',
  'sending_server_bounce' => 'Im Falle eines Bounce wird die Mail an die ausgewählte Bounce-Adresse gesendet',
  'sending_server_speed' => 'Verwalten Sie die Sendegeschwindigkeit eines sendenden Servers',

  // Bounces
  'bounce_email' => 'Bounce-E-Mails werden als Referenz verwendet',
  'bounce_method' => 'Es wird verwendet, um die E-Mails aus einer Bounce-Mailbox zu lesen',
  'bounce_host' => 'Hostname der Bounce-Mailbox',
  'bounce_username' => 'Bounce-Mailbox-Benutzername',
  'bounce_password' => 'Passwort für Bounce-Mailbox',
  'bounce_port' => 'Bounce-Mailbox-Port',
  'bounce_encryption' => 'Bounce-Mailbox-Verschlüsselungsoption',
  'bounce_cert' => 'Bounce Mailbox Zertifikat Option',
  'bounce_delete' => 'Wenn dies auf "Ja" gesetzt ist, wird eine E-Mail nach dem Vorgang aus der Bounce-Mailbox gelöscht',

  // FBL
  'fbl_email' => 'Feedback-Loop-E-Mail wird als Referenz verwendet',
  'fbl_method' => 'Es wird verwendet, um die E-Mails aus einem Feedback-Loop-Postfach zu lesen',
  'fbl_host' => 'Hostname der Feedback-Loop-Mailbox',
  'fbl_username' => 'Benutzername der Feedback-Loop-Mailbox',
  'fbl_password' => 'Feedback-Loop-Mailbox-Passwort',
  'fbl_port' => 'Rückkopplungsschleifen-Mailbox-Port',
  'fbl_encryption' => 'Mailbox-Verschlüsselungsoption für Feedback-Loop',
  'fbl_cert' => 'Option für Feedback-Loop-Postfachzertifikat',
  'fbl_delete' => 'Wenn dies auf "Ja" gesetzt ist, wird eine E-Mail nach dem Vorgang aus dem Postfach der Feedback-Schleife gelöscht',

  // Suppression
  'suppression_group' => 'Die Unterdrückung wird unter der ausgewählten Gruppe hinzugefügt',
  'suppression_option' => 'Fügen Sie entweder manuell E-Mail-Adressen hinzu oder importieren Sie eine Datei',
  'suppression_emails' => 'Mehrere E-Mails können gleichzeitig mit einem Komma oder einer E-Mail pro Zeile hinzugefügt werden',
  'suppression_file' => 'Die Importdatei muss eine E-Mail pro Zeile enthalten',

  // WebForm 
  'webform_name' => 'Name des Webformulars als Referenz',
  'webform_duplicate' => 'Wenn Sie auf "Überspringen" klicken, werden die vorhandenen Kontakte übersprungen, wenn Sie einen Kontakt über das Webformular hinzufügen. Andernfalls wird der vorhandene Kontakt überschrieben',
  'webform_list' => 'Der Kontakt wird der ausgewählten Liste hinzugefügt, wenn er über das Webformular hinzugefügt wird',
  'webform_custom_fields' => 'Welche zusätzlichen Felder für ein Webformular zusammen mit dem Standardfeld für die E-Mail-Adresse angezeigt werden sollen',

  // Settings
  'license_key' => 'Anwendungslizenzschlüssel',
  'app_url' => 'Anwendungs-URL',
  'app_name' => 'Anwendungsname',
  'top_left_html' => 'Nach der Anmeldung wird es oben links in der Anwendung angezeigt',
  'login_html' => 'Es wird auf der Anmeldeseite rechts über Anmeldefelder angezeigt',
  'login_page_image' => 'Dieses Bild wird auf der Anmeldeseite rechts angezeigt',
  'settings_sending_server' => 'Anwendungsbenachrichtigungen und vergessene Kennwörter wie E-Mails werden mit diesen E-Mail-Einstellungen gesendet',
  'settings_tracking' => 'Die Anwendung wird geöffnet und die Klickverfolgung wird mit dieser Option verwaltet',
  'api_active' => 'Dadurch wird die API-Funktion für die Anwendung aktiviert',
  'mail_headers' => '<small>Alle Shortcodes können im benutzerdefinierten Mail-Header-Wert verwendet werden</small>',

  // Page
  'page_email_subject' => 'Es wird als E-Mail-Betreff angezeigt. Alle "Shortcodes" können im Betreff der E-Mail verwendet werden',

  // General
  'test_send_email' => 'E-Mail-Adresse des Empfängers',
  'test_send_sending_server' => 'Die E-Mail wird über den ausgewählten Sendeserver gesendet',

  // PowerMTA
  'pmta_server_name' => 'Name eines Servers als Referenz',
  'pmta_server_os' => 'Name des Betriebssystems, auf dem PowerMTA installiert ist',
  'pmta_server_ip' => 'Server IP, auf dem PowerMTA installiert ist',
  'pmta_server_port' => 'Server Port',
  'pmta_server_username' => 'Server-Benutzername',
  'pmta_server_password' => 'Server-Passwort',

  'pmta_smtp_host' => 'SMTP-Host des Servers',
  'pmta_smtp_port' => 'SMTP-Port',
  'smtp_encryption' => 'SMTP-Verschlüsselung',
  'pmta_path' => 'Pfad des installierten PowerMTA',
  'pmta_management_port' => 'PowerMTA-Server-Port für HTTP-Zugriff',
  'pmta_admin_ips' => 'Durch Komma (,) getrennte IP-Liste für Administratorzugriff',
  'pmta_log_file_path' => 'PowerMTA-Protokolldateipfad',
  'pmta_acct_file_path' => 'PowerMTA-Abrechnungsdateipfad',
  'pmta_diag_file_path' => 'PowerMTA-Diagnosedateipfad',
  'pmta_spool_path' => 'PowerMTA-Spoolpfad',
  'pmta_dkim_path' => 'PowerMTA DKIM-Dateipfad',
  'pmta_vmta_prefix' => 'Virtuelles MTA-Präfix',
  'pmta_ips' => 'Liste der durch Komma getrennten IPs (,)',
  'pmta_domains' => 'Liste der durch Komma getrennten Domains (,)',
  'pmta_from_name' => 'Von der Namensanzeige als Absendername zu einer E-Mail',
  'pmta_from_email' => 'Es wird als Absender-E-Mail verwendet',
  'pmta_bounce_email' => 'Im Falle eines Bounce wird die E-Mail an diese Bounce-Adresse zurückgesendet',
  'pmta_reply_email' => 'Es wird als Antwort-E-Mail-Adresse verwendet.',

  'pmta_bounce_method' => 'Es wird als Methode zum Lesen der E-Mails aus einer Bounce-Mailbox verwendet',
  'pmta_bounce_host' => 'Hostname der Bounce-Mailbox',
  'pmta_bounce_port' => 'Bounce-Mailbox-Port',
  'pmta_bounce_username' => 'Bounce Mailbox Benutzername',
  'pmta_bounce_password' => 'Bounce Mailbox Passwort',
  'pmta_bounce_encryption' => 'BUnze Mailbox-Verschlüsselungsoption',
  'pmta_bounce_validate_cert' => 'Option für Bounce-Postfachzertifikat',

  'client_lists' => 'Listen werden nur zum Senden an den Client verwendet',
  'client_sending_servers' => 'Das Senden von Servern wird nur zum Senden an den Client verwendet',
  'no_of_recipients' => 'Anzahl der Empfänger, die der Client hinzufügen darf, -1 für unbegrenzt',
  'no_of_sending_servers' => 'Keine der sendenden Server, die der Client hinzufügen darf, -1 für unbegrenzt',
  'package_name' => 'Name des Pakets als Referenz',
  'package_description' => 'Beschreibung des Pakets',

  'webhook_help_heading' => 'Lieferberichte verarbeiten für ',
  'webhook_help_mailgun' => "
    <ol>
      <li><a href='https://login.mailgun.com/login/' target='_blank'>Anmeldung</a> zu Ihrem Mailgun-Konto</li>
      <li>Navigieren Sie zu <b> Sendings >> Webhooks</b></li>
      <li>Wählen Sie die richtige Domain in Mailgun aus</li>
      <li>Kopieren Sie die 'Webhook-URL' und fügen Sie sie in die 'Webhook-Ereignisse' ein, die Sie verarbeiten möchten, z.<br>
      Permanent Failure, Temporary Failure, Spam Complaints, etc.</li>
    </ol>",

    'webhook_help_sendgrid' => "
    <ol>
      <li><a href='https://app.sendgrid.com/login/' target='_blank'>Anmeldung</a> zu Ihrem SendGrid-Konto</li>
      <li>Navigieren Sie zu <b>Settings >> Mail Settings</b></li>
      <li>Aktivieren Sie Event Webhook, wählen Sie alle Aktionen aus und geben Sie die 'Webhook-URL' ein.</li>
    </ol>",

  'bulk_update_based_on' => 'Entweder kann es global sein (gilt für alle Listen) oder als einzelne Liste',
  'bulk_update_option' => 'Fügen Sie die E-Mails entweder manuell hinzu oder importieren Sie sie direkt, um die Empfänger zu aktualisieren',
  'bulk_update_lists' => 'Die Empfänger der ausgewählten Listen werden aktualisiert',
  'bulk_update_emails' => 'In diesem Textfeld können Sie mehrere durch Kommas oder Zeilen getrennte E-Mails hinzufügen',
  'bulk_update_file' => 'Die Datei muss eine E-Mail pro Zeile enthalten, um genau aktualisiert zu werden',
  'bulk_update_action' => 'Die Aktion würde für die Empfänger ausgeführt',

  'verify_list' => 'Die Liste muss überprüft werden',
  'email_verifiers_type' => 'Verifikationsverfahren',
  'list_clean_options' => 'Wählen Sie Ihre Optionen aus, um die Liste zu bereinigen',
  'contact_bounced_import' => 'Wenn "Nicht erlaubt", überspringt der Import die E-Mails, die zu bounce gehören. Andernfalls werden die E-Mails importiert, die sogar zu den zurückgesendeten E-Mails gehören.',

  'bounced_recipients' => 'Die Änderung wirkt sich auf alle aktuellen und zukünftigen Empfänger aus',
  'spam_recipients' => 'Die Änderung wirkt sich auf alle aktuellen und zukünftigen Empfänger aus',
  'suppressed_recipients' => 'Die Änderung wirkt sich auf alle aktuellen und zukünftigen Empfänger aus',

  'max_upload_file_size' => 'Dadurch wird das maximale Upload-Limit für die Dateigröße eingeschränkt',
  'sending_server_tracking_domain' => 'Es wird verwendet, um E-Mail-Aktivitäten wie Öffnen, Klicken usw. zu verfolgen. Es wird empfohlen, eine Tracking-Domain zu verwenden, die in MailCarry überprüft wird, und sicherzustellen, dass das Tracking in "Einstellungen" auf "Aktiviert" gesetzt ist',

  'trigger_name' => 'Name des Auslösers als Referenz',
  'trigger_based_on' => 'Der Trigger kann auf der Basis von Listen, Segmenten (Kriterien) oder auf einer bestimmten Basis ausgeführt werden',
  'trigger_lists' => 'Die Empfänger der ausgewählten Liste (n) erhalten die Kampagne bei einem Auslöseanruf',
  'trigger_based_on_list_action' => 'Wenn die Aktion "Nur neu hinzugefügt" lautet, erhält die Kampagne die Empfänger, die nach dem Erstellen des Auslösers hinzugefügt wurden. Wenn die Aktion "Alle zuvor und neu hinzugefügt" lautet, erhält die Kampagne alle Empfänger, die bereits in der Liste vorhanden sind und wird später hinzugefügt, wenn ein Tropfen erstellt wird',
  'trigger_segment' => 'Die Empfänger des ausgewählten Segments (Kriterien) erhalten die Kampagne bei einem Auslöseanruf',
  'trigger_based_on_segment_action' => 'Wenn die Aktion "Nur neu hinzugefügt" lautet, wird die Kampagne an die Empfänger gesendet, die nach dem Erstellen des Auslösers hinzugefügt wurden. Wenn die Aktion "Alle zuvor und neu hinzugefügt" lautet, wird die Kampagne an alle Empfänger gesendet, die bereits in der Liste und vorhanden sind wird später hinzugefügt, wenn ein Tropfen erstellt wird',
  'trigger_send_date_time' => 'Die Empfänger erhalten die E-Mails ab dem bestimmten Datum',
  'trigger_action' => 'Entweder möchten Sie "Campaign" oder "Start Drip" senden (Serie der Kampagne, die über das Modul "Drip" erstellt wurde)',
  'trigger_broadcast' => 'Empfänger erhalten diese Kampagne, wenn der Auslöser aufgerufen wird',
  'trigger_drip' =>  'Empfänger erhalten diese Reihe von Kampagnen, wie im Modul "Tropf" angegeben, wenn der Auslöser aufgerufen wird',
  'trigger_start' => 'Wenn die Kampagne entweder "Sofort" oder nach einem bestimmten Zeitraum gestartet werden muss. Hinweis: Das Erstellungsdatum des Empfängers wird für den Auslösezeitraum berücksichtigt',
  'trigger_sending_servers' => 'Der ausgewählte Sendeserver wird zum Senden der Kampagne oder des Tropfens verwendet. Wenn viele Sendeserver ausgewählt sind, wird einer zufällig ausgewählt',

  'webhook_help_elastic_email' => "
    <ol>
      <li><a href='https://elasticemail.com/account' target='_blank'>Login</a> zu Ihrem ElasticEmail-Konto</li>
      <li>Navigieren Sie zu <b>Settings >> Notifications</b></li>
      <li>Neuen Webhook hinzufügen</li>
      <li>Kopieren Sie die 'Webhook-URL' und fügen Sie sie in den 'Benachrichtigungslink' ein.</li>
      <li>Überprüfen Sie die Optionen für 'Complaints, Bounce/Error'</li>
      <li>Klicken Sie auf Speichern</li>
    </ol>",

    'dkim_selector' => 'Verwenden Sie einen benutzerdefinierten DKIM-Selektor',
    'dmarc_selector' => 'Verwenden Sie einen benutzerdefinierten DMARC-Selektor',
    'tracking_selector' => 'Verwenden Sie einen benutzerdefinierten Tracking-Selektor',

    'webhook_help_elastic_email' => "
    <ol>
      <li><a href='https://elasticemail.com/account' target='_blank'>Login</a> to your ElasticEmail account</li>
      <li>Navigate to <b>Settings >> Notifications</b></li>
      <li>Add new Webhook</li>
      <li>Copy the 'Webhook URL' and paste to the 'Notification Link'</li>
      <li>Check options for 'Complaints, Bounce/Error'</li>
      <li>Click Save</li>
    </ol>",

    'dkim_selector' => 'Verwenden Sie einen benutzerdefinierten DKIM-Selektor',
    'dmarc_selector' => 'Verwenden Sie einen benutzerdefinierten DMARC-Selektor',
    'tracking_selector' => 'Verwenden Sie einen benutzerdefinierten Tracking-Selektor',

    'webhook_help_amazon_ses' => "
    <b>Configure Amazon SES to send bounce/complaint information to Amazon SNS</b>
    <ol>
      <li><a href='https://console.aws.amazon.com/ses/' target='_blank'>Login</a> to Amazon SES console</li>
      <li>Click on <strong>Configuration Sets</strong></li>
      <li>Click on the <strong>'Create Configuration Set'</strong> button and define a name e.g <strong>MailCarry-Reports</strong>. (<strong>Note:</strong> This configuration set name will be used later within MailCarry)</li>
      <li>Click on the recently created Configuration Set</li>
      <li>In <strong>'Add Destination'</strong> and choose <strong>SNS</strong> from the dropdown</li>
      <li>Write a name e.g<strong> MailCarrySNS</strong> and select the event types you want to process. 
      <ul>
        <li>Reject</li>
        <li>Bounce</li>
        <li>Complaint</li>
        <li>Rendering Failure</li>
      </ul>
      </li>
      <li>From the Topic dropdown, select <strong>'Create SNS Topic'</strong></li>
      <li>Define a <strong>Topic Name</strong> e.g <strong>MailCarry-SNS-Topic</strong> and <strong>Display Name</strong></li>
      <li>Press <strong>Save</strong></li>
    </ol>
    <br>
    <b>Create a topic and subscription in Amazon SNS</b>
    <ol>
      <li>Now Navigate to <a href='https://console.aws.amazon.com/sns/v3' target='_blank'>Amazon Simple Notification Service (SNS)</a></li>
      <li><strong>Navigate</strong> to Topics</li>
      <li>Click on the <strong>recently created</strong> topic</li>
      <li>Click on <strong>'Create Subscription</strong> button</li>
      <li>Use the correct protocol i.e <strong>HTTP or HTTPS</strong></li>
      <li>For <b>Endpoint</b>, enter the <strong>'Webhook URL'</strong> [<strong>APP_URL]/callback/amazon</strong>] showing within MailCarry.</li>
      <li>Choose <b>Create subscription</b>.</li>
      <li>Select created subscription <b>eg. MailCarry-SNS</b> click <b>Request Confirmation</b></li>
      <li><b>Open</b> a file from <b> <a href='APP_URL/storage/amazonsns.txt' target='_blank'>APP_URL/storage/amazonsns.txt</a></b></li>
      <li><b>Copy</b> all contents from the file</li>
      <li><b>Paste</b> it to browser URL in new window, Once you see the confirmed message in <strong>XML format</strong>, it means the confirmation was successful!</li>
    </ol>

    <h5>You are all set now. Now copy the <strong>Configuration Set Name</strong> e.g <strong>MailCarry-Reports</strong> you created recently and
    paste it to <strong>Configuration Set Name</strong>.<h5>",

    'schedule_speed' => 'Gérez la vitesse d\'envoi de ce déclencheur. Dans le cas de "Illimité", le système tente d\envoyer autant qu\'il le peut dans le court laps de temps possible, en utilisant les ressources disponibles',

    'pmta_dkim_selector' => 'Verwenden Sie einen benutzerdefinierten DKIM-Selektor',
    'pmta_dmarc_selector' => 'Verwenden Sie einen benutzerdefinierten DMARC-Selektor',
    'pmta_tracking_selector' => 'Verwenden Sie die benutzerdefinierte Tracking-Auswahl',
    'bounce_pmta_file' => 'Wenn Sie die Bounces nur aus PowerMTA-Protokolldateien verarbeiten möchten, wählen Sie diese Option aus',

    'webform_welcome_email' => 'Diese E-Mail wird als "Willkommens-E-Mail" an den Abonnenten gesendet.',
    'webform_thankyou_page' => 'Diese Seite wird dem Abonnenten als "Dankesseite" angezeigt.',
    'webform_confirmation_email' => 'Diese E-Mail wird als "Bestätigungs-E-Mail" an den Abonnenten gesendet.',
    'webform_confirmation_page' => 'Diese Seite wird dem Abonnenten als "Bestätigungsseite" angezeigt.',
    'webform_confirmation_help' => "<strong> Hinweis: </ strong> Die Bestätigungsseite / E-Mail-Adresse funktioniert für Double-Opt-In-Listen",
    'thankyou_page_option' => 'Wenn die Option als "Systemdefinierte Dankesseite" festgelegt ist, landet der Abonnent auf der Dankeseite, wie in MailCarry definiert, und wenn die Option als "Benutzerdefinierte Seiten-URL" festgelegt ist, landet der Abonnent auf der Seite, die wird im folgenden Feld für die Seiten-URL definiert',
    'confirmation_page_option' => 'Wenn die Option als "Systemdefinierte Dankesseite" festgelegt ist, landet der Abonnent auf der Bestätigungsseite, wie in MailCarry definiert, und wenn die Option als "Benutzerdefinierte Seiten-URL" festgelegt ist, landet der Abonnent auf der entsprechenden Seite nach Bestätigung im Feld Seiten-URL definiert werden',

    'trigger_run' => 'Wann startet der Trigger?',
    'trigger_execute_date_time' => 'Wann der Trigger zur Verarbeitung gestartet wird',

    'list_confirmation_email_id' => 'Wenn die Option "Double Opt-In" auf "Ja" gesetzt ist, sendet das System diese Bestätigungs-E-Mail nach dem Double-Opt-In-Verfahren des Abonnements an die Empfänger',
    'list_welcome_email_id' => 'Wenn "Willkommens-E-Mail" auf "Ja" gesetzt ist, sendet das System die Willkommens-E-Mail an die Empfänger',
    'list_unsub_email_id' => 'Wenn die Option "E-Mail abbestellen" auf "Ja" gesetzt ist, sendet das System die E-Mail zum Abbestellen an die Empfänger',

    'login_background_color' => 'Hintergrundfarbe der Anmeldeseite',
    'trigger_status' => 'Für das Senden wird nur der Auslöser "Aktiv" berücksichtigt. Der Auslöser mit dem Status "Inaktiv" wird übersprungen',
];